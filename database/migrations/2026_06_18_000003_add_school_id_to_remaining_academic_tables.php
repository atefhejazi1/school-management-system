<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * إضافة عمود school_id إلى باقي الجداول الأكاديمية لاستكمال عزل البيانات بين المدارس (Multi-Tenancy).
     *
     * ملاحظة هامة: تم استثناء الجداول 'users' و 'students' و 'teachers' من هذه القائمة،
     * لأن عمود school_id أُضيف إليها مسبقاً في مايجريشن سابقة، ولا يجوز إضافة العمود مرتين لنفس الجدول.
     *
     * تعيين الأسماء التي طلبها العميل إلى أسماء الجداول الفعلية الموجودة بالفعل في قاعدة البيانات:
     *   parents    → my__parents      (جدول أولياء الأمور)
     *   classes    → Classrooms       (جدول الفصول الدراسية)
     *   sections   → sections         (جدول الأقسام الدراسية)
     *   subjects   → subjects         (جدول المواد الدراسية)
     *   exams      → quizzes          (جدول الاختبارات)
     *   grades     → Grades + degrees (Grades = المراحل الدراسية، degrees = درجات الطلاب في الاختبارات)
     *   attendance → attendances      (جدول الحضور والغياب)
     *   schedules  → online_classes   (لا يوجد جدول "schedules" مستقل في النظام، وأقرب جدول مطابق هو جدولة الحصص عبر الإنترنت)
     */
    private array $tables = [
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

    /**
     * تنفيذ المايجريشن: إضافة عمود school_id لكل جدول من الجداول المذكورة أعلاه.
     */
    public function up(): void
    {
        foreach ($this->tables as $tableName) {
            Schema::table($tableName, function (Blueprint $table) {
                // nullable() إلزامية هنا لضمان عدم تعطّل أي بيانات تجريبية موجودة حالياً في الجدول
                // عند تنفيذ المايجريشن لأول مرة على قاعدة بيانات تحتوي على بيانات قديمة بدون school_id
                $table->foreignId('school_id')
                    ->nullable()
                    ->after('id')
                    ->constrained('schools')
                    ->onDelete('cascade'); // حذف المدرسة من لوحة Super Admin يحذف تلقائياً كل سجلاتها المرتبطة
            });
        }
    }

    /**
     * التراجع عن المايجريشن: حذف القيد الخارجي (Foreign Key) أولاً، ثم حذف العمود نفسه،
     * بالترتيب المعكوس تماماً عن ترتيب التنفيذ في up() لتجنّب أي تعارض أو قفل (deadlock) بين الجداول.
     */
    public function down(): void
    {
        foreach (array_reverse($this->tables) as $tableName) {
            Schema::table($tableName, function (Blueprint $table) {
                $table->dropForeign(['school_id']);
                $table->dropColumn('school_id');
            });
        }
    }
};
