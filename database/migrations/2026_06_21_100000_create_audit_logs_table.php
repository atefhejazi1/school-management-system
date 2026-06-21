<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * سجل تدقيق موحَّد لكل التعديلات الحسّاسة في النظام (علامات، فواتير، سدادات...).
     * school_id قابل لقيمة فارغة (nullable) خصيصاً لأن منشئ المنصة (Super Admin) قد
     * ينفّذ عمليات لا تتبع مدرسة واحدة بعينها، وكذلك user_id قابل لقيمة فارغة لتغطية
     * أي عملية تُنفَّذ من سياق بلا مستخدم مسجَّل دخوله (Console / Seeder).
     */
    public function up(): void
    {
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->nullable()->references('id')->on('schools')->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->references('id')->on('users')->onDelete('set null');
            $table->string('action');
            $table->string('model_type');
            $table->unsignedBigInteger('model_id');
            $table->json('payload')->nullable();
            $table->string('ip_address')->nullable();
            $table->timestamps();

            $table->index(['model_type', 'model_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('audit_logs');
    }
};
