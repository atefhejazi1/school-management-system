<?php

namespace Database\Seeders;

use App\Models\Religions;
use Illuminate\Database\Seeder;

class ReligionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // حماية من حذف بيانات حقيقية: religions.id مرتبط بـ my__parents بقيد cascade،
        // فإعادة تشغيل هذا السيدر بعد وجود بيانات فعلية سيحذف كل السجلات المرتبطة!
        if (Religions::count() > 0) {
            return;
        }

        $religions = [

            [
                'en'=> 'Muslim',
                'ar'=> 'مسلم'
            ],
            [
                'en'=> 'Christian',
                'ar'=> 'مسيحي'
            ],
            [
                'en'=> 'Other',
                'ar'=> 'غيرذلك'
            ],

        ];

        foreach ($religions as $R) {
            Religions::create(['Name' => $R]);
        }
    }
}
