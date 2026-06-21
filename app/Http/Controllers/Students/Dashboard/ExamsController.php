<?php

namespace App\Http\Controllers\Students\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Quizze;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExamsController extends Controller
{
    public function index()
    {
        $quizzes = Quizze::where('grade_id', Auth::user()->Grade_id)
            ->where('classroom_id', Auth::user()->Classroom_id)
            ->where('section_id', Auth::user()->section_id)
            ->orderBy('id', 'DESC')
            ->get();
        return view('pages.Students.dashboard.exams.index', compact('quizzes'));
    }

    public function show($quizze_id)
    {
        // التأكد من أن هذا الاختبار مخصَّص فعلاً لصف/فصل/قسم الطالب الحالي، بنفس الفحص
        // المستخدم في index()، وإلا يمكن لأي طالب فتح اختبار خاص بقسم آخر بمجرد تغيير الرقم
        Quizze::where('grade_id', Auth::user()->Grade_id)
            ->where('classroom_id', Auth::user()->Classroom_id)
            ->where('section_id', Auth::user()->section_id)
            ->findOrFail($quizze_id);

        $student_id = Auth::user()->id;
        return view('pages.Students.dashboard.exams.show', compact('quizze_id', 'student_id'));
    }
}
