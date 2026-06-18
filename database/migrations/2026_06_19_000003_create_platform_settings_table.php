<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * جدول مستقل تماماً عن جدول "settings" القديم (الخاص بإعدادات كل مدرسة مثل الشعار والاسم)؛
     * هذا الجدول خاص فقط بمتغيرات المنصة العامة التي يتحكم بها منشئ المنصة (Super Admin)
     * ولا علاقة لها بأي مدرسة بعينها، مثل السماح بالتسجيل العام وقالب رسالة واتساب الترحيبية.
     */
    public function up(): void
    {
        Schema::create('platform_settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('platform_settings');
    }
};
