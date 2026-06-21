<?php

namespace App\Repository;

use App\Models\Exam;
use App\Models\Grade;
use App\Models\Classroom;
use App\Models\sections;
use App\Models\students;
use App\Models\Quizze;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Collection;

class ReportCardRepository implements ReportCardRepositoryInterface
{
    /**
     * الترتيب النصي بالعربية للمراكز من 1 إلى 10، وما بعدها نستخدم صيغة عامة "الترتيب رقم N"
     * لأن الأسماء الترتيبية العربية الفعلية (الحادي عشر، الثاني عشر...) غير شائعة الاستخدام
     * في الشهادات الرسمية ويُفضَّل المدراء الرقم المباشر بعد العاشر.
     */
    private const ARABIC_ORDINALS = [
        1 => 'الأول', 2 => 'الثاني', 3 => 'الثالث', 4 => 'الرابع', 5 => 'الخامس',
        6 => 'السادس', 7 => 'السابع', 8 => 'الثامن', 9 => 'التاسع', 10 => 'العاشر',
    ];

    public function index($request)
    {
        $grades = Grade::all();
        $classrooms = $request->grade_id ? Classroom::where('Grade_id', $request->grade_id)->get() : collect();
        $sections = $request->classroom_id ? sections::where('Class_id', $request->classroom_id)->get() : collect();
        $exams = Exam::latest()->get();

        $students = collect();
        if ($request->grade_id && $request->classroom_id && $request->section_id) {
            $students = students::where('Grade_id', $request->grade_id)
                ->where('Classroom_id', $request->classroom_id)
                ->where('section_id', $request->section_id)
                ->get();
        }

        return view('pages.ReportCards.index', compact('grades', 'classrooms', 'sections', 'exams', 'students'));
    }

    public function generateReportCardPdf($studentId, $examId)
    {
        $student = students::with(['grade', 'classroom', 'section'])->findOrFail($studentId);
        $exam = Exam::findOrFail($examId);

        $classmates = students::where('Grade_id', $student->Grade_id)
            ->where('Classroom_id', $student->Classroom_id)
            ->where('section_id', $student->section_id)
            ->get();

        $quizzes = Quizze::where('grade_id', $student->Grade_id)
            ->where('classroom_id', $student->Classroom_id)
            ->where('section_id', $student->section_id)
            ->where('exam_id', $exam->id)
            ->with(['subject', 'questions', 'degree'])
            ->get();

        $subjectRows = $this->buildSubjectRows($quizzes, $student->id);
        $totalObtained = $subjectRows->sum('obtained');
        $totalMax = $subjectRows->sum('max');
        $percentage = $totalMax > 0 ? round(($totalObtained / $totalMax) * 100, 2) : 0.0;

        [$rank, $rankText] = $this->computeClassRank($quizzes, $classmates, $student->id, $totalObtained);

        $pdf = Pdf::loadView('pages.ReportCards.pdf', [
            'student' => $student,
            'exam' => $exam,
            'subjectRows' => $subjectRows,
            'totalObtained' => $totalObtained,
            'totalMax' => $totalMax,
            'percentage' => $percentage,
            'rank' => $rank,
            'rankText' => $rankText,
            'classSize' => $classmates->count(),
        ]);

        $fileName = 'report-card-' . $student->id . '-' . $exam->id . '.pdf';
        return $pdf->stream($fileName);
    }

    /**
     * تجميع علامات كل مادة دراسية لطالب واحد: نمر على كل اختبار (quiz) ضمن الفترة
     * الامتحانية المطلوبة، ونحدد المادة التابعة له، ثم نجمع كل ما حصل عليه الطالب من
     * درجات في أسئلة هذا الاختبار (obtained) مقابل أعلى علامة ممكنة لكل سؤال (max).
     */
    private function buildSubjectRows(Collection $quizzes, int $studentId): Collection
    {
        $bySubject = [];

        foreach ($quizzes as $quiz) {
            $subjectId = $quiz->subject_id;
            $subjectName = $quiz->subject->name ?? '—';

            if (!isset($bySubject[$subjectId])) {
                $bySubject[$subjectId] = ['subject' => $subjectName, 'obtained' => 0.0, 'max' => 0.0];
            }

            $bySubject[$subjectId]['max'] += (float) $quiz->questions->sum('score');
            $bySubject[$subjectId]['obtained'] += (float) $quiz->degree
                ->where('student_id', $studentId)
                ->sum('score');
        }

        return collect(array_values($bySubject));
    }

    /**
     * ترتيب الطالب بين زملائه في نفس الصف/الشعبة: نحسب إجمالي العلامات المحصَّلة لكل
     * طالب بنفس طريقة حساب علامات الطالب المطلوب تماماً، ثم نرتّبهم تنازلياً. الترتيب
     * المُعتمَد هنا هو "ترتيب المنافسات الرياضية" (Standard Competition Ranking): إن
     * تساوى طالبان في العلامة يتشاركان نفس المركز، ولا يُحرَم الطالب الذي يليهما من
     * مركزه الحقيقي (لا نستخدم Dense Ranking الذي يضغط المراكز المتتالية).
     */
    private function computeClassRank(Collection $quizzes, Collection $classmates, int $studentId, float $studentTotal): array
    {
        $totalsByStudent = $classmates->mapWithKeys(function ($classmate) use ($quizzes) {
            $total = 0.0;
            foreach ($quizzes as $quiz) {
                $total += (float) $quiz->degree->where('student_id', $classmate->id)->sum('score');
            }
            return [$classmate->id => $total];
        });

        $rank = 1 + $totalsByStudent->filter(fn ($total) => $total > $studentTotal)->count();
        $rankLabel = self::ARABIC_ORDINALS[$rank] ?? ('الترتيب رقم ' . $rank);

        return [$rank, $rankLabel . ' على الصف'];
    }
}
