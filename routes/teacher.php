<?php



// routes/web.php

use App\Http\Controllers\Teachers\Dashboard\QuizzController;
use App\Http\Controllers\Teachers\Dashboard\QuizzesController;
use App\Http\Controllers\Teachers\Dashboard\StudentController;
use App\Models\Teachers;
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
            $ids = Teachers::findorFail(auth()->user()->id)->Sections()->pluck('section_id');
            $data['count_sections'] = $ids->count();
            $data['count_students'] = \App\Models\students::whereIn('section_id', $ids)->count();
            return view('pages.Teachers.Dashboard.dashboard', $data);
        })->name('dashboard');

        Route::group(['namespace' => 'Teachers\dashboard'], function () {
            //==============================students============================
            Route::get('student', [StudentController::class, 'index'])->name('student.index');
            Route::get('sections', [StudentController::class, 'sections'])->name('sections');
            Route::post('attendance', [StudentController::class, 'attendance'])->name('attendance');
            Route::post('edit_attendance', [StudentController::class, 'editAttendance'])->name('attendance.edit');
            Route::get('attendance_report',  [StudentController::class, 'attendanceReport'])->name('attendance.report');
            Route::post('attendance_report', [StudentController::class, 'attendanceSearch'])->name('attendance.search');

            Route::resource('quizzes', QuizzesController::class);
            Route::get('/Get_classrooms/{id}', [QuizzesController::class, 'getClassrooms']);
            Route::get('/Get_Sections/{id}', [QuizzesController::class, 'Get_Sections']);
        });
    }
);
