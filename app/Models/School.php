<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class School extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'company_email',
        'phone',
        'status',
        'plan_id',
        'subscription_expires_at',
    ];

    protected function casts(): array
    {
        return [
            // التحويل التلقائي إلى Carbon يسمح باستخدام isPast()/isFuture() مباشرة
            // دون الحاجة لتحويل النص يدوياً في كل مرة (مثلاً داخل الميدلوير)
            'subscription_expires_at' => 'datetime',
        ];
    }

    /**
     * مستخدمو هذه المدرسة (مدير المدرسة، المعلمون من خلال جدول users إن وُجدوا، إلخ).
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    /**
     * طلب التسجيل الأصلي الذي نتج عنه إنشاء هذه المدرسة.
     */
    public function registration(): HasOne
    {
        return $this->hasOne(SchoolRegistration::class);
    }

    /**
     * باقة الاشتراك الحالية لهذه المدرسة، تحدد الحد الأقصى لعدد الطلاب المسموح به.
     */
    public function plan(): BelongsTo
    {
        return $this->belongsTo(Plan::class);
    }

    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    public function isSuspended(): bool
    {
        return $this->status === 'suspended';
    }

    /**
     * هل انتهت صلاحية الاشتراك؟ المقارنة تتم بين subscription_expires_at والوقت الحالي (now()).
     * مدرسة بدون تاريخ انتهاء محدد (NULL) تُعتبر غير منتهية الصلاحية (مثلاً أثناء فترة تجريبية لا نهائية).
     */
    public function isSubscriptionExpired(): bool
    {
        return ! is_null($this->subscription_expires_at) && $this->subscription_expires_at->isPast();
    }
}
