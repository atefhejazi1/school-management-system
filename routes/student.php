<?php



// routes/web.php

use App\Http\Controllers\Students\Dashboard\ExamsController;
use App\Http\Controllers\Students\Dashboard\ProfileController;
use App\Models\Attendance;
use App\Models\Degree;
use App\Models\Fee_invoice;
use App\Models\Online_class;
use App\Models\Question;
use App\Models\Quizze;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Livewire\Livewire;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'web', 'auth:student']
    ],
    function () {
        // 🔐 مسارات الطلاب
        Route::get('/student/dashboard', function () {
            $student = Auth::user();

            // معدّل الحضور = (أيام الحضور الفعلي ÷ إجمالي أيام التسجيل) — null إن لم يُسجَّل حضور بعد
            $attendanceTotal = Attendance::where('student_id', $student->id)->count();
            $attendancePresent = Attendance::where('student_id', $student->id)->where('attendence_status', 1)->count();
            $attendanceRate = $attendanceTotal > 0 ? round($attendancePresent / $attendanceTotal * 100) : null;

            // المعدل العام = (مجموع الدرجات المُحصَّلة فعلياً ÷ مجموع الدرجات القصوى للأسئلة)
            // لكل الاختبارات التي خضع لها الطالب فقط، وليس كل اختبارات قسمه
            $degrees = Degree::where('student_id', $student->id)->get();
            $takenQuizzeIds = $degrees->pluck('quizze_id')->unique();
            $totalEarned = $degrees->sum('score');
            $totalPossible = Question::whereIn('quizze_id', $takenQuizzeIds)->sum('score');
            $averageScore = $totalPossible > 0 ? round($totalEarned / $totalPossible * 100) : null;

            $invoices = Fee_invoice::where('student_id', $student->id)->latest()->get();
            $feeBalance = $invoices->sum('balance_amount');

            $quizzes = Quizze::where('grade_id', $student->Grade_id)
                ->where('classroom_id', $student->Classroom_id)
                ->where('section_id', $student->section_id)
                ->with('subject', 'exam')
                ->latest()
                ->take(8)
                ->get();

            // مجموع الدرجات القصوى لكل اختبار من قائمة الاختبارات أعلاه فقط، في استعلام واحد
            // بدل استعلام منفصل لكل اختبار (N+1) عند حساب "الدرجة من" في الواجهة
            $quizMaxScores = Question::whereIn('quizze_id', $quizzes->pluck('id'))
                ->selectRaw('quizze_id, sum(score) as total')
                ->groupBy('quizze_id')
                ->pluck('total', 'quizze_id');

            $onlineClasses = Online_class::where('Grade_id', $student->Grade_id)
                ->where('Classroom_id', $student->Classroom_id)
                ->where('section_id', $student->section_id)
                ->where('start_at', '>=', now())
                ->orderBy('start_at')
                ->take(5)
                ->get();

            $attendanceRecords = Attendance::where('student_id', $student->id)
                ->latest('attendence_date')
                ->take(8)
                ->get();

            return view('pages.students.dashboard', [
                'student' => $student,
                'attendanceRate' => $attendanceRate,
                'attendanceTotal' => $attendanceTotal,
                'attendancePresent' => $attendancePresent,
                'averageScore' => $averageScore,
                'degrees' => $degrees,
                'invoices' => $invoices,
                'feeBalance' => $feeBalance,
                'quizzes' => $quizzes,
                'quizMaxScores' => $quizMaxScores,
                'onlineClasses' => $onlineClasses,
                'attendanceRecords' => $attendanceRecords,
            ]);
        })->name('student.dashboard');

        Route::group([], function () {
            // Livewire::setUpdateRoute(function ($handle) {
            //     return Route::post('/livewire/update', $handle);
            // });

            Route::resource('student_exams', ExamsController::class);
            Route::resource('profile-student', ProfileController::class);
        });
    }

);
