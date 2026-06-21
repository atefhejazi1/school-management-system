<?php



// routes/web.php

use App\Http\Controllers\Teachers\Dashboard\OnlineZoomClassesController;
use App\Http\Controllers\Teachers\Dashboard\ProfileController;
use App\Http\Controllers\Teachers\Dashboard\QuestionController;
use App\Http\Controllers\Teachers\Dashboard\QuizzesController;
use App\Http\Controllers\Teachers\Dashboard\StudentController;
use App\Models\Attendance;
use App\Models\Online_class;
use App\Models\Quizze;
use App\Models\students;
use App\Models\Teachers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'web', 'auth:teacher']
    ],
    function () {


        // 🔐 مسارات المعلمين
        Route::get('/teacher/dashboard', function () {
            $teacher = Auth::user();
            $sectionIds = Teachers::findorFail($teacher->id)->Sections()->pluck('section_id');

            $countSections = $sectionIds->count();
            $countStudents = students::whereIn('section_id', $sectionIds)->count();
            $countQuizzes = Quizze::where('teacher_id', $teacher->id)->count();

            $upcomingClasses = Online_class::where('created_by', $teacher->id)
                ->where('start_at', '>=', now())
                ->orderBy('start_at')
                ->take(5)
                ->get();
            $countUpcomingClasses = Online_class::where('created_by', $teacher->id)
                ->where('start_at', '>=', now())
                ->count();

            $recentStudents = students::whereIn('section_id', $sectionIds)
                ->with('grade', 'classroom', 'section')
                ->latest()
                ->take(8)
                ->get();

            $recentQuizzes = Quizze::where('teacher_id', $teacher->id)
                ->with('subject', 'section')
                ->latest()
                ->take(8)
                ->get();

            $recentAttendance = Attendance::whereIn('section_id', $sectionIds)
                ->with('students')
                ->latest('attendence_date')
                ->take(8)
                ->get();

            return view('pages.Teachers.Dashboard.dashboard', [
                'teacher' => $teacher,
                'countSections' => $countSections,
                'countStudents' => $countStudents,
                'countQuizzes' => $countQuizzes,
                'upcomingClasses' => $upcomingClasses,
                'countUpcomingClasses' => $countUpcomingClasses,
                'recentStudents' => $recentStudents,
                'recentQuizzes' => $recentQuizzes,
                'recentAttendance' => $recentAttendance,
            ]);
        })->name('teacher.dashboard');

        // Route::group(['namespace' => 'Teachers\dashboard'], function () { laravel 8
        //==============================students============================
        Route::group([], function () {
            Route::get('student', [StudentController::class, 'index'])->name('student.index');
            Route::get('sections', [StudentController::class, 'sections'])->name('sections');
            Route::post('attendance', [StudentController::class, 'attendance'])->name('attendance');
            Route::post('edit_attendance', [StudentController::class, 'editAttendance'])->name('attendance.edit');
            Route::get('attendance_report',  [StudentController::class, 'attendanceReport'])->name('attendance.report');
            Route::post('attendance_report', [StudentController::class, 'attendanceSearch'])->name('attendance.search');

            Route::resource('quizzes', QuizzesController::class);

            Route::resource('questions', QuestionController::class);
            Route::resource('online_zoom_classes', OnlineZoomClassesController::class);
            Route::get('/indirect/zoom/teacher', [OnlineZoomClassesController::class, 'indirectCreate'])->name('indirect.teacher.create');
            Route::post('/indirect/zoom/teacher', [OnlineZoomClassesController::class, 'storeIndirect'])->name('indirect.teacher.store');
            Route::get('profile', [ProfileController::class, 'index'])->name('profile.show');
            Route::post('profile/{id}', [ProfileController::class, 'update'])->name('profile.update');

            Route::get('student_quiz/{id}', [QuizzesController::class, 'student_quiz'])->name('student.quiz');
            Route::post('repeat_quiz', [QuizzesController::class, 'repeat_quiz'])->name('repeat.quiz');
        });
    }
);
