<?php

namespace Database\Seeders;

use App\Models\Classroom;
use App\Models\Grade;
use App\Models\School;
use App\Models\Subject;
use App\Models\Teachers;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubjectSeeder extends Seeder
{
    public function run(School $school): void
    {
        DB::table('subjects')->where('school_id', $school->id)->delete();

        $gradeIds = Grade::where('school_id', $school->id)->pluck('id');
        $classroomIds = Classroom::where('school_id', $school->id)->pluck('id');
        $teacherIds = Teachers::where('school_id', $school->id)->pluck('id');

        $subjects = ['اللغة العربية', 'اللغة الإنجليزية', 'الرياضيات', 'العلوم'];

        foreach ($subjects as $name) {
            Subject::create([
                'name' => $name,
                'grade_id' => $gradeIds->random(),
                'classroom_id' => $classroomIds->random(),
                'teacher_id' => $teacherIds->random(),
                'school_id' => $school->id, // حقن مباشر لأن السيدنج لا يعمل تحت جلسة auth حقيقية
            ]);
        }
    }
}
