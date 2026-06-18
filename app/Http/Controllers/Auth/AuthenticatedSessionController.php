<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\My_Parent;
use App\Models\students;
use App\Models\Teachers;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */


    public function create($type = null): View
    {
        // $type = null يعني أننا في البوابة الموحدة (/login) التي يستخدمها كل المستخدمين
        // بنفس النموذج تماماً، بصرف النظر عن دورهم؛ أما $type المحدد فهو دعم توافقي
        // مع الروابط القديمة (/login/{type}) التي ما زالت تعمل بنفس الشكل السابق.
        return view('auth.login', compact('type'));
    }

    /**
     * Handle an incoming authentication request via the legacy per-type route (/login/{type}).
     */
    public function store(Request $request, $type)
    {
        $credentials = $request->only('email', 'password');

        // تحديد نوع المستخدم بناءً على الـ $type المرسل
        $guard = match ($type) {
            'student' => 'student',
            'teacher' => 'teacher',
            'parent'  => 'parent',
            default   => 'web',
        };

        if (Auth::guard($guard)->attempt($credentials, $request->boolean('remember'))) {
            return $this->redirectAfterLogin($guard);
        }

        return redirect()->back()->with('message', 'يوجد خطا في كلمة المرور او اسم المستخدم');
    }

    /**
     * Handle an incoming authentication request via the unified gateway (/login).
     *
     * البوابة الموحدة: نحاول تسجيل الدخول على كل الحراس بالتتابع (مدير/منشئ منصة، معلم، طالب، ولي أمر)
     * لأن المستخدم نفسه قد يكون أياً منهم، وكلٌ منهم محفوظ في جدول مستقل خاص به. التمييز بين
     * منشئ المنصة العام ومدير المدرسة يحدث صامتاً بعد المصادقة بناءً على school_id فقط.
     */
    public function storeUnified(Request $request): RedirectResponse
    {
        $credentials = $request->only('email', 'password');
        $remember = $request->boolean('remember');

        // نختبر الحراس الأربعة بالتتابع بالترتيب التالي: web (منشئ المنصة/مدير المدرسة)،
        // ثم teacher، ثم student، ثم parent — لأن المستخدم نفسه قد يكون أياً منهم،
        // وكلٌّ منهم محفوظ في جدول مستقل خاص به (Multi-Guard).
        foreach (['web', 'teacher', 'student', 'parent'] as $guard) {
            if (Auth::guard($guard)->attempt($credentials, $remember)) {
                // إعادة توليد معرّف الجلسة فوراً عند أول نجاح لمنع ثبات الجلسة
                // (Session Fixation) قبل أي إعادة توجيه نحو لوحة التحكم المخصصة
                $request->session()->regenerate();

                return $this->redirectAfterLogin($guard);
            }
        }

        // فشلت المحاولة على الحراس الأربعة معاً: رسالة خطأ موحّدة واحدة بصرف النظر عن السبب الحقيقي
        // (لا نكشف للمستخدم أي تفصيل عن أي حارس بالتحديد فشل، لتفادي تسريب معلومات عن نوع الحساب)
        return redirect()->back()->with('message', 'بيانات الدخول غير صحيحة، يرجى التحقق من البريد الإلكتروني وكلمة المرور.');
    }

    /**
     * يقرر الوجهة الصحيحة بعد نجاح المصادقة بناءً على الحارس (Guard) الذي نجحت عليه المحاولة.
     */
    private function redirectAfterLogin(string $guard): RedirectResponse
    {
        if ($guard !== 'web') {
            return redirect()->intended("/{$guard}/dashboard");
        }

        /** @var User $authenticatedUser */
        $authenticatedUser = Auth::guard('web')->user();

        // إذا كانت مدرسة هذا المستخدم معلّقة من قِبل الإدارة، يُمنع من تسجيل الدخول فوراً
        if (! is_null($authenticatedUser->school_id) && $authenticatedUser->school?->isSuspended()) {
            Auth::guard('web')->logout();

            return redirect()->route('login')->with(
                'message',
                'تم تعليق حساب هذه المدرسة، يرجى التواصل مع الإدارة.'
            );
        }

        // التمييز بين منشئ المنصة العام (Super Admin) ومستخدمي المدارس بناءً على school_id
        if ($authenticatedUser->isSuperAdmin()) {
            return redirect()->intended(route('super-admin.dashboard'));
        }

        return redirect()->intended(route('dashboard'));
    }


    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request, $type)
    {

        if (!in_array($type, ['student', 'teacher', 'parent', 'web'])) {
            abort(404);
        }

        Auth::guard($type)->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/'); // أو أي صفحة أخرى تحب يرجع لها بعد تسجيل الخروج

    }
}
