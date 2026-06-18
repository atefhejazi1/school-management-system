<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

/**
 * إعدادات المنصة العامة (Global Platform Settings) — جدول key/value مستقل تماماً
 * عن جدول "settings" القديم الخاص بإعدادات كل مدرسة على حدة (الشعار، الاسم...).
 * لا يوجد هنا أي عزل (Scope) على مستوى المدرسة لأن هذه القيم عامة لكل المنصة.
 */
class PlatformSetting extends Model
{
    protected $fillable = [
        'key',
        'value',
    ];

    /**
     * قراءة قيمة إعداد عام واحد عبر مفتاحه، مع تخزين مؤقت (Cache) لمدة ساعة لتفادي
     * استعلام قاعدة البيانات في كل طلب (مثل التحقق من allow_public_registration
     * في صفحة التسجيل العامة التي تُزار كثيراً).
     */
    public static function get(string $key, ?string $default = null): ?string
    {
        return Cache::remember("platform_setting:{$key}", 3600, function () use ($key, $default) {
            return static::where('key', $key)->value('value') ?? $default;
        });
    }

    /**
     * تحديث أو إنشاء قيمة إعداد عام، مع إفراغ النسخة المخزَّنة مؤقتاً فوراً
     * بحيث ينعكس التغيير في نفس اللحظة على كل زوار المنصة.
     */
    public static function set(string $key, ?string $value): void
    {
        static::updateOrCreate(['key' => $key], ['value' => $value]);

        Cache::forget("platform_setting:{$key}");
    }
}
