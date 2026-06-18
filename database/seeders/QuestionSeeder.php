<?php

namespace Database\Seeders;

use App\Models\Question;
use App\Models\Quizze;
use App\Models\School;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QuestionSeeder extends Seeder
{
    /**
     * questions ليس عليها school_id مباشرة، فهي معزولة عملياً عبر quizze_id
     * (كل سؤال مرتبط باختبار، والاختبار نفسه معزول بـ school_id).
     */
    public function run(School $school): void
    {
        $quizIds = Quizze::where('school_id', $school->id)->pluck('id');

        DB::table('questions')->whereIn('quizze_id', $quizIds)->delete();

        foreach ($quizIds as $quizId) {
            for ($i = 1; $i <= 3; $i++) {
                Question::create([
                    'title' => 'سؤال رقم ' . $i,
                    'answers' => 'إجابة أ|إجابة ب|إجابة ج|إجابة د',
                    'right_answer' => 'إجابة أ',
                    'score' => 10,
                    'quizze_id' => $quizId,
                ]);
            }
        }
    }
}
