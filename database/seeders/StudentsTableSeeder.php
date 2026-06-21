<?php

namespace Database\Seeders;

use App\Models\My_Parent;
use App\Models\Nationalities;
use App\Models\School;
use App\Models\sections;
use App\Models\students;
use App\Models\Type_Blood;
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
        // نحذف فقط طلاب هذه المدرسة، حتى لا تُمحى بيانات مدرسة أخرى
        DB::table('students')->where('school_id', $school->id)->delete();

        $nationalityIds = Nationalities::pluck('id');
        $bloodTypeIds = Type_Blood::pluck('id');
        $schoolSections = sections::where('school_id', $school->id)->get();
        $parentIds = My_Parent::where('school_id', $school->id)->pluck('id');

        if ($parentIds->isEmpty() || $schoolSections->isEmpty()) {
            return;
        }

        $students = [
            ['ar' => 'أحمد إبراهيم', 'en' => 'Ahmed Ibrahim'],
            ['ar' => 'يوسف خالد', 'en' => 'Youssef Khaled'],
            ['ar' => 'مريم سامي', 'en' => 'Mariam Samy'],
            ['ar' => 'نور الدين عادل', 'en' => 'Nour Eldin Adel'],
            ['ar' => 'هنا وليد', 'en' => 'Hana Walid'],
        ];

        foreach ($students as $index => $name) {
            // نختار قسماً دراسياً واحداً ونشتق منه المرحلة والصف الدراسي مباشرة، حتى يبقى
            // الطالب منتمياً فعلياً لمجموعة (مرحلة + صف + قسم) متوافقة فيما بينها، بدل
            // اختيار الثلاثة بشكل عشوائي ومستقل قد يضع طالباً في قسم لا يتبع صفه أصلاً
            $section = $schoolSections->random();

            $student = new students();
            $student->name = $name;
            $student->email = 'student' . ($index + 1) . '.' . $school->slug . '@example.test';
            $student->password = Hash::make('12345678'); // لا يوجد cast('hashed') في هذا النموذج، فالتشفير اليدوي إلزامي
            $student->gender_id = ($index % 2) + 1; // تبديل بين أول جنسين موجودين لتنويع البيانات
            $student->nationalitie_id = $nationalityIds->random();
            $student->blood_id = $bloodTypeIds->random();
            $student->Date_Birth = now()->subYears(10)->subDays($index)->toDateString();
            $student->Grade_id = $section->Grade_id;
            $student->Classroom_id = $section->Class_id;
            $student->section_id = $section->id;
            $student->parent_id = $parentIds->random();
            $student->academic_year = now()->year . '-' . (now()->year + 1);
            $student->school_id = $school->id; // حقن مباشر لأن السيدنج لا يعمل تحت جلسة auth حقيقية
            $student->save();
        }
    }
}
