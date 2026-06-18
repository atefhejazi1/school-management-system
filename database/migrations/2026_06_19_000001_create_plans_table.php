<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * إنشاء جدول الباقات (Plans) — يحدد كل سجل هنا حد الطلاب الأقصى المسموح به
     * وسعر الباقة، وتُستخدم هذه البيانات لاحقاً لتطبيق حدود السعة (Capacity Limits)
     * على كل مدرسة (مستأجر) حسب الباقة المرتبطة بها.
     */
    public function up(): void
    {
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            // اسم الباقة المعروض للمستخدم، مثل: أساسية، متقدمة، مميزة
            $table->string('name');
            // معرف فريد للباقة يُستخدم برمجياً (Basic, Premium, ...)
            $table->string('slug')->unique();
            // الحد الأقصى لعدد الطلاب المسموح بتسجيلهم ضمن هذه الباقة
            $table->unsignedInteger('max_students');
            $table->decimal('price', 10, 2);
            // تتيح إخفاء باقة قديمة من قوائم الاختيار دون حذفها أو كسر المدارس المرتبطة بها فعلاً
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('plans');
    }
};
