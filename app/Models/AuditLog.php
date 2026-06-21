<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuditLog extends Model
{
    protected $guarded = [];
    protected $casts = [
        'payload' => 'array',
    ];

    /**
     * أسماء عربية مفهومة للنماذج المُدقَّقة، تُستخدم بدلاً من عرض اسم الكلاس الخام
     * (App\Models\Degree) في سجل المراقبة الموجَّه للمستخدم النهائي.
     */
    private const MODEL_LABELS = [
        'App\\Models\\Degree' => 'علامة طالب',
        'App\\Models\\Fee_invoice' => 'فاتورة رسوم',
        'App\\Models\\StudentAccount' => 'قيد محاسبي',
        'App\\Models\\ReceiptStudent' => 'سند قبض',
    ];

    /**
     * أسماء عربية للحقول الشائعة التي تتغيّر غالباً، لتظهر بصيغة مقروءة بدل اسم العمود
     * الخام في قاعدة البيانات (مثل score بدل عرضها كما هي في الجملة الوصفية).
     */
    private const FIELD_LABELS = [
        'score' => 'العلامة',
        'amount' => 'المبلغ',
        'paid_amount' => 'المدفوع',
        'balance_amount' => 'المتبقي',
        'status' => 'الحالة',
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }

    public function getModelLabelAttribute(): string
    {
        return self::MODEL_LABELS[$this->model_type] ?? class_basename($this->model_type);
    }

    /**
     * يبني جملة عربية واحدة تصف العملية، على غرار: "قام المستخدم أحمد بتعديل علامة
     * الطالب رقم 12: العلامة من 80 إلى 95". نأخذ أول حقل متغيّر فقط لإبقاء الجملة
     * مختصرة وواضحة في جدول السجلّ، أما كل التفاصيل الكاملة فتبقى محفوظة في payload.
     */
    public function getSummaryAttribute(): string
    {
        $userName = $this->user->name ?? 'النظام';
        $label = $this->model_label;

        if ($this->action === 'created') {
            return "قام المستخدم {$userName} بإضافة سجل جديد في {$label} رقم {$this->model_id}";
        }

        if ($this->action === 'deleted') {
            return "قام المستخدم {$userName} بحذف {$label} رقم {$this->model_id}";
        }

        $old = $this->payload['old'] ?? [];
        $new = $this->payload['new'] ?? [];
        $firstField = array_key_first($new);

        if ($firstField === null) {
            return "قام المستخدم {$userName} بتعديل {$label} رقم {$this->model_id}";
        }

        $fieldLabel = self::FIELD_LABELS[$firstField] ?? $firstField;
        $oldValue = $old[$firstField] ?? '—';
        $newValue = $new[$firstField] ?? '—';

        return "قام المستخدم {$userName} بتعديل {$label} رقم {$this->model_id}: {$fieldLabel} من {$oldValue} إلى {$newValue}";
    }
}
