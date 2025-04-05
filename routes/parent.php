<?php



// routes/web.php

use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'web', 'auth:parent']
    ],
    function () {
        // 🔐 مسارات أولياء الأمور
        Route::get('/parent/dashboard', function () {
            return view('parent.dashboard');
        })->name('dashboard');
    }
);
