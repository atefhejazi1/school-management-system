<?php

namespace Database\Seeders;

use App\Models\SchoolRegistration;
use Illuminate\Database\Seeder;

class SchoolRegistrationSeeder extends Seeder
{
    /**
     * طلبات تسجيل تجريبية بحالات مختلفة (قيد المراجعة/مرفوض)، لاختبار صفحة
     * "طلبات تسجيل المدارس" في لوحة منشئ المنصة. لا تُولِّد طلبات "مقبولة" هنا لأن
     * الموافقة الحقيقية تُنشئ مدرسة وحساب مدير فعليين عبر SchoolRequests Livewire،
     * وليس مجرد تحديث عمود status.
     */
    public function run(): void
    {
        $registrations = [
            [
                'school_name' => 'مدرسة المستقبل الحديثة',
                'contact_name' => 'خالد منصور',
                'email' => 'khaled@future-school.test',
                'phone' => '0101111111',
                'city' => 'الإسكندرية',
                'student_count' => '100_300',
                'message' => 'نرغب في تجربة المنصة لإدارة مدرستنا الجديدة.',
                'status' => 'pending',
            ],
            [
                'school_name' => 'أكاديمية الرواد',
                'contact_name' => 'منى عبد الله',
                'email' => 'mona@al-rowad.test',
                'phone' => '0102222222',
                'city' => 'الجيزة',
                'student_count' => 'less_100',
                'message' => 'مدرسة ابتدائية صغيرة، نريد البدء بالباقة الأساسية.',
                'status' => 'pending',
            ],
            [
                'school_name' => 'مدرسة بلا ترخيص',
                'contact_name' => 'سامي فتحي',
                'email' => 'sami@no-license.test',
                'phone' => '0103333333',
                'city' => 'المنصورة',
                'student_count' => 'more_300',
                'message' => null,
                'status' => 'rejected',
                'admin_notes' => 'لم يتم تقديم ترخيص تعليمي رسمي.',
            ],
        ];

        foreach ($registrations as $registration) {
            SchoolRegistration::firstOrCreate(['email' => $registration['email']], $registration);
        }
    }
}
