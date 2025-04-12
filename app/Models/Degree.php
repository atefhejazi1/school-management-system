<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Degree extends Model
{
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
