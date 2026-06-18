<?php

namespace Database\Seeders;

use App\Models\specializations;
use Illuminate\Database\Seeder;

class SpecializationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // حماية من حذف بيانات حقيقية: specializations.id مرتبط بـ teachers بقيد cascade،
        // فإعادة تشغيل هذا السيدر بعد وجود بيانات فعلية سيحذف كل المعلمين المرتبطين!
        if (specializations::count() > 0) {
            return;
        }

        $specializations = [
            ['en' => 'Arabic', 'ar' => 'عربي'],
            ['en' => 'Sciences', 'ar' => 'علوم'],
            ['en' => 'Computer', 'ar' => 'حاسب الي'],
            ['en' => 'English', 'ar' => 'انجليزي'],
        ];
        foreach ($specializations as $S) {
            specializations::create(['Name' => $S]);
        }
    }
}
