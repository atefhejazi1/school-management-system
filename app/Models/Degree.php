<?php

namespace App\Models;

use App\Traits\BelongsToSchool;
use App\Traits\LogsSystemActivity;
use Illuminate\Database\Eloquent\Model;

class Degree extends Model
{
    // تفعيل عزل البيانات بين المدارس (Multi-Tenancy) — يضيف فلتر school_id تلقائياً بصمت
    use BelongsToSchool;
    // تسجيل كل تعديل على علامات الطلاب تلقائياً في سجل التدقيق (audit_logs)
    use LogsSystemActivity;
    protected $guarded = [];
    public $timestamps = true;

    public function student()
    {
        return $this->belongsTo(students::class, 'student_id');
    }

    public function quizze()
    {
        return $this->belongsTo(Quizze::class, 'quizze_id');
    }
}
