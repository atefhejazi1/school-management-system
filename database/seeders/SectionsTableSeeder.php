<?php

namespace Database\Seeders;

use App\Models\Classroom;
use App\Models\Grade;
use App\Models\School;
use App\Models\sections;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SectionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(School $school)
    {
        // نحذف فقط أقسام هذه المدرسة، حتى لا تُمحى بيانات مدرسة أخرى تمت إضافتها عبر SchoolSaaSSeeder
        DB::table('sections')->where('school_id', $school->id)->delete();

        $Sections = [
            ['en' => 'a', 'ar' => 'ا'],
            ['en' => 'b', 'ar' => 'ب'],
            ['en' => 'c', 'ar' => 'ت'],
        ];

        // نختار الصف والفصل الدراسي من نفس المدرسة فقط، لمنع تسرب بيانات مدرسة أخرى داخل العلاقات
        $gradeIds = Grade::where('school_id', $school->id)->pluck('id');
        $classroomIds = Classroom::where('school_id', $school->id)->pluck('id');

        foreach ($Sections as $section) {
            sections::create([
                'Name_Section' => $section,
                'Status' => 1,
                'Grade_id' => $gradeIds->random(),
                'Class_id' => $classroomIds->random(),
                'school_id' => $school->id, // حقن مباشر لأن السيدنج لا يعمل تحت جلسة auth حقيقية
            ]);
        }
    }
}
