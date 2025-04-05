<?php



// routes/web.php

use Illuminate\Support\Facades\Route;
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
    }
);
