<?php

namespace Database\Seeders;

use App\Models\Plan;
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

        $basicPlan = Plan::where('slug', 'basic')->first();
        $advancedPlan = Plan::where('slug', 'advanced')->first();
        $premiumPlan = Plan::where('slug', 'premium')->first();

        // ── ثلاث مدارس فعّالة بالكامل (بيانات أكاديمية ومالية كاملة لكل واحدة منها)،
        // لاختبار أن عزل البيانات (Multi-Tenancy) يعمل بصمت وبشكل صحيح بين أكثر من
        // مدرستين معاً (راجع App\Models\Scopes\SchoolScope)، وتغطية حالتي اشتراك
        // مختلفتين: مدرستان سليمتا الاشتراك، ومدرسة اشتراكها على وشك الانتهاء
        // (لاختبار شريط التنبيه) ──
        $schools = [
            [
                'slug' => 'al-amal-model-school',
                'name' => 'مدرسة الأمل النموذجية (Al-Amal School)',
                'company_email' => 'info@al-amal-school.test',
                'phone' => '0100000001',
                'admin_email' => 'admin@al-amal-model-school.test',
                'plan_id' => $advancedPlan?->id,
                'subscription_expires_at' => now()->addDays(90), // اشتراك سليم
            ],
            [
                'slug' => 'al-najah-academy',
                'name' => 'أكاديمية النجاح (Al-Najah Academy)',
                'company_email' => 'info@al-najah-academy.test',
                'phone' => '0100000002',
                'admin_email' => 'admin@al-najah-academy.test',
                'plan_id' => $basicPlan?->id,
                'subscription_expires_at' => now()->addDays(5), // يفعّل شريط تنبيه اقتراب الانتهاء
            ],
            [
                'slug' => 'al-rowad-academy',
                'name' => 'أكاديمية الرواد (Al-Rowad Academy)',
                'company_email' => 'info@al-rowad-academy.test',
                'phone' => '0100000003',
                // بريد المدير هنا مطابق تماماً لبريد طلب التسجيل التجريبي "مونا عبد الله"
                // (راجع SchoolRegistrationSeeder)، لمحاكاة مدرسة وافق منشئ المنصة على
                // طلبها فعلياً وأصبح لها الآن حساب مدير ولوحة تحكم كاملة بالبيانات
                'admin_email' => 'mona@al-rowad.test',
                'plan_id' => $premiumPlan?->id,
                'subscription_expires_at' => now()->addDays(120), // اشتراك سليم
            ],
        ];

        foreach ($schools as $schoolData) {
            $school = School::firstOrCreate(
                ['slug' => $schoolData['slug']],
                [
                    'name' => $schoolData['name'],
                    'company_email' => $schoolData['company_email'],
                    'phone' => $schoolData['phone'],
                    'status' => 'active',
                    'plan_id' => $schoolData['plan_id'],
                    'subscription_expires_at' => $schoolData['subscription_expires_at'],
                ]
            );

            // حساب مدير لهذه المدرسة، حتى يمكن تسجيل الدخول إليها فعلياً واختبار عزل البيانات
            User::firstOrCreate(
                ['email' => $schoolData['admin_email']],
                [
                    'name' => 'مدير ' . $school->name,
                    'password' => 'password', // يُشفَّر تلقائياً بفضل cast('hashed') في نموذج User
                    'school_id' => $school->id,
                ]
            );

            $this->seedSchool($school);
        }

        // أي مدرسة أخرى على المنصة لم تُذكر أعلاه (مثلاً مدرسة تمت الموافقة على طلب
        // تسجيلها فعلياً من خلال لوحة منشئ المنصة أثناء الاختبار) تحصل أيضاً على بيانات
        // تجريبية كاملة عند إعادة تشغيل السيدنج، حتى لا تظهر فارغة بدون بيانات بالخطأ
        School::whereNotIn('slug', collect($schools)->pluck('slug'))
            ->get()
            ->each(fn (School $school) => $this->seedSchool($school));
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

        $this->callWith(ExamSeeder::class, ['school' => $school]);
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
