<?php

namespace Database\Seeders;

use App\Models\Classroom;
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

        $classrooms = Classroom::where('school_id', $school->id)->get();
        $teacherIds = Teachers::where('school_id', $school->id)->pluck('id');

        $subjects = ['اللغة العربية', 'اللغة الإنجليزية', 'الرياضيات', 'العلوم'];

        foreach ($subjects as $name) {
            // نختار صفاً دراسياً واحداً ونشتق grade_id منه مباشرة، حتى لا تنتمي المادة
            // لمرحلة دراسية لا تتبعها هذا الصف فعلياً
            $classroom = $classrooms->random();

            Subject::create([
                'name' => $name,
                'grade_id' => $classroom->Grade_id,
                'classroom_id' => $classroom->id,
                'teacher_id' => $teacherIds->random(),
                'school_id' => $school->id, // حقن مباشر لأن السيدنج لا يعمل تحت جلسة auth حقيقية
            ]);
        }
    }
}
