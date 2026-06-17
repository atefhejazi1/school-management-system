<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * إضافة عمود school_id إلى جدول الطلاب (students) لتفعيل عزل البيانات بين المدارس (Multi-Tenancy).
     * يبقى العمود قابلاً لقيمة NULL مؤقتاً للسجلات القديمة، ثم تتم تعبئتها لاحقاً عبر SchoolSaaSSeeder.
     */
    public function up(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->foreignId('school_id')
                ->nullable()
                ->after('id')
                ->constrained('schools')
                ->nullOnDelete(); // عند حذف المدرسة، لا يُحذف الطالب، فقط يُفصل عنها
        });
    }

    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropForeign(['school_id']);
            $table->dropColumn('school_id');
        });
    }
};
