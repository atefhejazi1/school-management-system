<?php

namespace Database\Seeders;

use App\Models\Degree;
use App\Models\Question;
use App\Models\Quizze;
use App\Models\School;
use App\Models\students;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DegreeSeeder extends Seeder
{
    /**
     * درجات الطلاب في كل سؤال من كل اختبار، لمحاكاة بيانات تقييم واقعية.
     *
     * كل اختبار يخص مرحلة وصفاً وقسماً بعينه (grade_id/classroom_id/section_id)، فلا
     * يُفترَض أن يُسجَّل لكل طالب في المدرسة علامة في اختبار لا يخص قسمه أصلاً. لذلك
     * نُقيِّد الطلاب هنا فعلياً لمن ينتمون لنفس (مرحلة + صف + قسم) الاختبار بالتحديد،
     * بدل تسجيل علامة لكل طالب في كل اختبار بالمدرسة بصرف النظر عن قسمه الحقيقي.
     */
    public function run(School $school): void
    {
        DB::table('degrees')->where('school_id', $school->id)->delete();

        $quizzes = Quizze::where('school_id', $school->id)->get();

        foreach ($quizzes as $quiz) {
            $classmateIds = students::where('school_id', $school->id)
                ->where('Grade_id', $quiz->grade_id)
                ->where('Classroom_id', $quiz->classroom_id)
                ->where('section_id', $quiz->section_id)
                ->pluck('id');

            if ($classmateIds->isEmpty()) {
                continue;
            }

            $questions = Question::where('quizze_id', $quiz->id)->get();

            foreach ($classmateIds as $studentId) {
                foreach ($questions as $question) {
                    Degree::create([
                        'quizze_id' => $quiz->id,
                        'student_id' => $studentId,
                        'question_id' => $question->id,
                        'score' => rand(0, $question->score),
                        'abuse' => '0',
                        'date' => now()->toDateString(),
                        'school_id' => $school->id, // حقن مباشر لأن السيدنج لا يعمل تحت جلسة auth حقيقية
                    ]);
                }
            }
        }
    }
}
