<?php



// routes/web.php

use App\Http\Controllers\Students\Dashboard\ExamsController;
use App\Http\Controllers\Students\Dashboard\ProfileController;
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
            return view('pages.students.dashboard');
        })->name('dashboard');

        Route::group([], function () {
            // Livewire::setUpdateRoute(function ($handle) {
            //     return Route::post('/livewire/update', $handle);
            // });

            Route::resource('student_exams', ExamsController::class);
            Route::resource('profile-student', ProfileController::class);
        });
    }

);
