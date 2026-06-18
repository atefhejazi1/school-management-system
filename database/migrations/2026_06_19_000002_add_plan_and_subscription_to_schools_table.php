<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * ربط كل مدرسة بباقة اشتراك (plan_id) وإضافة تاريخ انتهاء الاشتراك (subscription_expires_at).
     * لا نُعدّل migration جدول schools الأصلي مباشرةً لأنه قد يكون نُفّذ (migrated) بالفعل
     * على بيئات سابقة؛ تعديل migration منفّذة مسبقاً لا يُعاد تطبيقه تلقائياً بواسطة Laravel.
     */
    public function up(): void
    {
        Schema::table('schools', function (Blueprint $table) {
            // nullable لأن المدارس القديمة قد لا تملك باقة محددة بعد؛ عند حذف الباقة
            // تبقى المدرسة موجودة لكن plan_id يصبح NULL بدلاً من حذف المدرسة بالكامل
            $table->foreignId('plan_id')
                ->nullable()
                ->after('status')
                ->constrained('plans')
                ->nullOnDelete();

            // تاريخ ووقت انتهاء صلاحية الاشتراك الحالي؛ NULL يعني عدم وجود اشتراك مفعَّل بعد
            $table->timestamp('subscription_expires_at')->nullable()->after('plan_id');
        });
    }

    public function down(): void
    {
        Schema::table('schools', function (Blueprint $table) {
            $table->dropForeign(['plan_id']);
            $table->dropColumn(['plan_id', 'subscription_expires_at']);
        });
    }
};
