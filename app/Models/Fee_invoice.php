<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fee_invoice extends Model
{
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
        return $this->belongsTo(Sections::class, 'section_id');
    }

    public function student()
    {
        return $this->belongsTo(students::class, 'student_id');
    }

    public function fees()
    {
        return $this->belongsTo(fees::class, 'fee_id');
    }
}
