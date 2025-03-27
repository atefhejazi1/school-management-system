<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class My_Parent extends Model
{
    use HasTranslations;
    public $translatable = ['Name_Father', 'Job_Father', 'Name_Mother', 'Job_Mother'];
    protected $table = 'my__parents';
    // using guarded instead of fillable
    protected $guarded = [];


    // علاقة One To Many مع ParentAttachment
    public function attachments()
    {
        return $this->hasMany(ParentAttachment::class, 'parent_id');
    }


    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }
}
