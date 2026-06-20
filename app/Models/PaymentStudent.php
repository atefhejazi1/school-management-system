<?php

namespace App\Models;

use App\Traits\BelongsToSchool;
use Illuminate\Database\Eloquent\Model;

class PaymentStudent extends Model
{
    // تفعيل عزل البيانات بين المدارس (Multi-Tenancy) — يضيف فلتر school_id تلقائياً بصمت
    use BelongsToSchool;
    protected $guarded = [];

    public function student()
    {
        return $this->belongsTo(students::class, 'student_id');
    }
}
