<?php

namespace App\Models;

use App\Traits\BelongsToSchool;
use Illuminate\Database\Eloquent\Model;

class ReceiptStudent extends Model
{
    // تفعيل عزل البيانات بين المدارس (Multi-Tenancy) — يضيف فلتر school_id تلقائياً بصمت
    use BelongsToSchool;
    protected $guarded = [];

    public function student()
    {
        return $this->belongsTo(students::class, 'student_id');
    }

    /**
     * المستخدم الذي سجَّل هذه الدفعة فعلياً (مدير المدرسة أو الموظف المخوَّل)،
     * يُحفظ تلقائياً عند الإنشاء عبر RecordPayment Livewire Action.
     */
    public function recordedBy()
    {
        return $this->belongsTo(User::class, 'recorded_by');
    }
}
