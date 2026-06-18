<?php

namespace App\Livewire\SuperAdmin;

use App\Mail\SchoolApproved;
use App\Models\School;
use App\Models\SchoolRegistration;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class SchoolRequests extends Component
{
    use WithPagination;

    public string $search       = '';
    public string $filterStatus = '';

    // ── نافذة الرفض (تحتاج حقل نصي، لذا لا تستخدم نافذة التأكيد العامة) ──
    public bool   $showRejectModal = false;
    public ?int   $rejectingId     = null;
    public string $rejectReason    = '';

    // ── نافذة عرض كامل تفاصيل الطلب (الهاتف، عدد الطلاب، الرسالة، ملاحظات الإدارة) ──
    public bool                $showDetailsModal = false;
    public ?SchoolRegistration $detailsRecord    = null;

    // ── بيانات اعتماد المدرسة التي تمت الموافقة عليها للتو ──────────────
    // تُعرض مرة واحدة فقط مباشرة في الواجهة فور الموافقة (بدلاً من الاعتماد فقط على
    // سجلّ البريد)، ولا تُخزَّن بشكل دائم في قاعدة البيانات؛ هي خصائص عامة (Public Properties)
    // مؤقتة تعيش طوال عمر مكوّن Livewire هذا حتى يُغلقها المستخدم يدوياً عبر dismissApprovedCredentials().
    public ?int    $justApprovedId         = null;
    public ?string $justApprovedSchoolName = null;
    public ?string $justApprovedEmail      = null;
    public ?string $justApprovedPassword   = null;
    public ?string $justApprovedPhone      = null;

    protected $queryString = [
        'search'       => ['except' => ''],
        'filterStatus' => ['except' => ''],
    ];

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingFilterStatus(): void
    {
        $this->resetPage();
    }

    /**
     * الموافقة على طلب تسجيل مدرسة:
     * يتم تنفيذ جميع الخطوات داخل معاملة قاعدة بيانات واحدة (DB Transaction)
     * لضمان عدم إنشاء مدرسة أو حساب مدير دون اكتمال جميع الخطوات معاً.
     */
    #[On('doApproveSchool')]
    public function doApproveSchool(int $id): void
    {
        $registration = SchoolRegistration::findOrFail($id);

        // منع الموافقة المزدوجة على طلب تمت معالجته مسبقاً
        if ($registration->status !== 'pending' || $registration->school_id) {
            session()->flash('error', 'هذا الطلب تمت معالجته مسبقاً.');

            return;
        }

        // فحص تفرّد اسم المدرسة: نمنع وجود مدرستين بنفس الاسم على المنصة قبل أي إنشاء فعلي
        if (School::where('name', $registration->school_name)->exists()) {
            session()->flash('error', 'يوجد مدرسة أخرى مسجّلة بالفعل بهذا الاسم على المنصة، يرجى مراجعة الطلب قبل الموافقة.');

            return;
        }

        $temporaryPassword = $this->generateSecureTemporaryPassword();

        // الخطوات الأربع تُنفَّذ معاً داخل معاملة واحدة، وتُعاد النتيجة بدلاً من
        // الاعتماد على متغيرات مرجعية (by-reference) خارج الـ Closure
        [$newSchool, $newUser] = DB::transaction(function () use ($registration, $temporaryPassword) {
            // الخطوة 1: توليد رابط (slug) فريد للمدرسة من اسمها
            $baseSlug = Str::slug($registration->school_name);
            $slug     = $baseSlug;
            $suffix   = 1;
            while (School::where('slug', $slug)->exists()) {
                $slug = $baseSlug . '-' . $suffix++;
            }

            // الخطوة 2: إنشاء سجل المدرسة الرسمي بحالة "نشطة" فوراً عند القبول
            $newSchool = School::create([
                'name'          => $registration->school_name,
                'slug'          => $slug,
                'company_email' => $registration->email,
                'phone'         => $registration->phone,
                'status'        => 'active',
            ]);

            // الخطوة 3: إنشاء حساب مدير المدرسة الجديد وربطه بالمدرسة عبر school_id.
            // لا يوجد عمود "role" منفصل: ربط المستخدم بـ school_id محدد هو ما يمنحه
            // صلاحيات "مدير مدرسة" تلقائياً (راجع User::isSchoolAdmin()).
            $newUser = User::create([
                'name'      => $registration->contact_name,
                'email'     => $registration->email,
                'password'  => bcrypt($temporaryPassword),
                'school_id' => $newSchool->id,
            ]);

            // الخطوة 4: تحديث حالة طلب التسجيل إلى "مقبول" وربطه بسجل المدرسة الجديد
            $registration->update([
                'status'    => 'approved',
                'school_id' => $newSchool->id,
            ]);

            return [$newSchool, $newUser];
        });

        // إرسال بريد بيانات تسجيل الدخول (رابط البوابة الموحدة + البريد + كلمة المرور المؤقتة)
        // بعد تأكيد نجاح المعاملة، وخارجها تماماً لتجنب تعليق المعاملة بسبب تأخر الشبكة
        try {
            Mail::to($newUser->email)->send(new SchoolApproved($newSchool, $newUser->email, $temporaryPassword));
        } catch (\Exception) {
            // فشل إرسال البريد لا يجب أن يتراجع عن إنشاء الحساب
        }

        // نخزّن بيانات الاعتماد في خصائص عامة مؤقتة لعرضها فوراً في الواجهة (نسخ / واتساب)،
        // بدلاً من إجبار المسؤول على فتح سجلّ البريد الإلكتروني للحصول عليها
        $this->justApprovedId         = $newSchool->id;
        $this->justApprovedSchoolName = $newSchool->name;
        $this->justApprovedEmail      = $newUser->email;
        $this->justApprovedPassword   = $temporaryPassword;
        $this->justApprovedPhone      = $registration->phone;

        session()->flash('success', 'تمت الموافقة على طلب مدرسة "' . $registration->school_name . '" وتفعيل حسابها بنجاح.');
    }

    /**
     * إغلاق لوحة بيانات الاعتماد المعروضة بعد الموافقة (نظافة الواجهة فقط، لا تؤثر على الحساب).
     */
    public function dismissApprovedCredentials(): void
    {
        $this->justApprovedId         = null;
        $this->justApprovedSchoolName = null;
        $this->justApprovedEmail      = null;
        $this->justApprovedPassword   = null;
        $this->justApprovedPhone      = null;
    }

    /**
     * رابط بوابة تسجيل الدخول الموحدة (/login) — يُستخدم نفسه لكل المستخدمين
     * (منشئ المنصة، مدير المدرسة، المعلم، الطالب، ولي الأمر)، والتمييز بين الأدوار
     * يحدث صامتاً في الباك-إند بعد المصادقة فقط.
     */
    public function justApprovedLoginUrl(): string
    {
        return route('login');
    }

    /**
     * توليد رابط واتساب (WhatsApp API) جاهز لإرسال رسالة ترحيب منسّقة بالعربية
     * تحتوي على بيانات الدخول الخاصة بمدير المدرسة الجديد. تُعاد null إذا لم يكن
     * هناك رقم هاتف مسجَّل على طلب التسجيل.
     */
    public function justApprovedWhatsappUrl(): ?string
    {
        if (! $this->justApprovedPhone) {
            return null;
        }

        // واتساب يتطلب رقم الهاتف بصيغة دولية وأرقام فقط (بدون +، 00، مسافات أو شرطات)
        $digitsOnly = preg_replace('/\D/', '', $this->justApprovedPhone);

        $message = "مرحباً بكم في نظام إدارة المدارس\n\n"
            . "تمت الموافقة على طلب تسجيل مدرسة \"{$this->justApprovedSchoolName}\" وتم تفعيل حسابكم بنجاح.\n\n"
            . "بيانات الدخول الخاصة بكم:\n"
            . "البريد الإلكتروني: {$this->justApprovedEmail}\n"
            . "كلمة المرور المؤقتة: {$this->justApprovedPassword}\n\n"
            . "رابط تسجيل الدخول إلى المنصة (بوابة موحدة لجميع المستخدمين):\n"
            . $this->justApprovedLoginUrl() . "\n\n"
            . 'يرجى تغيير كلمة المرور فور تسجيل الدخول لأول مرة لضمان أمان الحساب.';

        return 'https://api.whatsapp.com/send?phone=' . $digitsOnly . '&text=' . rawurlencode($message);
    }

    /**
     * توليد كلمة مرور مؤقتة عشوائية وآمنة من 12 خانة، تحتوي وجوباً على حرف صغير
     * وحرف كبير ورقم ورمز خاص على الأقل، باستخدام random_int (مولّد عشوائي آمن
     * تشفيرياً CSPRNG) لكل من اختيار المحارف وترتيبها (Fisher–Yates).
     */
    private function generateSecureTemporaryPassword(int $length = 12): string
    {
        $lower   = 'abcdefghijklmnopqrstuvwxyz';
        $upper   = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $digits  = '0123456789';
        $symbols = '!@#$%^&*-_=+';
        $all     = $lower . $upper . $digits . $symbols;

        // نضمن وجود محرف واحد على الأقل من كل فئة
        $chars = [
            $lower[random_int(0, strlen($lower) - 1)],
            $upper[random_int(0, strlen($upper) - 1)],
            $digits[random_int(0, strlen($digits) - 1)],
            $symbols[random_int(0, strlen($symbols) - 1)],
        ];

        for ($i = count($chars); $i < $length; $i++) {
            $chars[] = $all[random_int(0, strlen($all) - 1)];
        }

        // خلط آمن تشفيرياً (Fisher–Yates) بدلاً من shuffle() غير الآمنة
        for ($i = count($chars) - 1; $i > 0; $i--) {
            $j = random_int(0, $i);
            [$chars[$i], $chars[$j]] = [$chars[$j], $chars[$i]];
        }

        return implode('', $chars);
    }

    /**
     * تعليق وصول مدرسة معتمدة إلى المنصة فوراً (تسجيل الدخول يُمنع تلقائياً عبر middleware).
     */
    #[On('doSuspendSchool')]
    public function doSuspendSchool(int $registrationId): void
    {
        $registration = SchoolRegistration::with('school')->findOrFail($registrationId);

        if (! $registration->school) {
            session()->flash('error', 'لا يوجد سجل مدرسة مرتبط بهذا الطلب.');

            return;
        }

        $registration->school->update(['status' => 'suspended']);

        session()->flash('success', 'تم تعليق وصول مدرسة "' . $registration->school_name . '" إلى المنصة.');
    }

    /**
     * إعادة تفعيل مدرسة كانت معلّقة سابقاً.
     */
    #[On('doActivateSchool')]
    public function doActivateSchool(int $registrationId): void
    {
        $registration = SchoolRegistration::with('school')->findOrFail($registrationId);

        if (! $registration->school) {
            session()->flash('error', 'لا يوجد سجل مدرسة مرتبط بهذا الطلب.');

            return;
        }

        $registration->school->update(['status' => 'active']);

        session()->flash('success', 'تمت إعادة تفعيل مدرسة "' . $registration->school_name . '" بنجاح.');
    }

    /**
     * إعادة تعيين كلمة مرور مدير المدرسة وإظهار لوحة بيانات الاعتماد من جديد.
     * كلمة المرور الأصلية لا تُخزَّن أبداً بصيغة قابلة للقراءة (فقط بصيغة bcrypt)،
     * فلا توجد طريقة "لاستعادتها"؛ الحل الوحيد الآمن هو توليد كلمة مرور مؤقتة جديدة
     * كل مرة يحتاج فيها المسؤول لمشاركة بيانات الدخول مجدداً مع مدير المدرسة.
     */
    #[On('doResetAdminPassword')]
    public function doResetAdminPassword(int $registrationId): void
    {
        $registration = SchoolRegistration::with('school')->findOrFail($registrationId);

        if (! $registration->school) {
            session()->flash('error', 'لا يوجد سجل مدرسة مرتبط بهذا الطلب.');

            return;
        }

        $adminUser = User::where('school_id', $registration->school->id)->first();

        if (! $adminUser) {
            session()->flash('error', 'لا يوجد حساب مدير مرتبط بهذه المدرسة.');

            return;
        }

        $temporaryPassword = $this->generateSecureTemporaryPassword();
        $adminUser->update(['password' => bcrypt($temporaryPassword)]);

        try {
            Mail::to($adminUser->email)->send(new SchoolApproved($registration->school, $adminUser->email, $temporaryPassword));
        } catch (\Exception) {
            // فشل إرسال البريد لا يجب أن يمنع إظهار بيانات الاعتماد في الواجهة
        }

        $this->justApprovedId         = $registration->school->id;
        $this->justApprovedSchoolName = $registration->school->name;
        $this->justApprovedEmail      = $adminUser->email;
        $this->justApprovedPassword   = $temporaryPassword;
        $this->justApprovedPhone      = $registration->phone;

        session()->flash('success', 'تم إنشاء كلمة مرور مؤقتة جديدة لمدير مدرسة "' . $registration->school_name . '" بنجاح.');
    }

    /**
     * عرض كامل تفاصيل طلب التسجيل (الهاتف، عدد الطلاب، رسالة مقدّم الطلب، ملاحظات الإدارة)
     * — بيانات كانت متاحة سابقاً فقط في صفحة "طلبات التسجيل" القديمة (مدير المدرسة)، ودُمجت هنا.
     */
    public function openDetails(int $id): void
    {
        $this->detailsRecord    = SchoolRegistration::with('school')->findOrFail($id);
        $this->showDetailsModal = true;
    }

    public function closeDetails(): void
    {
        $this->showDetailsModal = false;
        $this->detailsRecord    = null;
    }

    // ── الرفض (نافذة مخصصة بحقل سبب الرفض) ──────────────────
    public function openReject(int $id): void
    {
        $this->rejectingId     = $id;
        $this->rejectReason    = '';
        $this->showRejectModal = true;
    }

    public function confirmReject(): void
    {
        $this->validate(
            ['rejectReason' => 'required|min:5'],
            [
                'rejectReason.required' => 'يرجى كتابة سبب الرفض.',
                'rejectReason.min'      => 'سبب الرفض يجب أن يكون 5 أحرف على الأقل.',
            ]
        );

        $registration = SchoolRegistration::findOrFail($this->rejectingId);
        $registration->update([
            'status'      => 'rejected',
            'admin_notes' => $this->rejectReason,
        ]);

        $this->showRejectModal = false;
        $this->rejectingId     = null;

        session()->flash('success', 'تم رفض طلب "' . $registration->school_name . '".');
    }

    public function render()
    {
        $query = SchoolRegistration::query()->with('school');

        if ($this->search) {
            $s = $this->search;
            $query->where(fn ($q) => $q
                ->where('school_name', 'like', "%{$s}%")
                ->orWhere('email', 'like', "%{$s}%")
                ->orWhere('contact_name', 'like', "%{$s}%")
            );
        }

        if ($this->filterStatus) {
            $query->where('status', $this->filterStatus);
        }

        $registrations = $query->latest()->paginate(12);

        return view('livewire.super-admin.school-requests', compact('registrations'));
    }
}
