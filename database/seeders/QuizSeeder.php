<?php

namespace Database\Seeders;

use App\Models\Exam;
use App\Models\Quizze;
use App\Models\School;
use App\Models\sections;
use App\Models\Subject;
use App\Models\Teachers;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QuizSeeder extends Seeder
{
    public function run(School $school): void
    {
        DB::table('quizzes')->where('school_id', $school->id)->delete();

        $subjects = Subject::where('school_id', $school->id)->get();
        $teacherIds = Teachers::where('school_id', $school->id)->pluck('id');
        $examId = Exam::where('school_id', $school->id)->value('id');

        foreach ($subjects as $subject) {
            // نشتق grade_id/classroom_id من المادة نفسها، ثم نختار قسماً ينتمي فعلياً لهذا
            // الصف بالتحديد — لا قسماً عشوائياً من صف آخر قد لا يدرس هذه المادة أصلاً
            $section = sections::where('school_id', $school->id)
                ->where('Class_id', $subject->classroom_id)
                ->inRandomOrder()
                ->first();

            if (! $section) {
                continue;
            }

            // اختبار واحد لكل مادة دراسية، يكفي لتوليد بيانات اختبار واقعية دون تضخيم البيانات
            Quizze::create([
                'name' => 'اختبار ' . $subject->name,
                'subject_id' => $subject->id,
                'grade_id' => $subject->grade_id,
                'classroom_id' => $subject->classroom_id,
                'section_id' => $section->id,
                'teacher_id' => $teacherIds->random(),
                // ربط الاختبار بالفترة الامتحانية الحالية للمدرسة (إن وُجدت)، حتى تعمل
                // بطاقات الأداء الدراسي (Report Cards) مباشرة دون أي إعداد يدوي إضافي
                'exam_id' => $examId,
                'school_id' => $school->id, // حقن مباشر لأن السيدنج لا يعمل تحت جلسة auth حقيقية
            ]);
        }
    }
}
