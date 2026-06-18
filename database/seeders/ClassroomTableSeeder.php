<?php

namespace Database\Seeders;

use App\Models\Classroom;
use App\Models\Grade;
use App\Models\School;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClassroomTableSeeder extends Seeder
{
    public function run(School $school)
    {
        // نحذف فقط فصول هذه المدرسة، حتى لا تُمحى بيانات مدرسة أخرى تمت إضافتها عبر SchoolSaaSSeeder
        DB::table('Classrooms')->where('school_id', $school->id)->delete();

        $classrooms = [
            ['en' => 'First grade', 'ar' => 'الصف الاول'],
            ['en' => 'Second grade', 'ar' => 'الصف الثاني'],
            ['en' => 'Third grade', 'ar' => 'الصف الثالث'],
        ];

        // نختار الصف الدراسي من نفس المدرسة فقط، لمنع تسرب بيانات مدرسة أخرى داخل العلاقات
        $gradeIds = Grade::where('school_id', $school->id)->pluck('id');

        foreach ($classrooms as $classroom) {
            Classroom::create([
                'Name_Class' => $classroom,
                'Grade_id' => $gradeIds->random(),
                'school_id' => $school->id, // حقن مباشر لأن السيدنج لا يعمل تحت جلسة auth حقيقية
            ]);
        }
    }
}
