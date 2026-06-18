<?php

namespace Database\Seeders;

use App\Models\My_Parent;
use App\Models\Nationalities;
use App\Models\Religions;
use App\Models\School;
use App\Models\Type_Blood;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ParentsTableSeeder extends Seeder
{
    public function run(School $school): void
    {
        // نحذف فقط أولياء أمور هذه المدرسة، حتى لا تُمحى بيانات مدرسة أخرى
        DB::table('my__parents')->where('school_id', $school->id)->delete();

        $nationalityIds = Nationalities::pluck('id');
        $bloodTypeIds = Type_Blood::pluck('id');
        $religionIds = Religions::pluck('id');

        $parents = [
            ['ar' => 'محمد محمد', 'en' => 'Mohamed Mohamed'],
            ['ar' => 'إبراهيم سعيد', 'en' => 'Ibrahim Saeed'],
            ['ar' => 'طارق فؤاد', 'en' => 'Tarek Fouad'],
        ];

        foreach ($parents as $index => $name) {
            $parent = new My_Parent();
            $parent->email = 'parent' . ($index + 1) . '.' . $school->slug . '@example.test';
            $parent->password = Hash::make('12345678'); // لا يوجد cast('hashed') في هذا النموذج، فالتشفير اليدوي إلزامي
            $parent->Name_Father = $name;
            $parent->National_ID_Father = '2990101123456' . $index;
            $parent->Passport_ID_Father = 'A123456' . $index;
            $parent->Phone_Father = '0100000000' . $index;
            $parent->Job_Father = ['en' => 'Employee', 'ar' => 'موظف'];
            $parent->Nationality_Father_id = $nationalityIds->random();
            $parent->Blood_Type_Father_id = $bloodTypeIds->random();
            $parent->Religion_Father_id = $religionIds->random();
            $parent->Address_Father = 'القاهرة';
            $parent->Name_Mother = ['ar' => 'زوجة ' . $name['ar'], 'en' => 'Wife of ' . $name['en']];
            $parent->National_ID_Mother = '2990101123457' . $index;
            $parent->Passport_ID_Mother = 'A123457' . $index;
            $parent->Phone_Mother = '0100000001' . $index;
            $parent->Job_Mother = ['en' => 'Housewife', 'ar' => 'ربة منزل'];
            $parent->Nationality_Mother_id = $nationalityIds->random();
            $parent->Blood_Type_Mother_id = $bloodTypeIds->random();
            $parent->Religion_Mother_id = $religionIds->random();
            $parent->Address_Mother = 'القاهرة';
            $parent->school_id = $school->id; // حقن مباشر لأن السيدنج لا يعمل تحت جلسة auth حقيقية
            $parent->save();
        }
    }
}
