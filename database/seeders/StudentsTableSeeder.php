<?php

namespace Database\Seeders;

use App\Models\Classroom;
use App\Models\Grade;
use App\Models\My_Parent;
use App\Models\Nationalities;
use App\Models\School;
use App\Models\sections;
use App\Models\students;
use App\Models\Type_Blood;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class StudentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(School $school): void
    {
        // نحذف فقط طلاب هذه المدرسة، حتى لا تُمحى بيانات مدرسة أخرى تمت إضافتها عبر SchoolSaaSSeeder
        DB::table('students')->where('school_id', $school->id)->delete();
        $students = new students();
        $students->name = ['ar' => 'احمد ابراهيم', 'en' => 'Ahmed Ibrahim'];
        $students->email = 'Ahmed_Ibrahim@yahoo.com';
        $students->password = Hash::make('12345678');
        $students->gender_id = 1;
        $students->nationalitie_id = Nationalities::all()->unique()->random()->id;
        $students->blood_id = Type_Blood::all()->unique()->random()->id;
        $students->Date_Birth = date('1995-01-01');
        // نختار الصف والفصل والقسم وولي الأمر من نفس المدرسة فقط، لمنع تسرب بيانات مدرسة أخرى داخل العلاقات
        $students->Grade_id = Grade::where('school_id', $school->id)->pluck('id')->random();
        $students->Classroom_id = Classroom::where('school_id', $school->id)->pluck('id')->random();
        $students->section_id = sections::where('school_id', $school->id)->pluck('id')->random();
        $students->parent_id = My_Parent::where('school_id', $school->id)->pluck('id')->random();
        $students->academic_year = '2021';
        $students->school_id = $school->id; // حقن مباشر لأن السيدنج لا يعمل تحت جلسة auth حقيقية
        $students->save();
    }
}
