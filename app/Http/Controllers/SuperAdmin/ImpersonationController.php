<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

/**
 * انتقال منشئ المنصة (Super Admin) إلى جلسة مدير مدرسة محدد لمعاينة لوحته دون معرفة كلمة مروره،
 * مع الاحتفاظ بهوية منشئ المنصة الأصلية لاستعادتها فور الخروج من المعاينة (leaveImpersonation).
 */
class ImpersonationController extends Controller
{
    /**
     * الدخول كمدير مدرسة معيّن. الوصول لهذا الإجراء محمي مسبقاً بـ middleware "role.redirect"
     * (يقبل فقط مستخدمي school_id = NULL داخل مسارات /super-admin)، ويُعاد التحقق هنا
     * صريحاً كخط دفاع ثانٍ مستقل عن أي تغيير مستقبلي في تعريف المسارات أو الميدلوير.
     */
    public function impersonate(int $schoolAdminId): RedirectResponse
    {
        /** @var User $currentUser */
        $currentUser = auth()->user();

        // خط الدفاع الثاني: التأكد صريحاً أن المستخدم الحالي منشئ منصة فعلي (school_id IS NULL)
        abort_unless(is_null($currentUser->school_id), 403, 'عذراً، لا تملك صلاحية انتحال هوية مستخدم آخر.');

        $schoolAdmin = User::findOrFail($schoolAdminId);

        // لا يجوز انتحال هوية منشئ منصة آخر (school_id = NULL)؛ المعاينة مسموحة فقط لمديري المدارس
        abort_if(is_null($schoolAdmin->school_id), 403, 'لا يمكن انتحال هوية منشئ منصة آخر.');

        // منع معاينة حساب مدرسة معلّقة: ميدلوير role.redirect سيقطع الجلسة فوراً بمجرد أول طلب لاحق
        // (لأن المدرسة معلّقة)، مما يُفقد منشئ المنصة جلسته الأصلية المحفوظة دون أي فائدة من المعاينة.
        if ($schoolAdmin->school?->isSuspended()) {
            return back()->with('error', 'لا يمكن معاينة حساب مدرسة معلّقة الوصول حالياً.');
        }

        // حفظ هوية منشئ المنصة الأصلية في الجلسة لاستعادتها لاحقاً عبر leaveImpersonation()
        session(['original_super_admin_id' => $currentUser->id]);

        Auth::guard('web')->loginUsingId($schoolAdmin->id);

        // إعادة توليد معرّف الجلسة بعد تبديل الهوية لمنع أي ثبات جلسة (Session Fixation)
        request()->session()->regenerate();

        return redirect()->route('dashboard');
    }

    /**
     * الخروج من جلسة المعاينة والعودة فوراً إلى هوية منشئ المنصة الأصلية.
     */
    public function leave(): RedirectResponse
    {
        $originalSuperAdminId = session('original_super_admin_id');

        // لا توجد جلسة معاينة قائمة أصلاً: لا شيء لاستعادته
        if (! $originalSuperAdminId) {
            return redirect()->route('dashboard');
        }

        Auth::guard('web')->logout();
        Auth::guard('web')->loginUsingId($originalSuperAdminId);

        // إفراغ المفتاح المؤقت فوراً بعد استعادة الهوية الأصلية، حتى لا يبقى أثر لجلسة المعاينة السابقة
        session()->forget('original_super_admin_id');
        request()->session()->regenerate();

        return redirect()->route('super-admin.dashboard');
    }
}
