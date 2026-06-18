<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Students\AttendanceController;
use App\Http\Controllers\Classrooms\ClassroomController;
use App\Http\Controllers\FullCalenderController;
use App\Http\Controllers\Grades\GradeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\questions\QuestionController;
use App\Http\Controllers\Quizzes\QuizzeController;
use App\Http\Controllers\Sections\SectionsController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\Students\FeeInvoiceController;
use App\Http\Controllers\Students\FeesController;
use App\Http\Controllers\Students\GraduatedController;
use App\Http\Controllers\Students\LibraryController;
use App\Http\Controllers\Students\OnlineClassController;
use App\Http\Controllers\Students\PaymentStudentController;
use App\Http\Controllers\Students\ProcessingFeeController;
use App\Http\Controllers\Students\PromotionController;
use App\Http\Controllers\Students\ReceiptStudentController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\Students\StudentsController;
use App\Http\Controllers\Subjects\SubjectController;
use App\Http\Controllers\SuperAdmin\DashboardController as SuperAdminDashboardController;
use App\Http\Controllers\SuperAdmin\ImpersonationController;
use App\Http\Controllers\SuperAdmin\PlanSelectionController;
use App\Http\Controllers\SuperAdmin\SuperAdminUserController;
use App\Http\Controllers\Teachers\TeachersController;
use Illuminate\Support\Facades\Route;
use Livewire\Livewire;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

require __DIR__ . '/ajax.php';

// Public landing page — accessible by everyone
Route::get('/', [LandingController::class, 'index'])->name('landing');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// only for guests
Route::group(['middleware' => ['guest']], function () {
    Route::get('/select', function () {
        return view('auth.selection');
    })->name('selection');

    // ── البوابة الموحدة لتسجيل الدخول: نفس الرابط ونفس النموذج لكل المستخدمين ──
    // (منشئ المنصة، مدير المدرسة، المعلم، الطالب، ولي الأمر). التمييز بين الأدوار
    // يحدث صامتاً في الباك-إند بعد المصادقة عبر AuthenticatedSessionController::storeUnified().
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'storeUnified'])->name('login.attempt');

    // المسارات القديمة الخاصة بكل نوع مستخدم — تبقى متاحة للتوافق مع الروابط الحالية في الواجهات
    Route::get('/login/{type}', [AuthenticatedSessionController::class, 'create'])->name('login.show');
    Route::post('/login/{type}', [AuthenticatedSessionController::class, 'store'])->name('login.store');
});

Route::post('/logout/{type}', [AuthenticatedSessionController::class, 'destroy'])->name('custom.logout');


// routes/web.php
Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'auth', 'role.redirect']
    ],
    function () {
        Route::get('/dashboard', function () {
            return view('dashboard');
        })->middleware(['auth', 'verified'])->name('dashboard');

        // ── الخروج من جلسة معاينة حساب مدير مدرسة (Impersonation) — يجب أن يبقى هذا المسار
        // خارج مجموعة /super-admin لأن منشئ المنصة، خلال المعاينة، مسجَّل دخوله فعلياً
        // بهوية مدير مدرسة (school_id محدد)، فلا يستطيع الوصول لمسارات /super-admin/* أصلاً.
        Route::post('/leave-impersonation', [ImpersonationController::class, 'leave'])->name('leave_impersonation');


        // 🔐 مسارات الطلاب
        Route::middleware(['web', 'auth:student'])->prefix('student')->name('student.')->group(function () {
            Route::get('/dashboard', function () {
                return view('pages.students.dashboard');
            })->name('dashboard');
        });
        //==============================Sections============================
        Route::resource('Grades', GradeController::class);
        Route::resource('Classrooms', ClassroomController::class);
        Route::post('delete_all', [ClassroomController::class, 'delete_all'])->name('delete_all');
        Route::post('Filter_Classes', [ClassroomController::class, 'Filter_Classes'])->name('Filter_Classes');

        Route::resource('Sections', SectionsController::class);
        Route::get('classes/{id}', [SectionsController::class, 'getclasses']);

        //==============================parents============================


        Route::view('add_parent', 'livewire.show_Form')->name('add_parent');

        //==============================Teachers============================
        Route::resource('Teachers', TeachersController::class);

        //==============================Students============================
        Route::resource('Students', StudentsController::class);
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


        //==============================Quizzes , questions and subjects============================
        Route::resource('subjects', SubjectController::class);
        Route::resource('Quizzes', QuizzeController::class);
        Route::resource('questions', QuestionController::class);


        Route::resource('online_classes', OnlineClassController::class);
        Route::get('/indirect', [OnlineClassController::class, 'indirectCreate'])->name('indirect.create');
        Route::post('/indirect', [OnlineClassController::class, 'storeIndirect'])->name('indirect.store');

        Route::resource('library', LibraryController::class);
        Route::get('download_file/{filename}', [LibraryController::class, 'downloadAttachment'])->name('downloadAttachment');


        //==============================Setting============================
        Route::resource('settings', SettingController::class);
    }
);

// ══════════════════════════════════════════════════════════
// لوحة تحكم منشئ المنصة (Super Admin) — معزولة تماماً عن مسارات المدارس،
// لكنها تبقى داخل مجموعة الـ locale نفسها لضمان عمل تبديل اللغة (AR/EN) بشكل صحيح
// ══════════════════════════════════════════════════════════
Route::group(
    [
        'prefix'     => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'auth', 'role.redirect'],
    ],
    function () {
        Route::prefix('super-admin')->name('super-admin.')->group(function () {
            Route::get('/dashboard', [SuperAdminDashboardController::class, 'index'])->name('dashboard');

            Route::get('/school-requests', function () {
                return view('super-admin.school-requests.index');
            })->name('school-requests.index');

            // ── بطاقات اختيار/تجديد باقة الاشتراك لمدرسة محددة ──
            Route::get('/schools/{school}/plan-selection', [PlanSelectionController::class, 'index'])->name('plan-selection.index');
            Route::post('/schools/{school}/plan-selection', [PlanSelectionController::class, 'store'])->name('plan-selection.store');

            // ── الدخول كمدير مدرسة محدد لمعاينة لوحته (Impersonation) ──
            Route::post('/impersonate/{schoolAdminId}', [ImpersonationController::class, 'impersonate'])->name('impersonate');

            // ── إعدادات المنصة العامة ──
            Route::get('/settings', function () {
                return view('super-admin.settings.index');
            })->name('settings.index');

            // ── إدارة حسابات منشئي المنصة الثانويين (Super Admin Provisioning) ──
            Route::get('/admins', [SuperAdminUserController::class, 'index'])->name('admins.index');
            Route::post('/admins', [SuperAdminUserController::class, 'store'])->name('admins.store');
        });
    }
);

require __DIR__ . '/teacher.php';
require __DIR__ . '/student.php';
require __DIR__ . '/parent.php';
require __DIR__ . '/auth.php';
