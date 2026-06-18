<?php

namespace Database\Seeders;

use App\Models\Gender;
use Illuminate\Database\Seeder;

class GendersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // حماية من حذف بيانات حقيقية: genders.id مرتبط بـ students/teachers بقيد cascade،
        // فإعادة تشغيل هذا السيدر بعد وجود بيانات فعلية سيحذف كل الطلاب والمعلمين المرتبطين!
        if (Gender::count() > 0) {
            return;
        }

        $genders = [
            ['en' => 'Male', 'ar' => 'ذكر'],
            ['en' => 'Female', 'ar' => 'انثي'],

        ];
        foreach ($genders as $ge) {
            Gender::create(['Name' => $ge]);
        }
    }
}
