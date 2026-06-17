<?php

namespace App\Traits;

use App\Models\Scopes\SchoolScope;

/**
 * Trait يُضاف إلى أي نموذج (Model) يحتاج إلى عزل بياناته على مستوى المدرسة (Tenant).
 *
 * المهمتان الأساسيتان لهذا الـ Trait:
 * 1) تسجيل SchoolScope تلقائياً، بحيث تتم تصفية كل عمليات القراءة (SELECT) بصمت.
 * 2) حقن school_id تلقائياً في أي سجل جديد عند الإنشاء (Model Event: creating)،
 *    بحيث لا نحتاج لتعديل أي نموذج إنشاء (Create Form) أو Controller موجود حالياً.
 */
trait BelongsToSchool
{
    /**
     * يُستدعى تلقائياً من Laravel عند تشغيل boot() الخاص بالنموذج،
     * تبعاً لتسمية الـ Trait: boot + اسم الـ Trait (BelongsToSchool).
     */
    public static function bootBelongsToSchool(): void
    {
        // 1) تسجيل درع العزل (Global Scope) لتصفية كل الاستعلامات تلقائياً.
        static::addGlobalScope(new SchoolScope());

        // 2) حقن school_id تلقائياً قبل إنشاء أي سجل جديد، فقط إذا لم تُحدَّد قيمته مسبقاً
        // (مثلاً أثناء عمليات seeding المتحكَّم فيها يدوياً للمدرسة B).
        static::creating(function ($model) {
            if (is_null($model->school_id) && auth()->check()) {
                $model->school_id = auth()->user()->school_id;
            }
        });
    }
}
