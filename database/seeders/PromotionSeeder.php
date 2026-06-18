<?php

namespace Database\Seeders;

use App\Models\Classroom;
use App\Models\Grade;
use App\Models\Promotions;
use App\Models\School;
use App\Models\sections;
use App\Models\students;
use Illuminate\Database\Seeder;

class PromotionSeeder extends Seeder
{
    /**
     * يسجّل ترقية تجريبية واحدة لأول طالب في المدرسة، من صفه الحالي إلى الصف التالي،
     * لمحاكاة سجل ترقية واقعي بين عامين دراسيين.
     */
    public function run(School $school): void
    {
        $student = students::where('school_id', $school->id)->first();

        if (! $student) {
            return;
        }

        Promotions::where('student_id', $student->id)->delete();

        $grades = Grade::where('school_id', $school->id)->pluck('id');
        $classrooms = Classroom::where('school_id', $school->id)->pluck('id');
        $sections = sections::where('school_id', $school->id)->pluck('id');

        // "الصف التالي" هنا هو أي صف آخر مختلف عن الصف الحالي للطالب، وليس بالضرورة الترتيب الفعلي للمراحل
        $nextGrade = $grades->first(fn ($id) => $id !== $student->Grade_id) ?? $grades->first();

        Promotions::create([
            'student_id' => $student->id,
            'from_grade' => $student->Grade_id,
            'from_Classroom' => $student->Classroom_id,
            'from_section' => $student->section_id,
            'to_grade' => $nextGrade,
            'to_Classroom' => $classrooms->random(),
            'to_section' => $sections->random(),
            'academic_year' => (string) (now()->year - 1) . '-' . now()->year,
            'academic_year_new' => now()->year . '-' . (now()->year + 1),
        ]);
    }
}
