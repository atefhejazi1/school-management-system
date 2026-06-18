<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

/**
 * إدارة حسابات منشئي المنصة (Super Admins) الثانويين. الوصول محمي مسبقاً بـ middleware
 * "role.redirect" (تُمنع كل المسارات تحت /super-admin عن أي مستخدم تابع لمدرسة)، ويُعاد
 * التحقق هنا صريحاً كخط دفاع ثانٍ، تحديداً لأن هذه الصفحة تتيح إنشاء حسابات تملك
 * صلاحيات منشئ المنصة الكاملة، فحساسيتها أعلى من باقي صفحات لوحة المنصة.
 */
class SuperAdminUserController extends Controller
{
    public function index(): View
    {
        $this->ensureGenuineSuperAdmin();

        // منشئو المنصة الحاليون: كل مستخدم school_id الخاص به NULL، بصرف النظر عن تاريخ إنشائه
        $superAdmins = User::whereNull('school_id')->latest()->get();

        return view('super-admin.admins.index', compact('superAdmins'));
    }

    public function store(Request $request): RedirectResponse
    {
        $this->ensureGenuineSuperAdmin();

        $validated = $request->validate(
            [
                'name'     => 'required|string|max:255',
                'email'    => ['required', 'email', Rule::unique('users', 'email')],
                'password' => 'required|string|min:8|confirmed',
            ],
            [
                'name.required'     => 'يرجى كتابة الاسم الكامل.',
                'email.required'    => 'يرجى كتابة البريد الإلكتروني.',
                'email.unique'      => 'هذا البريد الإلكتروني مستخدم من قبل.',
                'password.required' => 'يرجى كتابة كلمة المرور.',
                'password.min'      => 'كلمة المرور يجب أن تكون 8 أحرف على الأقل.',
                'password.confirmed' => 'تأكيد كلمة المرور غير مطابق.',
            ]
        );

        // school_id = NULL صريحاً هو ما يمنح هذا المستخدم صلاحيات منشئ منصة عبر
        // User::isSuperAdmin()؛ لا يوجد عمود "role" في هذا النظام (راجع User::isSuperAdmin()).
        User::create([
            'name'      => $validated['name'],
            'email'     => $validated['email'],
            'password'  => Hash::make($validated['password']),
            'school_id' => null,
        ]);

        return redirect()
            ->route('super-admin.admins.index')
            ->with('success', 'تم إنشاء حساب منشئ منصة جديد بنجاح.');
    }

    /**
     * خط الدفاع الثاني: التأكد صريحاً أن المستخدم الحالي منشئ منصة فعلي (school_id IS NULL)،
     * بصرف النظر عن أي تغيير مستقبلي في تعريف المسارات أو الميدلوير المطبَّق عليها.
     */
    private function ensureGenuineSuperAdmin(): void
    {
        abort_unless(is_null(auth()->user()?->school_id), 403, 'عذراً، لا تملك صلاحية الوصول إلى هذه الصفحة.');
    }
}
