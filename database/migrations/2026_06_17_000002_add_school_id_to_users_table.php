<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * إضافة عمود school_id إلى جدول المستخدمين (users).
     * NULL = منشئ المنصة العام (Super Admin) | قيمة رقمية = مسؤول/مستخدم تابع لمدرسة محددة.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('school_id')
                ->nullable()
                ->after('id')
                ->constrained('schools')
                ->nullOnDelete(); // لا يُحذف المستخدم إذا حُذفت المدرسة، فقط يُفصل عنها
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['school_id']);
            $table->dropColumn('school_id');
        });
    }
};
