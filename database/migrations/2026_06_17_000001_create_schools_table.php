<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * إنشاء جدول المدارس (Tenants) — كل سجل هنا يمثل مدرسة مستقلة (مستأجر)
     * ضمن قاعدة البيانات الموحدة لمنصة SaaS.
     */
    public function up(): void
    {
        Schema::create('schools', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            // معرف فريد للمدرسة، يُستخدم في الروابط أو كنطاق فرعي (subdomain) مستقبلاً
            $table->string('slug')->unique();
            $table->string('company_email')->nullable();
            $table->string('phone')->nullable();
            // pending: تم إنشاؤها ولم تُفعَّل بعد | active: مفعّلة وتعمل | suspended: معلّقة من الإدارة
            $table->enum('status', ['pending', 'active', 'suspended'])->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('schools');
    }
};
