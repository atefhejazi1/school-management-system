<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

/**
 * الدرع الخاص بعزل بيانات المدارس (Multi-Tenant Shield).
 *
 * يقوم هذا الـ Global Scope بتصفية أي استعلام Eloquent على النماذج التي تستخدم
 * Trait الخاص بـ BelongsToSchool، بحيث لا تظهر إلا السجلات التي تنتمي لنفس
 * مدرسة المستخدم الحالي (school_id). يعمل هذا الفلتر بصمت في الخلفية دون أي
 * تعديل على الـ Controllers أو الـ Views الحالية.
 */
class SchoolScope implements Scope
{
    public function apply(Builder $builder, Model $model): void
    {
        // لا يوجد مستخدم مسجّل دخوله حالياً (مثل أوامر الـ Artisan، الـ Queues، أو الـ Seeders)
        // في هذه الحالة لا نطبّق أي تصفية تلقائية لتجنّب كسر العمليات الداخلية للنظام.
        if (! auth()->check()) {
            return;
        }

        $authenticatedUser = auth()->user();

        // منشئ المنصة العام (Super Admin) لا ينتمي لأي مدرسة (school_id = NULL)،
        // ولذلك يجب أن يرى جميع السجلات في كل المدارس بدون أي تصفية.
        if (is_null($authenticatedUser->school_id)) {
            return;
        }

        // التصفية الفعلية: إظهار السجلات التابعة لمدرسة المستخدم الحالي فقط.
        $builder->where($model->getTable() . '.school_id', $authenticatedUser->school_id);
    }
}
