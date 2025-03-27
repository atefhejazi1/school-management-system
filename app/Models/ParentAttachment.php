<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ParentAttachment extends Model
{
    protected $fillable = ['file_name', 'parent_id'];

    public function parent()
    {
        return $this->belongsTo(My_Parent::class, 'parent_id');
    }
}
