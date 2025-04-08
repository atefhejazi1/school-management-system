<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
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
        // إذا كانت القيمة فارغة، يمكن تعيين قيمة افتراضية مثل 'student'
        if ($type == null) {
            return view('auth.selection');
        }
        return view('auth.login', compact('type'));
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(Request $request, $type)
    {
        // $request->authenticate();

        // $request->session()->regenerate();

        // return redirect()->intended(route('dashboard', absolute: false));

        $credentials = $request->only('email', 'password');

        // تحديد نوع المستخدم بناءً على الـ $type المرسل
        if ($type == 'student') {
            $guard = 'student';
            $model = students::class;
        } elseif ($type == 'teacher') {
            $guard = 'teacher';
            $model = Teachers::class;
        } elseif ($type == 'parent') {
            $guard = 'parent';
            $model = Parent::class;
        } else {
            $guard = 'web';
            $model = User::class;
        }

        if (Auth::guard($guard)->attempt($credentials)) {
            if ($type == 'student') {
                return redirect()->intended('/student/dashboard');
            } elseif ($type == 'teacher') {
                return redirect()->intended('/teacher/dashboard');
            } elseif ($type == 'parent') {
                return redirect()->intended('/parent/dashboard');
            } else {
                return redirect()->intended('/dashboard');
            }
        }


        return redirect()->back()->with('message', 'يوجد خطا في كلمة المرور او اسم المستخدم');
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
