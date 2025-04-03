<?php

use App\Http\Controllers\Students\AttendanceController;
use App\Http\Controllers\Classrooms\ClassroomController;
use App\Http\Controllers\Grades\GradeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\questions\QuestionController;
use App\Http\Controllers\Quizzes\QuizzeController;
use App\Http\Controllers\Sections\SectionsController;
use App\Http\Controllers\Students\FeeInvoiceController;
use App\Http\Controllers\Students\FeesController;
use App\Http\Controllers\Students\GraduatedController;
use App\Http\Controllers\Students\OnlineClassController;
use App\Http\Controllers\Students\PaymentStudentController;
use App\Http\Controllers\Students\ProcessingFeeController;
use App\Http\Controllers\Students\PromotionController;
use App\Http\Controllers\Students\ReceiptStudentController;
use App\Http\Controllers\Students\StudentsController;
use App\Http\Controllers\Subjects\SubjectController;
use App\Http\Controllers\Teachers\TeachersController;
use Illuminate\Support\Facades\Route;
use Livewire\Livewire;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Jubaer\Zoom\Facades\Zoom;


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// only for guests
Route::group(
    [
        'middleware' => ['guest']
    ],
    function () {
        Route::get('/', function () {
            return view('auth.login');
        });
    }
);


// routes/web.php
Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'auth']
    ],
    function () {
        Route::get('/dashboard', function () {
            return view('dashboard');
        })->middleware(['auth', 'verified'])->name('dashboard');

        Route::resource('Grades', GradeController::class);
        Route::resource('Classrooms', ClassroomController::class);
        Route::post('delete_all', [ClassroomController::class, 'delete_all'])->name('delete_all');
        Route::post('Filter_Classes', [ClassroomController::class, 'Filter_Classes'])->name('Filter_Classes');

        Route::resource('Sections', SectionsController::class);
        Route::get('classes/{id}', [SectionsController::class, 'getclasses']);

        Livewire::setUpdateRoute(function ($handle) {
            return Route::post('/livewire/update', $handle);
        });
        Route::view('add_parent', 'livewire.show_Form');

        Route::resource('Teachers', TeachersController::class);

        Route::resource('Students', StudentsController::class);
        Route::get('/Get_classrooms/{id}', [StudentsController::class,  'Get_classrooms']);
        Route::get('/Get_Sections/{id}', [StudentsController::class,  'Get_Sections']);
        Route::post('Upload_attachment', [StudentsController::class, 'Upload_attachment'])->name('Upload_attachment');
        Route::get('Download_attachment/{studentsname}/{filename}', [StudentsController::class, 'Download_attachment'])->name('Download_attachment');
        Route::post('Delete_attachment', [StudentsController::class, 'Delete_attachment'])->name('Delete_attachment');


        Route::resource('Promotion', PromotionController::class);

        Route::resource('Graduated', GraduatedController::class);

        Route::resource('Fees', FeesController::class);

        Route::resource('Fees_Invoices', FeeInvoiceController::class);

        Route::resource('receipt_students', ReceiptStudentController::class);
        Route::resource('ProcessingFee', ProcessingFeeController::class);
        Route::resource('Payment_students', PaymentStudentController::class);
        Route::resource('Attendance', AttendanceController::class);

        Route::resource('subjects', SubjectController::class);


        Route::resource('Quizzes', QuizzeController::class);
        Route::resource('questions', QuestionController::class);


        Route::resource('online_classes', OnlineClassController::class);

        Route::get('/indirect', [OnlineClassController::class, 'indirectCreate'])->name('indirect.create');
        Route::post('/indirect', [OnlineClassController::class, 'storeIndirect'])->name('indirect.store');
    }
);

require __DIR__ . '/auth.php';
