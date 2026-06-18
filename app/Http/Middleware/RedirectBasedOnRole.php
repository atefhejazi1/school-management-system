<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

/**
 * "ضابط حركة المرور" بين لوحة تحكم منشئ المنصة (Super Admin) ولوحة تحكم المدرسة.
 *
 * يعتمد القرار كلياً على عمود users.school_id:
 *   - NULL      → منشئ المنصة العام، ولا يجوز له الوصول لمسارات المدارس العادية.
 *   - NOT NULL  → مستخدم تابع لمدرسة، ولا يجوز له الوصول لمسارات لوحة المنصة (/super-admin/*).
 *
 * كما يقوم هذا الميدلوير بقطع الوصول فوراً عن أي مستخدم تكون مدرسته معلّقة
 * (status = suspended) حتى لو كانت جلسته (session) قائمة من قبل تعليق المدرسة،
 * وبتعليق أي مدرسة انتهت صلاحية اشتراكها (subscription_expires_at) تلقائياً في الخلفية
 * فور رصد ذلك، دون انتظار أي مهمة مجدولة (Scheduled Task).
 */
class RedirectBasedOnRole
{
    public function handle(Request $request, Closure $next): Response
    {
        /** @var \App\Models\User|null $user */
        $user = Auth::guard('web')->user();

        // المسارات الأخرى (تسجيل دخول الطلاب/المعلمين/أولياء الأمور) لا تخص هذا الميدلوير
        if (! $user) {
            return $next($request);
        }

        // ── تعليق المدرسة تلقائياً عند انتهاء صلاحية الاشتراك ──
        // المقارنة تتم داخل isSubscriptionExpired() بين subscription_expires_at والوقت الحالي now()؛
        // نتحقق من هذه الحالة قبل فحص "معلّقة" التالي لإظهار رسالة انتهاء الاشتراك المحددة
        // بدلاً من رسالة التعليق العامة، ولأن المدرسة لم تكن معلّقة بعد عند أول رصد لانتهاء الاشتراك.
        if (
            ! is_null($user->school_id)
            && $user->school
            && ! $user->school->isSuspended()
            && $user->school->isSubscriptionExpired()
        ) {
            // تعليق المدرسة في الخلفية فوراً، دون انتظار أي إجراء يدوي من منشئ المنصة
            $user->school->update(['status' => 'suspended']);

            Auth::guard('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()
                ->route('login')
                ->with('message', 'عذراً، انتهت صلاحية اشتراك هذه المدرسة. يرجى التواصل مع الإدارة العليا لتجديد الباقة.');
        }

        // ── قطع الوصول الفوري عن المدارس المعلّقة (لأي سبب، بما فيه انتهاء الاشتراك سابقاً) ──
        if (! is_null($user->school_id) && $user->school?->isSuspended()) {
            Auth::guard('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()
                ->route('login')
                ->with('message', 'تم تعليق حساب هذه المدرسة، يرجى التواصل مع الإدارة.');
        }

        $isSuperAdminArea = $request->is('super-admin*') || $request->is('*/super-admin*');
        $isSuperAdmin     = $user->isSuperAdmin();

        // منشئ المنصة العام يُعاد توجيهه دائماً إلى لوحة تحكم المنصة
        if ($isSuperAdmin && ! $isSuperAdminArea) {
            return redirect()->route('super-admin.dashboard');
        }

        // مستخدم تابع لمدرسة لا يجوز له الوصول إلى لوحة تحكم المنصة العامة
        if (! $isSuperAdmin && $isSuperAdminArea) {
            abort(403, 'عذراً، لا تملك صلاحية الوصول إلى لوحة تحكم المنصة.');
        }

        return $next($request);
    }
}
