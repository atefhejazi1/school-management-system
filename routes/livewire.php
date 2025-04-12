<?php

use Illuminate\Support\Facades\Route;
use Livewire\Livewire;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'web']
    ],
    function () {
        Livewire::setUpdateRoute(function ($handle) {
            return Route::post('livewire/update', $handle);
        });
    }
);
