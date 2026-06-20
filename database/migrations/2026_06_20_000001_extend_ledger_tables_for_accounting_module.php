<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * تتمة عزل البيانات بين المدارس (Multi-Tenancy) على جداول المحاسبة السبعة
     * التي لم تُشملها مايجريشن 2026_06_18_000003 سابقاً (تلك المايجريشن استثنت
     * جداول الرسوم/الفواتير/السندات عن قصد لأنها لم تكن جاهزة للتعديل وقتها).
     *
     * نتبع هنا بالضبط نفس قاعدة العمل المعتمدة مسبقاً في المايجريشن السابقة:
     * العمود nullable بدون أي Backfill للبيانات القديمة. هذا قرار مقصود ومتسق
     * مع ما سبق (وليس إغفالاً)، إذ لا توجد بيانات إنتاج حقيقية بعد، وإضافة
     * Backfill هنا فقط لهذه الجداول دون غيرها كانت ستُكسر الاتساق مع النمط العام.
     */
    private array $tables = [
        'fees',
        'fee_invoices',
        'receipt_students',
        'processing_fees',
        'payment_students',
        'student_accounts',
        'fund_accounts',
    ];

    public function up(): void
    {
        foreach ($this->tables as $tableName) {
            Schema::table($tableName, function (Blueprint $table) {
                $table->foreignId('school_id')
                    ->nullable()
                    ->after('id')
                    ->constrained('schools')
                    ->onDelete('cascade');
            });
        }

        // receipt_students هو سجل "الدفعة المستلَمة" الفعلي في هذا النظام (وليس جدول
        // payments منفصل)، لذلك نُضيف عليه مباشرة وسيلة الدفع ومُسجِّل العملية بدلاً
        // من إنشاء جدول جديد مُكرِّر يُزاحم نظام دفتر الأستاذ (Ledger) الحالي
        Schema::table('receipt_students', function (Blueprint $table) {
            // وسيلة الدفع كنص حر (كاش، شيك، تحويل بنكي...) بدلاً من Enum مُقيَّد،
            // لتفادي الحاجة لمايجريشن جديدة عند إضافة وسيلة دفع لم تكن متوقَّعة
            $table->string('payment_method')->nullable()->after('Debit');

            // nullOnDelete (لا cascade) لأن حذف حساب المستخدم الذي سجَّل الدفعة
            // يجب ألا يحذف السجل المحاسبي نفسه، فقط يُفقد مرجع "من سجَّلها"
            $table->foreignId('recorded_by')
                ->nullable()
                ->after('payment_method')
                ->constrained('users')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('receipt_students', function (Blueprint $table) {
            $table->dropForeign(['recorded_by']);
            $table->dropColumn(['recorded_by', 'payment_method']);
        });

        foreach (array_reverse($this->tables) as $tableName) {
            Schema::table($tableName, function (Blueprint $table) {
                $table->dropForeign(['school_id']);
                $table->dropColumn('school_id');
            });
        }
    }
};
