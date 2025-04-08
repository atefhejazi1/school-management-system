<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Teachers extends Authenticatable
{
    use HasTranslations;
    public $translatable = ['Name'];
    protected $guarded = [];



    public static function zoomClientID()
    {
        return '4iSGLbyoRfK7tp8dvj5_Nw';
    }

    public static function zoomClientSecret()
    {
        return 'Rw4DDT0hDLQOOLTsXazkAyVZ9ZKMbHd5';
    }

    public static function accountID()
    {
        return '8Ib71QRNQRmFUoXn8bj67w';
    }

    // علاقة بين المعلمين والتخصصات لجلب اسم التخصص
    public function specializations()
    {
        return $this->belongsTo(specializations::class, 'Specialization_id');
    }

    // علاقة بين المعلمين والانواع لجلب جنس المعلم
    public function genders()
    {
        return $this->belongsTo(Gender::class, 'Gender_id');
    }

    // علاقة المعلمين مع الاقسام
    public function Sections()
    {
        return $this->belongsToMany(Sections::class, 'teacher_section', 'teacher_id', 'section_id');
    }
}
