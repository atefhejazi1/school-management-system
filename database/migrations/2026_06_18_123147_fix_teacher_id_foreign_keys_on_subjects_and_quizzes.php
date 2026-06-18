<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * يصحّح خطأ نسخ-ولصق في migrations جدولي subjects و quizzes: عمود teacher_id كان يشير
     * بالخطأ إلى جدول Classrooms بدلاً من teachers، بينما العلاقات في الموديلات (Subject::teacher(),
     * Quizze::teacher()) تفترض دائماً أنه يشير إلى teachers. لم يكن هذا الخطأ يظهر إلا عند محاولة
     * إدراج معرّف معلّم حقيقي لا يُصادف أن يكون أيضاً معرّف فصل دراسي صالح، فيفشل قيد المفتاح الخارجي.
     */
    public function up(): void
    {
        Schema::table('subjects', function (Blueprint $table) {
            $table->dropForeign(['teacher_id']);
            $table->foreign('teacher_id')->references('id')->on('teachers')->onDelete('cascade');
        });

        Schema::table('quizzes', function (Blueprint $table) {
            $table->dropForeign(['teacher_id']);
            $table->foreign('teacher_id')->references('id')->on('teachers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('subjects', function (Blueprint $table) {
            $table->dropForeign(['teacher_id']);
            $table->foreign('teacher_id')->references('id')->on('Classrooms')->onDelete('cascade');
        });

        Schema::table('quizzes', function (Blueprint $table) {
            $table->dropForeign(['teacher_id']);
            $table->foreign('teacher_id')->references('id')->on('Classrooms')->onDelete('cascade');
        });
    }
};
