<?php



// routes/web.php

use App\Http\Controllers\Parents\Dashboard\ChildrenController;
use App\Http\Controllers\Students\Dashboard\ExamsController;
use App\Http\Controllers\Students\Dashboard\ProfileController;
use App\Models\Attendance;
use App\Models\Degree;
use App\Models\Fee_invoice;
use App\Models\Question;
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
            $parent = Auth::user();
            $sons = students::where('parent_id', $parent->id)
                ->with('grade', 'classroom', 'section')
                ->get();
            $sonIds = $sons->pluck('id');

            // إحصائيات مجمّعة عبر كل الأبناء معاً (للبطاقات العلوية)
            $attendanceTotal = Attendance::whereIn('student_id', $sonIds)->count();
            $attendancePresent = Attendance::whereIn('student_id', $sonIds)->where('attendence_status', 1)->count();
            $attendanceRate = $attendanceTotal > 0 ? round($attendancePresent / $attendanceTotal * 100) : null;

            $degrees = Degree::whereIn('student_id', $sonIds)->get();
            $takenQuizzeIds = $degrees->pluck('quizze_id')->unique();
            $totalEarned = $degrees->sum('score');
            $totalPossible = Question::whereIn('quizze_id', $takenQuizzeIds)->sum('score');
            $averageScore = $totalPossible > 0 ? round($totalEarned / $totalPossible * 100) : null;

            // balance_amount محتسب بصيغة Accessor وليس عموداً حقيقياً، فلا يصح استخدامه
            // مباشرةً مع sum() الخاص بـ Query Builder — لذا نجلب النماذج أولاً ثم نجمعها في الذاكرة
            $feeBalance = Fee_invoice::whereIn('student_id', $sonIds)->get()->sum('balance_amount');

            $recentAttendance = Attendance::whereIn('student_id', $sonIds)
                ->with('students')
                ->latest('attendence_date')
                ->take(8)
                ->get();

            // إحصائيات فردية لكل ابن (لبطاقة كل ابن على حدة)
            $childStats = [];
            foreach ($sons as $son) {
                $sonTotal = Attendance::where('student_id', $son->id)->count();
                $sonPresent = Attendance::where('student_id', $son->id)->where('attendence_status', 1)->count();

                $sonDegrees = Degree::where('student_id', $son->id)->get();
                $sonQuizIds = $sonDegrees->pluck('quizze_id')->unique();
                $sonEarned = $sonDegrees->sum('score');
                $sonPossible = Question::whereIn('quizze_id', $sonQuizIds)->sum('score');

                $childStats[$son->id] = [
                    'attendance_rate' => $sonTotal > 0 ? round($sonPresent / $sonTotal * 100) : null,
                    'average_score' => $sonPossible > 0 ? round($sonEarned / $sonPossible * 100) : null,
                    'fee_balance' => Fee_invoice::where('student_id', $son->id)->get()->sum('balance_amount'),
                ];
            }

            return view('pages.parents.dashboard', [
                'parent' => $parent,
                'sons' => $sons,
                'childStats' => $childStats,
                'attendanceRate' => $attendanceRate,
                'attendancePresent' => $attendancePresent,
                'attendanceTotal' => $attendanceTotal,
                'averageScore' => $averageScore,
                'feeBalance' => $feeBalance,
                'recentAttendance' => $recentAttendance,
            ]);
        })->name('parent.dashboard');

        Route::group([], function () {
            Route::get('children', [ChildrenController::class, 'index'])->name('sons.index');
            Route::get('results/{id}', [ChildrenController::class, 'results'])->name('sons.results');
            Route::get('attendances', [ChildrenController::class, 'attendances'])->name('sons.attendances');
            Route::post('attendances', [ChildrenController::class, 'attendanceSearch'])->name('sons.attendance.search');

            Route::get('fees', [ChildrenController::class, 'fees'])->name('sons.fees');
            Route::get('receipt/{id}', [ChildrenController::class, 'receiptStudent'])->name('sons.receipt');


            Route::get('profile/parent', [ChildrenController::class, 'profile'])->name('profile.show.parent');
            Route::post('profile/parent/{id}', [ChildrenController::class, 'update'])->name('profile.update.parent');
        });
    }

);
