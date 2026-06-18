<?php

namespace Database\Seeders;

use App\Models\Gender;
use App\Models\School;
use App\Models\specializations;
use App\Models\Teachers;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class TeacherSeeder extends Seeder
{
    public function run(School $school): void
    {
        // نحذف فقط معلمي هذه المدرسة، حتى لا تُمحى بيانات مدرسة أخرى
        DB::table('teachers')->where('school_id', $school->id)->delete();

        $genderIds = Gender::pluck('id');
        $specializationIds = specializations::pluck('id');

        $teachers = [
            ['ar' => 'أحمد محمود', 'en' => 'Ahmed Mahmoud'],
            ['ar' => 'سارة علي', 'en' => 'Sara Ali'],
            ['ar' => 'محمد رضا', 'en' => 'Mohamed Reda'],
        ];

        foreach ($teachers as $index => $name) {
            $teacher = new Teachers();
            $teacher->email = 'teacher' . ($index + 1) . '.' . $school->slug . '@example.test';
            $teacher->password = Hash::make('12345678'); // لا يوجد cast('hashed') في هذا النموذج، فالتشفير اليدوي إلزامي
            $teacher->Name = $name;
            $teacher->Specialization_id = $specializationIds->random();
            $teacher->Gender_id = $genderIds->random();
            $teacher->Joining_Date = now()->subMonths(rand(1, 24))->toDateString();
            $teacher->Address = 'القاهرة';
            $teacher->school_id = $school->id; // حقن مباشر لأن السيدنج لا يعمل تحت جلسة auth حقيقية
            $teacher->save();
        }
    }
}
