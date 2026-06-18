<?php

namespace Database\Seeders;

use App\Models\Classroom;
use App\Models\Gender;
use App\Models\Grade;
use App\Models\My_Parent;
use App\Models\Nationalities;
use App\Models\Religions;
use App\Models\School;
use App\Models\sections;
use App\Models\specializations;
use App\Models\students;
use App\Models\Teachers;
use App\Models\Type_Blood;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

/**
 * Seeder تجريبي لبيئة تعدد المستأجرين (Multi-Tenancy / SaaS).
 *
 * ينشئ هذا الـ Seeder مدرستين منفصلتين تماماً (مدرسة أ، مدرسة ب)، كل واحدة
 * بمدير خاص بها وطلاب ومعلمين مرتبطين بـ school_id الخاص بها، لاختبار أن
 * SchoolScope يعزل بيانات كل مدرسة عن الأخرى بشكل صحيح وصامت.
 *
 * يمكن تشغيله منفرداً عبر: php artisan db:seed --class=SchoolSaaSSeeder
 */
class SchoolSaaSSeeder extends Seeder
{
    public function run(): void
    {
        // ── الخطوة 1: التأكد من وجود الحد الأدنى من البيانات المرجعية المشتركة ──
        // (جنس، جنسية، فصيلة دم، دين، تخصص، صف دراسي، فصل، قسم)
        // هذه الجداول مشتركة بين كل المنصة في البنية الحالية وليست معزولة بـ school_id.
        $maleGender = Gender::first() ?? Gender::create(['Name' => ['en' => 'Male', 'ar' => 'ذكر']]);
        $nationality = Nationalities::first() ?? Nationalities::create(['Name' => ['en' => 'Egyptian', 'ar' => 'مصري']]);
        $bloodType = Type_Blood::first() ?? Type_Blood::create(['Name' => 'O+']);
        $religion = Religions::first() ?? Religions::create(['Name' => ['en' => 'Muslim', 'ar' => 'مسلم']]);
        $specialization = specializations::first() ?? specializations::create(['Name' => ['en' => 'Arabic', 'ar' => 'عربي']]);

        $grade = Grade::first() ?? Grade::create(['Name' => ['en' => 'Primary stage', 'ar' => 'المرحلة الابتدائية']]);

        $classroom = Classroom::first() ?? Classroom::create([
            'Name_Class' => ['en' => 'First grade', 'ar' => 'الصف الاول'],
            'Grade_id' => $grade->id,
        ]);

        $section = sections::first() ?? sections::create([
            'Name_Section' => ['en' => 'a', 'ar' => 'ا'],
            'Status' => 1,
            'Grade_id' => $grade->id,
            'Class_id' => $classroom->id,
        ]);

        // ── الخطوة 2: إنشاء "مدرسة الأمل النموذجية" (school_id = 1) ومدير خاص بها ──
        $schoolA = School::firstOrCreate(
            ['slug' => 'al-amal-model-school'],
            [
                'name' => 'مدرسة الأمل النموذجية (Al-Amal School)',
                'company_email' => 'info@al-amal-school.test',
                'phone' => '0100000001',
                'status' => 'active',
            ]
        );

        User::firstOrCreate(
            ['email' => 'admin@al-amal-school.test'],
            [
                'name' => 'مدير مدرسة الأمل',
                'password' => 'password', // يُشفَّر تلقائياً بفضل cast('hashed') الموجود في نموذج User
                'school_id' => $schoolA->id,
            ]
        );

        // ── الخطوة 3: إنشاء "أكاديمية النجاح" (school_id = 2) ومدير خاص بها ──
        $schoolB = School::firstOrCreate(
            ['slug' => 'al-najah-academy'],
            [
                'name' => 'أكاديمية النجاح (Al-Najah Academy)',
                'company_email' => 'info@al-najah-academy.test',
                'phone' => '0100000002',
                'status' => 'active',
            ]
        );

        User::firstOrCreate(
            ['email' => 'admin@al-najah-academy.test'],
            [
                'name' => 'مدير أكاديمية النجاح',
                'password' => 'password',
                'school_id' => $schoolB->id,
            ]
        );

        // ── الخطوة 4: إنشاء ولي أمر مستقل لكل مدرسة (مطلوب لاستيفاء FK: students.parent_id) ──
        // جدول my__parents يملك عمود school_id ويستخدم BelongsToSchool، لذلك يُحقن school_id يدوياً
        // هنا لأن السيدنج لا يعمل تحت جلسة auth حقيقية لمدير المدرسة.
        $parentA = $this->createParent('parent.amal@gmail.com', 'ولي أمر مدرسة الأمل', 'Al-Amal Guardian', $nationality, $bloodType, $religion, $schoolA->id);
        $parentB = $this->createParent('parent.najah@gmail.com', 'ولي أمر أكاديمية النجاح', 'Al-Najah Guardian', $nationality, $bloodType, $religion, $schoolB->id);

        // ── الخطوة 5: معلمون تجريبيون لكل مدرسة (school_id يُحقن صراحةً لعدم وجود جلسة auth وقت السيدنج) ──
        $this->createTeacher('teacher1.amal@gmail.com', 'أحمد محمود', 'Ahmed Mahmoud', $specialization, $maleGender, $schoolA->id);
        $this->createTeacher('teacher2.amal@gmail.com', 'سارة علي', 'Sara Ali', $specialization, $maleGender, $schoolA->id);

        $this->createTeacher('teacher1.najah@gmail.com', 'كريم حسن', 'Karim Hassan', $specialization, $maleGender, $schoolB->id);
        $this->createTeacher('teacher2.najah@gmail.com', 'منى سعيد', 'Mona Saeed', $specialization, $maleGender, $schoolB->id);

        // ── الخطوة 6: طلاب تجريبيون لكل مدرسة ──
        $this->createStudent('student1.amal@gmail.com', 'محمد إبراهيم', 'Mohamed Ibrahim', $maleGender, $nationality, $bloodType, $grade, $classroom, $section, $parentA, $schoolA->id);
        $this->createStudent('student2.amal@gmail.com', 'يوسف خالد', 'Youssef Khaled', $maleGender, $nationality, $bloodType, $grade, $classroom, $section, $parentA, $schoolA->id);

        $this->createStudent('student1.najah@gmail.com', 'عمر طارق', 'Omar Tarek', $maleGender, $nationality, $bloodType, $grade, $classroom, $section, $parentB, $schoolB->id);
        $this->createStudent('student2.najah@gmail.com', 'حسام فؤاد', 'Hossam Fouad', $maleGender, $nationality, $bloodType, $grade, $classroom, $section, $parentB, $schoolB->id);

        // ── الخطوة 7: تصحيح البيانات القديمة اليتيمة (school_id IS NULL) لتتبع المدرسة الافتراضية (أ) ──
        // هذه الخطوة ضرورية لكي لا تنكسر بيانات الاختبار القديمة التي أُدخلت قبل تفعيل تعدد المستأجرين.
        // تحذير: لا يجوز تطبيق هذا التحديث على جدول users، لأن school_id = NULL فيه إشارة مقصودة لحساب Super Admin.
        $orphanedTables = [
            'students',
            'teachers',
            'my__parents',
            'Classrooms',
            'sections',
            'subjects',
            'quizzes',
            'Grades',
            'degrees',
            'attendances',
            'online_classes',
        ];

        foreach ($orphanedTables as $tableName) {
            DB::table($tableName)->whereNull('school_id')->update(['school_id' => $schoolA->id]);
        }
    }

    private function createParent(
        string $email,
        string $nameAr,
        string $nameEn,
        Nationalities $nationality,
        Type_Blood $bloodType,
        Religions $religion,
        int $schoolId
    ): My_Parent {
        $existing = My_Parent::where('email', $email)->first();
        if ($existing) {
            return $existing;
        }

        $parent = new My_Parent();
        $parent->email = $email;
        $parent->password = Hash::make('12345678'); // لا يوجد cast('hashed') في هذا النموذج، فالتشفير اليدوي إلزامي
        $parent->Name_Father = ['ar' => $nameAr, 'en' => $nameEn];
        $parent->National_ID_Father = '29901011234567';
        $parent->Passport_ID_Father = 'A1234567';
        $parent->Phone_Father = '01000000000';
        $parent->Job_Father = ['ar' => 'موظف', 'en' => 'Employee'];
        $parent->Nationality_Father_id = $nationality->id;
        $parent->Blood_Type_Father_id = $bloodType->id;
        $parent->Religion_Father_id = $religion->id;
        $parent->Address_Father = 'القاهرة';
        $parent->Name_Mother = ['ar' => 'زوجة ' . $nameAr, 'en' => 'Wife of ' . $nameEn];
        $parent->National_ID_Mother = '29901011234568';
        $parent->Passport_ID_Mother = 'A1234568';
        $parent->Phone_Mother = '01000000001';
        $parent->Job_Mother = ['ar' => 'ربة منزل', 'en' => 'Housewife'];
        $parent->Nationality_Mother_id = $nationality->id;
        $parent->Blood_Type_Mother_id = $bloodType->id;
        $parent->Religion_Mother_id = $religion->id;
        $parent->Address_Mother = 'القاهرة';
        $parent->school_id = $schoolId; // حقن مباشر لأن السيدنج لا يعمل تحت جلسة auth حقيقية لمدير المدرسة
        $parent->save();

        return $parent;
    }

    private function createTeacher(
        string $email,
        string $nameAr,
        string $nameEn,
        specializations $specialization,
        Gender $gender,
        int $schoolId
    ): Teachers {
        $existing = Teachers::where('email', $email)->first();
        if ($existing) {
            return $existing;
        }

        $teacher = new Teachers();
        $teacher->email = $email;
        $teacher->password = Hash::make('12345678'); // لا يوجد cast('hashed') في هذا النموذج، فالتشفير اليدوي إلزامي
        $teacher->Name = ['ar' => $nameAr, 'en' => $nameEn];
        $teacher->Specialization_id = $specialization->id;
        $teacher->Gender_id = $gender->id;
        $teacher->Joining_Date = now()->toDateString();
        $teacher->Address = 'القاهرة';
        $teacher->school_id = $schoolId; // حقن مباشر لأن السيدنج لا يعمل تحت جلسة auth حقيقية لمدير المدرسة
        $teacher->save();

        return $teacher;
    }

    private function createStudent(
        string $email,
        string $nameAr,
        string $nameEn,
        Gender $gender,
        Nationalities $nationality,
        Type_Blood $bloodType,
        Grade $grade,
        Classroom $classroom,
        sections $section,
        My_Parent $parent,
        int $schoolId
    ): students {
        $existing = students::where('email', $email)->first();
        if ($existing) {
            return $existing;
        }

        $student = new students();
        $student->name = ['ar' => $nameAr, 'en' => $nameEn];
        $student->email = $email;
        $student->password = Hash::make('12345678'); // لا يوجد cast('hashed') في هذا النموذج، فالتشفير اليدوي إلزامي
        $student->gender_id = $gender->id;
        $student->nationalitie_id = $nationality->id;
        $student->blood_id = $bloodType->id;
        $student->Date_Birth = '2012-01-01';
        $student->Grade_id = $grade->id;
        $student->Classroom_id = $classroom->id;
        $student->section_id = $section->id;
        $student->parent_id = $parent->id;
        $student->academic_year = '2025-2026';
        $student->school_id = $schoolId; // حقن مباشر لأن السيدنج لا يعمل تحت جلسة auth حقيقية لمدير المدرسة
        $student->save();

        return $student;
    }
}
