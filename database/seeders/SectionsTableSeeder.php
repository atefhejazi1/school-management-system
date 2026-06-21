<?php

namespace Database\Seeders;

use App\Models\Classroom;
use App\Models\School;
use App\Models\sections;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SectionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * كل قسم يتبع صفاً دراسياً واحداً بعينه (Class_id)، فلا بد أن يحمل قسمه Grade_id
     * نفسه الذي يحمله ذلك الصف فعلاً — وليس مرحلة عشوائية منفصلة قد تتعارض معه. لذلك
     * نمرّ على كل صف دراسي تابع لهذه المدرسة ونُنشئ له قسماً واحداً مشتقاً منه مباشرة،
     * بدل اختيار Grade_id و Class_id بشكل عشوائي ومستقل تماماً عن بعضهما.
     */
    public function run(School $school)
    {
        // نحذف فقط أقسام هذه المدرسة، حتى لا تُمحى بيانات مدرسة أخرى تمت إضافتها عبر SchoolSaaSSeeder
        DB::table('sections')->where('school_id', $school->id)->delete();

        $sectionNames = [
            ['en' => 'a', 'ar' => 'ا'],
            ['en' => 'b', 'ar' => 'ب'],
            ['en' => 'c', 'ar' => 'ت'],
        ];

        $classrooms = Classroom::where('school_id', $school->id)->get();

        foreach ($classrooms as $index => $classroom) {
            sections::create([
                'Name_Section' => $sectionNames[$index % count($sectionNames)],
                'Status' => 1,
                // مشتقّ مباشرة من الصف الدراسي نفسه لضمان توافق المرحلة مع الصف دائماً
                'Grade_id' => $classroom->Grade_id,
                'Class_id' => $classroom->id,
                'school_id' => $school->id, // حقن مباشر لأن السيدنج لا يعمل تحت جلسة auth حقيقية
            ]);
        }
    }
}
