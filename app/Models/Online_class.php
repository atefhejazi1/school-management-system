<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Online_class extends Model
{
    // protected $guarded=[];
    public $fillable = ['integration', 'Grade_id', 'Classroom_id', 'section_id', 'created_by', 'meeting_id', 'topic', 'start_at', 'duration', 'password', 'start_url', 'join_url'];

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

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
