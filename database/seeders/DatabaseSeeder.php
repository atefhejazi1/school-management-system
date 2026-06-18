<?php

namespace Database\Seeders;

use App\Models\Nationalities;
use App\Models\School;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // مستخدم منشئ المنصة (Super Admin) — يبقى بدون school_id عمداً، لا ينتمي لأي مدرسة
        $this->call(UserSeeder::class);

        // ── إنشاء/إعادة استخدام المدرسة الافتراضية التي تنتمي إليها كل البيانات التجريبية القديمة ──
        // نفس slug المدرسة "School A" التي ينشئها SchoolSaaSSeeder، لضمان توافق البيانات
        // وعدم تكرار المدرسة إذا تم تشغيل الـ Seeder-ين معاً على نفس قاعدة البيانات.
        $defaultSchool = School::firstOrCreate(
            ['slug' => 'al-amal-model-school'],
            [
                'name' => 'مدرسة الأمل النموذجية (Al-Amal School)',
                'company_email' => 'info@al-amal-school.test',
                'phone' => '0100000001',
                'status' => 'active',
            ]
        );

        // الـ Seeders التالية تنشئ سجلات في جداول معزولة بـ school_id، فنُمرّر المدرسة الافتراضية
        // إليها صراحةً عبر callWith لأن السيدنج لا يعمل تحت جلسة auth حقيقية يمكن أن تحقن school_id تلقائياً.
        $this->callWith(GradeSeeder::class, ['school' => $defaultSchool]);
        $this->callWith(ClassroomTableSeeder::class, ['school' => $defaultSchool]);
        $this->callWith(SectionsTableSeeder::class, ['school' => $defaultSchool]);

        // بيانات مرجعية مشتركة بين كل المدارس على المنصة، لا تحتاج لعمود school_id
        $this->call(BloodTableSeeder::class);
        $this->call(NationalitiesTableSeeder::class);
        $this->call(ReligionsTableSeeder::class);
        $this->call(SpecializationsSeeder::class);
        $this->call(GendersSeeder::class);

        $this->callWith(ParentsTableSeeder::class, ['school' => $defaultSchool]);
        $this->callWith(StudentsTableSeeder::class, ['school' => $defaultSchool]);

        $this->call(SettingsTableSeeder::class);
    }
}
