<?php

namespace Database\Seeders;

use App\Models\School;
use App\Models\sections;
use App\Models\Teachers;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TeacherSectionSeeder extends Seeder
{
    /**
     * يربط كل معلم بقسم دراسي أو قسمين عبر جدول teacher_section (Pivot)، ضمن نفس المدرسة فقط.
     */
    public function run(School $school): void
    {
        $teacherIds = Teachers::where('school_id', $school->id)->pluck('id');
        $sectionIds = sections::where('school_id', $school->id)->pluck('id');

        if ($teacherIds->isEmpty() || $sectionIds->isEmpty()) {
            return;
        }

        // نحذف فقط روابط معلمي/أقسام هذه المدرسة، عبر استثناء معلمي المدارس الأخرى من الحذف
        DB::table('teacher_section')->whereIn('teacher_id', $teacherIds)->delete();

        foreach ($teacherIds as $teacherId) {
            // كل معلم يُربط بقسم أو قسمين عشوائيين دون تكرار الزوج نفسه
            foreach ($sectionIds->random(min(2, $sectionIds->count())) as $sectionId) {
                DB::table('teacher_section')->insert([
                    'teacher_id' => $teacherId,
                    'section_id' => $sectionId,
                ]);
            }
        }
    }
}
