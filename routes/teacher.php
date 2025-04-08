<?php



// routes/web.php

use App\Http\Controllers\Teachers\Dashboard\OnlineZoomClassesController;
use App\Http\Controllers\Teachers\Dashboard\ProfileController;
use App\Http\Controllers\Teachers\Dashboard\QuestionController;
use App\Http\Controllers\Teachers\Dashboard\QuizzesController;
use App\Http\Controllers\Teachers\Dashboard\StudentController;
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
            $ids = Teachers::findorFail(Auth::user()->id)->Sections()->pluck('section_id');
            $data['count_sections'] = $ids->count();
            $data['count_students'] = \App\Models\students::whereIn('section_id', $ids)->count();
            return view('pages.Teachers.Dashboard.dashboard', $data);
        })->name('dashboard');

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
        });
    }
);
