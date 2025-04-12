<?php



// routes/web.php

use App\Http\Controllers\Parents\Dashboard\ChildrenController;
use App\Http\Controllers\Students\Dashboard\ExamsController;
use App\Http\Controllers\Students\Dashboard\ProfileController;
use App\Models\students;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Livewire\Livewire;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'web', 'auth:parent']
    ],
    function () {
        // 🔐 مسارات الطلاب
        Route::get('/parent/dashboard', function () {
            $sons = students::where('parent_id', Auth::user()->id)->get();

            return view('pages.parents.dashboard', compact('sons'));
        })->name('dashboard');

        Route::group([], function () {
            Route::get('children', [ChildrenController::class, 'index'])->name('sons.index');
            Route::get('results/{id}', [ChildrenController::class, 'results'])->name('sons.results');
            Route::get('attendances', [ChildrenController::class, 'attendances'])->name('sons.attendances');
            Route::post('attendances', [ChildrenController::class, 'attendanceSearch'])->name('sons.attendance.search');

            Route::get('fees', [ChildrenController::class, 'fees'])->name('sons.fees');
            Route::get('receipt/{id}', [ChildrenController::class, 'receiptStudent'])->name('sons.receipt');
        });
    }

);
