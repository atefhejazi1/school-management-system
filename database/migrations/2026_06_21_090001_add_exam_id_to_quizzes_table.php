<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * يربط كل اختبار (quiz) بفترة امتحانية (exam/term) اختيارياً، فتصبح بطاقة الأداء
     * قادرة على تجميع علامات الطالب في مادة معيّنة ضمن فصل/دورة محدَّدة فقط، بدل جمع
     * كل اختباراته منذ بداية العام في رقم واحد غير دقيق.
     */
    public function up(): void
    {
        Schema::table('quizzes', function (Blueprint $table) {
            $table->foreignId('exam_id')->nullable()->after('teacher_id')
                ->references('id')->on('exams')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('quizzes', function (Blueprint $table) {
            $table->dropForeign(['exam_id']);
            $table->dropColumn('exam_id');
        });
    }
};
