<?php

namespace App\Models;

use App\Traits\BelongsToSchool;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Quizze extends Model
{
    use HasTranslations;
    // تفعيل عزل البيانات بين المدارس (Multi-Tenancy) — يضيف فلتر school_id تلقائياً بصمت
    use BelongsToSchool;
    public $translatable = ['name'];
    protected $guarded = [];

    public function teacher()
    {
        return $this->belongsTo(Teachers::class, 'teacher_id');
    }



    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }


    public function grade()
    {
        return $this->belongsTo(Grade::class, 'grade_id');
    }


    public function classroom()
    {
        return $this->belongsTo(Classroom::class, 'classroom_id');
    }


    public function section()
    {
        return $this->belongsTo(sections::class, 'section_id');
    }

    public function exam()
    {
        return $this->belongsTo(Exam::class, 'exam_id');
    }

    public function degree()
    {
        return $this->hasMany(Degree::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class, 'quizze_id');
    }
}
