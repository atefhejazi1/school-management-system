<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Quizze extends Model
{
    use HasTranslations;
    public $translatable = ['name'];

    public function teacher()
    {
        return $this->belongsTo(teachers::class, 'teacher_id');
    }



    public function subject()
    {
        return $this->belongsTo(subject::class, 'subject_id');
    }


    public function grade()
    {
        return $this->belongsTo(Grade::class, 'grade_id');
    }


    public function classroom()
    {
        return $this->belongsTo(classroom::class, 'classroom_id');
    }


    public function section()
    {
        return $this->belongsTo(sections::class, 'section_id');
    }
}
