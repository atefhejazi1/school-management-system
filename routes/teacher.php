<?php



// routes/web.php

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
            return view('teacher.dashboard');
        })->name('dashboard');
    }
);
