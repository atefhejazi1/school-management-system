<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Library extends Model
{
    protected $table = "library";

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

    public function teacher()
    {
        return $this->belongsTo(Teachers::class, 'teacher_id');
    }
}
