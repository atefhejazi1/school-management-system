<?php

namespace Database\Seeders;

use App\Models\My_Parent;
use App\Models\Nationalities;
use App\Models\Religions;
use App\Models\Type_Blood;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ParentsTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('my__parents')->delete();
        $my_parents = new My_Parent();
        $my_parents->email = 'parent@gmail.com';
        $my_parents->password = Hash::make('12345678');
        $my_parents->Name_Father = ['en' => 'mohammed mohammed', 'ar' => 'محمد محمد'];
        $my_parents->National_ID_Father = '1234567810';
        $my_parents->Passport_ID_Father = '1234567810';
        $my_parents->Phone_Father = '1234567810';
        $my_parents->Job_Father = ['en' => 'programmer', 'ar' => 'مبرمج'];
        $my_parents->Nationality_Father_id = Nationalities::all()->unique()->random()->id;
        $my_parents->Blood_Type_Father_id = Type_Blood::all()->unique()->random()->id;
        $my_parents->Religion_Father_id = Religions::all()->unique()->random()->id;
        $my_parents->Address_Father = 'القاهرة';
        $my_parents->Name_Mother = ['en' => 'SS', 'ar' => 'سس'];
        $my_parents->National_ID_Mother = '1234567810';
        $my_parents->Passport_ID_Mother = '1234567810';
        $my_parents->Phone_Mother = '1234567810';
        $my_parents->Job_Mother = ['en' => 'Teacher', 'ar' => 'معلمة'];
        $my_parents->Nationality_Mother_id = Nationalities::all()->unique()->random()->id;
        $my_parents->Blood_Type_Mother_id = Type_Blood::all()->unique()->random()->id;
        $my_parents->Religion_Mother_id = Religions::all()->unique()->random()->id;
        $my_parents->Address_Mother = 'القاهرة';
        $my_parents->save();
    }
}
