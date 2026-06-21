<?php

namespace App\Repository;

use App\Models\Exam;

class ExamRepository implements ExamRepositoryInterface
{
    public function index()
    {
        $exams = Exam::latest()->get();
        return view('pages.Exams.index', compact('exams'));
    }

    public function store($request)
    {
        try {
            $exam = new Exam();
            $exam->setTranslation('name', 'en', $request->name_en)
                ->setTranslation('name', 'ar', $request->name_ar);
            $exam->term = $request->term;
            $exam->academic_year = $request->academic_year;
            $exam->save();

            toastr()->success(trans('messages.success'));
            return redirect()->route('Exams.index');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function destroy($request)
    {
        try {
            Exam::destroy($request->id);
            toastr()->error(trans('messages.Delete'));
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
