<?php

namespace App\Models;

use App\Traits\BelongsToSchool;
use Illuminate\Database\Eloquent\Model;

class StudentAccount extends Model
{
    // تفعيل عزل البيانات بين المدارس (Multi-Tenancy) — يضيف فلتر school_id تلقائياً بصمت
    use BelongsToSchool;
    protected $guarded = [];

    public function student()
    {
        return $this->belongsTo(students::class, 'student_id');
    }

    public function feeInvoice()
    {
        return $this->belongsTo(Fee_invoice::class, 'fee_invoice_id');
    }
}
