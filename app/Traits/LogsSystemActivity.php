<?php

namespace App\Traits;

use App\Models\AuditLog;
use Illuminate\Database\Eloquent\Model;

/**
 * Trait يُضاف إلى أي نموذج (Model) نريد تتبّع كل تعديلاته تلقائياً وبصمت في audit_logs،
 * دون الحاجة لكتابة أي استدعاء يدوي داخل الـ Controller أو الـ Repository عند كل عملية
 * إنشاء/تعديل/حذف.
 */
trait LogsSystemActivity
{
    public static function bootLogsSystemActivity(): void
    {
        static::created(function (Model $model) {
            self::recordSystemActivity($model, 'created', [
                'old' => null,
                'new' => $model->getAttributes(),
            ]);
        });

        static::updated(function (Model $model) {
            // نقرأ getChanges()/getOriginal() هنا قبل أن يستدعي save() الأصلي دالة
            // syncOriginal()، وهذا هو التوقيت الوحيد الذي تكون فيه القيمتان القديمة
            // والجديدة متاحتين معاً لنفس الحقل المتغيّر.
            $changes = $model->getChanges();
            unset($changes['updated_at']);

            if (empty($changes)) {
                return;
            }

            $old = [];
            foreach ($changes as $key => $newValue) {
                $old[$key] = $model->getOriginal($key);
            }

            self::recordSystemActivity($model, 'updated', ['old' => $old, 'new' => $changes]);
        });

        static::deleted(function (Model $model) {
            self::recordSystemActivity($model, 'deleted', [
                'old' => $model->getOriginal(),
                'new' => null,
            ]);
        });
    }

    private static function recordSystemActivity(Model $model, string $action, array $payload): void
    {
        AuditLog::create([
            'school_id' => $model->school_id ?? (auth()->check() ? auth()->user()->school_id : null),
            'user_id' => auth()->check() ? auth()->id() : null,
            'action' => $action,
            'model_type' => get_class($model),
            'model_id' => $model->getKey(),
            'payload' => $payload,
            'ip_address' => app()->runningInConsole() ? null : request()->ip(),
        ]);
    }
}
