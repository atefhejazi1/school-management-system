<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * ربط طلب التسجيل بسجل المدرسة الذي يُنشأ عند الموافقة عليه.
     * يسمح هذا الربط بمتابعة حالة المدرسة (نشطة / معلّقة) من نفس صف الطلب
     * في لوحة تحكم منشئ المنصة (Super Admin)، دون الحاجة لجدول وسيط إضافي.
     */
    public function up(): void
    {
        Schema::table('school_registrations', function (Blueprint $table) {
            $table->foreignId('school_id')
                ->nullable()
                ->after('id')
                ->constrained('schools')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('school_registrations', function (Blueprint $table) {
            $table->dropForeign(['school_id']);
            $table->dropColumn('school_id');
        });
    }
};
