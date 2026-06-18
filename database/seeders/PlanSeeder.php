<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    /**
     * باقات الاشتراك العامة على المنصة — غير مرتبطة بأي مدرسة بعينها.
     * firstOrCreate عبر slug يضمن أن تشغيل السيدنج أكثر من مرة لا يكرر الباقات.
     */
    public function run(): void
    {
        $plans = [
            ['name' => 'أساسية', 'slug' => 'basic', 'max_students' => 100, 'price' => 49.99, 'is_active' => true],
            ['name' => 'متقدمة', 'slug' => 'advanced', 'max_students' => 300, 'price' => 99.99, 'is_active' => true],
            ['name' => 'مميزة', 'slug' => 'premium', 'max_students' => 1000, 'price' => 199.99, 'is_active' => true],
        ];

        foreach ($plans as $plan) {
            Plan::firstOrCreate(['slug' => $plan['slug']], $plan);
        }
    }
}
