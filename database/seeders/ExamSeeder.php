<?php

namespace Database\Seeders;

use App\Models\Exam;
use App\Models\School;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ExamSeeder extends Seeder
{
    /**
     * فترة امتحانية واحدة (الفصل الأول) لهذه المدرسة، تُستخدم لربط الاختبارات بها في
     * QuizSeeder، حتى تعمل بطاقات الأداء الدراسي (Report Cards) فوراً دون أي إعداد يدوي.
     */
    public function run(School $school): void
    {
        DB::table('exams')->where('school_id', $school->id)->delete();

        Exam::create([
            'name' => ['ar' => 'الفصل الدراسي الأول', 'en' => 'First Term'],
            'term' => 'الفصل الأول',
            'academic_year' => now()->year . '-' . (now()->year + 1),
            'school_id' => $school->id, // حقن مباشر لأن السيدنج لا يعمل تحت جلسة auth حقيقية
        ]);
    }
}
