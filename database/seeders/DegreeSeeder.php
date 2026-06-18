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
     */
    public function run(School $school): void
    {
        DB::table('degrees')->where('school_id', $school->id)->delete();

        $studentIds = students::where('school_id', $school->id)->pluck('id');
        $quizzes = Quizze::where('school_id', $school->id)->get();

        if ($studentIds->isEmpty()) {
            return;
        }

        foreach ($quizzes as $quiz) {
            $questions = Question::where('quizze_id', $quiz->id)->get();

            foreach ($studentIds as $studentId) {
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
