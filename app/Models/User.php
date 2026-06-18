<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;


    // في User.php
    public static function zoomClientID()
    {
        return '4iSGLbyoRfK7tp8dvj5_Nw';
    }

    public static function zoomClientSecret()
    {
        return 'Rw4DDT0hDLQOOLTsXazkAyVZ9ZKMbHd5';
    }

    public static function accountID()
    {
        return '8Ib71QRNQRmFUoXn8bj67w';
    }


    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'school_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * المدرسة التي ينتمي إليها هذا المستخدم. تكون null لمنشئ المنصة العام (Super Admin).
     */
    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }

    /**
     * منشئ المنصة العام (Super Admin) هو مستخدم لا ينتمي لأي مدرسة، أي school_id = NULL.
     */
    public function isSuperAdmin(): bool
    {
        return is_null($this->school_id);
    }

    /**
     * مدير مدرسة: مستخدم منتمٍ لمدرسة (school_id محدد) عبر حارس (Guard) المستخدمين العام (web).
     * لا يوجد عمود role حالياً لأن جدول users لا يحتوي إلا على دور واحد لكل مدرسة (مدير المدرسة)؛
     * أي تمييز أدق بين المعلم/الطالب/ولي الأمر يتم عبر جداول وحراس مصادقة مستقلة بالفعل.
     */
    public function isSchoolAdmin(): bool
    {
        return ! $this->isSuperAdmin();
    }
}
