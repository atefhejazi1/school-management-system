<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * firstOrCreate بدلاً من DB::table()->insert() المباشر، حتى يكون تشغيل السيدنج
     * أكثر من مرة على قاعدة بيانات تحتوي على هذا المستخدم بالفعل أمراً آمناً (idempotent)
     * بدلاً من فشله بخطأ تكرار البريد الإلكتروني الفريد (unique).
     */
    public function run(): void
    {
        // school_id يبقى NULL عمداً: هذا هو منشئ المنصة العام (Super Admin)، راجع User::isSuperAdmin()
        User::firstOrCreate(
            ['email' => 'atefhejazi10@gmail.com'],
            [
                'name' => 'Atef Hejazi',
                'password' => '123456789', // يُشفَّر تلقائياً بفضل cast('hashed') في نموذج User
                'school_id' => null,
            ]
        );
    }
}
