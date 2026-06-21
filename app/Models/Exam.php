<?php

namespace App\Models;

use App\Traits\BelongsToSchool;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Exam extends Model
{
    use HasTranslations;
    // تفعيل عزل البيانات بين المدارس (Multi-Tenancy) — يضيف فلتر school_id تلقائياً بصمت
    use BelongsToSchool;
    protected $fillable = ['name', 'term', 'academic_year', 'school_id'];
    public $translatable = ['name'];

    public function quizzes()
    {
        return $this->hasMany(Quizze::class, 'exam_id');
    }
}
