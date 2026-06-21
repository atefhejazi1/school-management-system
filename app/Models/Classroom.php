<?php

namespace App\Models;

use App\Traits\BelongsToSchool;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Classroom extends Model
{

    use HasTranslations;
    // تفعيل عزل البيانات بين المدارس (Multi-Tenancy) — يضيف فلتر school_id تلقائياً بصمت
    use BelongsToSchool;
    public $translatable = ['Name_Class'];


    protected $table = 'Classrooms';
    public $timestamps = true;
    protected $fillable = ['Name_Class', 'Grade_id', 'school_id'];


    // علاقة بين الصفوف المراحل الدراسية لجلب اسم المرحلة في جدول الصفوف

    public function Grades()
    {
        return $this->belongsTo(Grade::class, 'Grade_id');
    }

    // علاقة بين الصفوف والطلاب لحساب عدد طلاب كل صف في لوحة التحكم
    public function students()
    {
        return $this->hasMany(students::class, 'Classroom_id');
    }
}
