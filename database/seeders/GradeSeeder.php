<?php

namespace Database\Seeders;

use App\Models\Grade;
use App\Models\School;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GradeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(School $school)
    {
        // نحذف فقط صفوف هذه المدرسة، حتى لا تُمحى بيانات مدرسة أخرى تمت إضافتها عبر SchoolSaaSSeeder
        DB::table('Grades')->where('school_id', $school->id)->delete();

        $grades = [
            ['en' => 'Primary stage', 'ar' => 'المرحلة الابتدائية'],
            ['en' => 'middle School', 'ar' => 'المرحلة الاعدادية'],
            ['en' => 'High school', 'ar' => 'المرحلة الثانوية'],
        ];

        foreach ($grades as $grade) {
            Grade::create([
                'Name' => $grade,
                'school_id' => $school->id, // حقن مباشر لأن السيدنج لا يعمل تحت جلسة auth حقيقية
            ]);
        }
    }
}
