<?php

namespace App\Livewire\SuperAdmin;

use App\Models\School;
use App\Models\SchoolRegistration;
use App\Models\User;
use App\Notifications\SchoolWelcomeNotification;
use Illuminate\Support\Facades\DB;
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

        $temporaryPassword = Str::random(10);

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

            // الخطوة 3: إنشاء حساب مدير المدرسة الجديد وربطه بالمدرسة عبر school_id
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

        // إرسال بريد بيانات تسجيل الدخول بعد تأكيد نجاح المعاملة (خارج المعاملة لتجنب تعليقها بسبب تأخر الشبكة)
        try {
            $newUser->notify(new SchoolWelcomeNotification($newSchool, $temporaryPassword));
        } catch (\Exception) {
            // فشل إرسال البريد لا يجب أن يتراجع عن إنشاء الحساب
        }

        session()->flash('success', 'تمت الموافقة على طلب مدرسة "' . $registration->school_name . '" وتفعيل حسابها بنجاح.');
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
