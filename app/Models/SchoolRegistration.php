<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class SchoolRegistration extends Model
{
    protected $fillable = [
        'school_name',
        'contact_name',
        'email',
        'phone',
        'city',
        'student_count',
        'message',
        'status',
        'admin_notes',
    ];

    public function scopePending(Builder $query): Builder
    {
        return $query->where('status', 'pending');
    }

    public function scopeApproved(Builder $query): Builder
    {
        return $query->where('status', 'approved');
    }

    public function scopeRejected(Builder $query): Builder
    {
        return $query->where('status', 'rejected');
    }

    public function studentCountLabel(): string
    {
        return match ($this->student_count) {
            'less_100'  => 'أقل من 100 طالب',
            '100_300'   => 'من 100 إلى 300 طالب',
            'more_300'  => 'أكثر من 300 طالب',
            default     => $this->student_count,
        };
    }

    public function statusLabel(): string
    {
        return match ($this->status) {
            'pending'  => 'قيد المراجعة',
            'approved' => 'مقبول',
            'rejected' => 'مرفوض',
            default    => $this->status,
        };
    }

    public function statusColor(): string
    {
        return match ($this->status) {
            'pending'  => 'warning',
            'approved' => 'success',
            'rejected' => 'danger',
            default    => 'secondary',
        };
    }
}
