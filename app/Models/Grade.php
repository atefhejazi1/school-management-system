<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Grade extends Model
{
    use HasTranslations;

    public $translatable = ['Name']; // translatable attributes
    protected $fillable = ['Name', 'Notes'];
    protected $table = 'Grades';
    public $timestamps = true;


    public function Sections()
    {
        return $this->hasMany(Sections::class, 'Grade_id');
    }
}
