<?php

namespace Database\Seeders;

use App\Models\Type_Blood;
use Illuminate\Database\Seeder;

class BloodTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // حماية من حذف بيانات حقيقية: type__bloods.id مرتبط بـ students/my__parents بقيد cascade،
        // فإعادة تشغيل هذا السيدر بعد وجود بيانات فعلية سيحذف كل السجلات المرتبطة!
        if (Type_Blood::count() > 0) {
            return;
        }

        $bgs = ['O-', 'O+', 'A+', 'A-', 'B+', 'B-', 'AB+', 'AB-'];

        foreach ($bgs as  $bg) {
            Type_Blood::create(['Name' => $bg]);
        }
    }
}
