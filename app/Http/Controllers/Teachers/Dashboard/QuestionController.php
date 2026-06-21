<?php

namespace App\Http\Controllers\Teachers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\Quizze;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuestionController extends Controller
{
    public function store(Request $request)
    {
        try {
            // التأكد من أن الاختبار المستهدَف يخص المعلم الحالي قبل إضافة سؤال إليه،
            // وإلا يمكن لأي معلم إضافة أسئلة لاختبار معلم آخر بمجرد تمرير quizz_id مختلف
            Quizze::where('teacher_id', Auth::user()->id)->findOrFail($request->quizz_id);

            $question = new Question();
            $question->title = $request->title;
            $question->answers = $request->answers;
            $question->right_answer = $request->right_answer;
            $question->score = $request->score;
            $question->quizze_id = $request->quizz_id;
            $question->save();
            toastr()->success(trans('messages.success'));
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }


    public function show($id)
    {
        $quizz_id = $id;
        return view('pages.Teachers.dashboard.Questions.create', compact('quizz_id'));
    }


    public function edit($id)
    {
        // مقيّد بملكية الاختبار الأب (Quizze::teacher_id) عبر علاقة quizze() المعرّفة على النموذج،
        // لمنع أي معلم من تعديل سؤال (بما فيه الإجابة الصحيحة) ضمن اختبار معلم آخر
        $question = Question::whereHas('quizze', function ($query) {
            $query->where('teacher_id', Auth::user()->id);
        })->findOrFail($id);
        return view('pages.Teachers.dashboard.Questions.edit', compact('question'));
    }


    public function update(Request $request, $id)
    {
        try {
            $question = Question::whereHas('quizze', function ($query) {
                $query->where('teacher_id', Auth::user()->id);
            })->findOrFail($id);
            $question->title = $request->title;
            $question->answers = $request->answers;
            $question->right_answer = $request->right_answer;
            $question->score = $request->score;
            $question->save();
            toastr()->success(trans('messages.Update'));
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }


    public function destroy($id)
    {
        try {
            Question::whereHas('quizze', function ($query) {
                $query->where('teacher_id', Auth::user()->id);
            })->findOrFail($id)->delete();
            toastr()->error(trans('messages.Delete'));
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
