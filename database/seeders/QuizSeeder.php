<?php

namespace Database\Seeders;

use App\Models\Classroom;
use App\Models\Grade;
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
        $gradeIds = Grade::where('school_id', $school->id)->pluck('id');
        $classroomIds = Classroom::where('school_id', $school->id)->pluck('id');
        $sectionIds = sections::where('school_id', $school->id)->pluck('id');
        $teacherIds = Teachers::where('school_id', $school->id)->pluck('id');

        foreach ($subjects as $subject) {
            // اختبار واحد لكل مادة دراسية، يكفي لتوليد بيانات اختبار واقعية دون تضخيم البيانات
            Quizze::create([
                'name' => 'اختبار ' . $subject->name,
                'subject_id' => $subject->id,
                'grade_id' => $gradeIds->random(),
                'classroom_id' => $classroomIds->random(),
                'section_id' => $sectionIds->random(),
                'teacher_id' => $teacherIds->random(),
                'school_id' => $school->id, // حقن مباشر لأن السيدنج لا يعمل تحت جلسة auth حقيقية
            ]);
        }
    }
}
