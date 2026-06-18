<?php

namespace App\Models;

use App\Traits\BelongsToSchool;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Grade extends Model
{
    use HasTranslations;
    // تفعيل عزل البيانات بين المدارس (Multi-Tenancy) — يضيف فلتر school_id تلقائياً بصمت
    use BelongsToSchool;

    public $translatable = ['Name']; // translatable attributes
    protected $fillable = ['Name', 'Notes'];
    protected $table = 'Grades';
    public $timestamps = true;


    public function Sections()
    {
        return $this->hasMany(Sections::class, 'Grade_id');
    }
}
