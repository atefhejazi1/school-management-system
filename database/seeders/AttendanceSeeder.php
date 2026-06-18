<?php

namespace Database\Seeders;

use App\Models\Attendance;
use App\Models\School;
use App\Models\students;
use App\Models\Teachers;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AttendanceSeeder extends Seeder
{
    /**
     * سجل حضور وغياب لآخر 5 أيام دراسية لكل طالب في هذه المدرسة فقط.
     */
    public function run(School $school): void
    {
        DB::table('attendances')->where('school_id', $school->id)->delete();

        $students = students::where('school_id', $school->id)->get();
        $teacherIds = Teachers::where('school_id', $school->id)->pluck('id');

        if ($students->isEmpty() || $teacherIds->isEmpty()) {
            return;
        }

        foreach ($students as $student) {
            for ($daysAgo = 1; $daysAgo <= 5; $daysAgo++) {
                Attendance::create([
                    'student_id' => $student->id,
                    'grade_id' => $student->Grade_id,
                    'classroom_id' => $student->Classroom_id,
                    'section_id' => $student->section_id,
                    'teacher_id' => $teacherIds->random(),
                    'attendence_date' => now()->subDays($daysAgo)->toDateString(),
                    // غياب نادر (10%) لمحاكاة بيانات واقعية بدل حضور دائم بنسبة 100%
                    'attendence_status' => rand(1, 10) > 1,
                    'school_id' => $school->id, // حقن مباشر لأن السيدنج لا يعمل تحت جلسة auth حقيقية
                ]);
            }
        }
    }
}
