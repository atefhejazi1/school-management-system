<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * نموذج "الفترة الامتحانية" (Exam) كان موجوداً في الكود منذ فترة لكن جدوله الحقيقي
     * لم يُنشأ قط؛ هذا الترحيل يُنشئه فعلياً بدلاً من إضافة جدول مستقل جديد، حتى تتمكن
     * بطاقات الأداء (Report Cards) من تجميع علامات الطلاب حسب الفصل/الدورة الامتحانية.
     */
    public function up(): void
    {
        Schema::create('exams', function (Blueprint $table) {
            $table->id();
            $table->text('name');
            $table->string('term')->nullable();
            $table->string('academic_year')->nullable();
            $table->foreignId('school_id')->nullable()->references('id')->on('schools')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('exams');
    }
};
