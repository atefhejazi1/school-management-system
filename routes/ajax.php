<?php

use App\Http\Controllers\AjaxController;
use Illuminate\Support\Facades\Route;
use Livewire\Livewire;



Route::get('/Get_classrooms/{id}', [AjaxController::class, 'getClassrooms']);
Route::get('/Get_Sections/{id}', [AjaxController::class, 'Get_Sections']);
