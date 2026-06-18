<?php

namespace Database\Seeders;

use App\Models\School;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * الترتيب هنا مهم: كل مجموعة تعتمد على البيانات التي أنشأتها المجموعة السابقة لها
     * (مثلاً Subjects تحتاج Teachers موجودين بالفعل لهذه المدرسة، وDegrees تحتاج Quizzes وStudents).
     */
    public function run(): void
    {
        // ── بيانات عامة على مستوى المنصة كلها، تُنشأ مرة واحدة فقط ──
        $this->call(UserSeeder::class); // منشئ المنصة (Super Admin) — school_id يبقى NULL عمداً
        $this->call(PlanSeeder::class);
        $this->call(SchoolRegistrationSeeder::class);
        $this->call(EventSeeder::class);
        $this->call(FundAccountSeeder::class);
        $this->call(SettingsTableSeeder::class);

        // ── بيانات مرجعية مشتركة بين كل المدارس على المنصة، لا تحتاج لعمود school_id ──
        $this->call(BloodTableSeeder::class);
        $this->call(NationalitiesTableSeeder::class);
        $this->call(ReligionsTableSeeder::class);
        $this->call(SpecializationsSeeder::class);
        $this->call(GendersSeeder::class);

        // ── مدرستان تجريبيتان منفصلتان تماماً، لاختبار أن عزل البيانات (Multi-Tenancy) يعمل
        // بصمت وبشكل صحيح بين مدرسة وأخرى (راجع App\Models\Scopes\SchoolScope) ──
        $schoolA = School::firstOrCreate(
            ['slug' => 'al-amal-model-school'],
            [
                'name' => 'مدرسة الأمل النموذجية (Al-Amal School)',
                'company_email' => 'info@al-amal-school.test',
                'phone' => '0100000001',
                'status' => 'active',
            ]
        );

        $schoolB = School::firstOrCreate(
            ['slug' => 'al-najah-academy'],
            [
                'name' => 'أكاديمية النجاح (Al-Najah Academy)',
                'company_email' => 'info@al-najah-academy.test',
                'phone' => '0100000002',
                'status' => 'active',
            ]
        );

        foreach ([$schoolA, $schoolB] as $school) {
            // حساب مدير لهذه المدرسة، حتى يمكن تسجيل الدخول إليها فعلياً واختبار عزل البيانات
            User::firstOrCreate(
                ['email' => 'admin@' . $school->slug . '.test'],
                [
                    'name' => 'مدير ' . $school->name,
                    'password' => 'password', // يُشفَّر تلقائياً بفضل cast('hashed') في نموذج User
                    'school_id' => $school->id,
                ]
            );

            $this->seedSchool($school);
        }
    }

    /**
     * يُنشئ كل البيانات الأكاديمية والمالية لمدرسة واحدة، بترتيب يحترم الاعتماديات
     * بين الجداول (Foreign Keys). الـ Seeders التالية تنشئ سجلات في جداول معزولة بـ
     * school_id، فنُمرّر المدرسة إليها صراحةً عبر callWith لأن السيدنج لا يعمل تحت
     * جلسة auth حقيقية يمكن أن تحقن school_id تلقائياً.
     */
    private function seedSchool(School $school): void
    {
        $this->callWith(GradeSeeder::class, ['school' => $school]);
        $this->callWith(ClassroomTableSeeder::class, ['school' => $school]);
        $this->callWith(SectionsTableSeeder::class, ['school' => $school]);
        $this->callWith(TeacherSeeder::class, ['school' => $school]);
        $this->callWith(TeacherSectionSeeder::class, ['school' => $school]);
        $this->callWith(ParentsTableSeeder::class, ['school' => $school]);
        $this->callWith(StudentsTableSeeder::class, ['school' => $school]);

        $this->callWith(SubjectSeeder::class, ['school' => $school]);
        $this->callWith(QuizSeeder::class, ['school' => $school]);
        $this->callWith(QuestionSeeder::class, ['school' => $school]);
        $this->callWith(DegreeSeeder::class, ['school' => $school]);
        $this->callWith(AttendanceSeeder::class, ['school' => $school]);

        $this->callWith(FeeSeeder::class, ['school' => $school]);
        $this->callWith(FeeInvoiceSeeder::class, ['school' => $school]);
        $this->callWith(ReceiptStudentSeeder::class, ['school' => $school]);
        $this->callWith(ProcessingFeeSeeder::class, ['school' => $school]);
        $this->callWith(PaymentStudentSeeder::class, ['school' => $school]);
        $this->callWith(StudentAccountSeeder::class, ['school' => $school]);

        $this->callWith(LibrarySeeder::class, ['school' => $school]);
        $this->callWith(OnlineClassSeeder::class, ['school' => $school]);
        $this->callWith(PromotionSeeder::class, ['school' => $school]);
    }
}
