<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
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
    ];

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

    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    public function isSuspended(): bool
    {
        return $this->status === 'suspended';
    }
}
