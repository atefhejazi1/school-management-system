<?php

namespace App\Models;

use App\Traits\BelongsToSchool;
use Illuminate\Database\Eloquent\Model;

class Online_class extends Model
{
    // تفعيل عزل البيانات بين المدارس (Multi-Tenancy) — يضيف فلتر school_id تلقائياً بصمت
    use BelongsToSchool;
    // protected $guarded=[];
    public $fillable = ['integration', 'Grade_id', 'Classroom_id', 'section_id', 'created_by', 'meeting_id', 'topic', 'start_at', 'duration', 'password', 'start_url', 'join_url', 'school_id'];

    public function grade()
    {
        return $this->belongsTo(Grade::class, 'Grade_id');
    }


    public function classroom()
    {
        return $this->belongsTo(Classroom::class, 'Classroom_id');
    }


    public function section()
    {
        return $this->belongsTo(sections::class, 'section_id');
    }
}
