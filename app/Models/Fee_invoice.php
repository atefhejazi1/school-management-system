<?php

namespace App\Models;

use App\Traits\BelongsToSchool;
use App\Traits\LogsSystemActivity;
use Illuminate\Database\Eloquent\Model;

class Fee_invoice extends Model
{
    // تفعيل عزل البيانات بين المدارس (Multi-Tenancy) — يضيف فلتر school_id تلقائياً بصمت
    use BelongsToSchool;
    // تسجيل كل تعديل على فواتير الرسوم تلقائياً في سجل التدقيق (audit_logs)
    use LogsSystemActivity;
    protected $guarded = [];

    public function grade()
    {
        return $this->belongsTo(Grade::class, 'Grade_id');
    }


    public function classroom()
    {
        return $this->belongsTo(Classroom::class, 'Classroom_id');
    }


    public function student()
    {
        return $this->belongsTo(students::class, 'student_id');
    }

    public function fees()
    {
        return $this->belongsTo(Fees::class, 'fee_id');
    }

    /**
     * كل قيود دفتر الأستاذ (student_accounts) المرتبطة بهذه الفاتورة تحديداً عبر fee_invoice_id.
     * هذا العمود كان موجوداً بالفعل في الجدول لكنه لم يكن يُستخدم سابقاً إلا لقيد "الفاتورة"
     * نفسه (Debit)؛ في وحدة المحاسبة هذه أصبحنا نربط به أيضاً قيود "السداد" (credit) عند تسجيل
     * دفعة عبر RecordPayment، وهذا ما يسمح باحتساب المتبقي لكل فاتورة على حِدة بدلاً من
     * الاعتماد على رصيد الطالب الإجمالي فقط.
     */
    public function ledgerEntries()
    {
        return $this->hasMany(StudentAccount::class, 'fee_invoice_id');
    }

    /**
     * إجمالي ما تم سداده فعلياً على هذه الفاتورة = مجموع قيود "الدائن" (credit) المرتبطة بها.
     * لا يوجد عمود paid_amount مخزَّن في الجدول عمداً (الالتزام بفلسفة دفتر الأستاذ القائمة
     * أصلاً في النظام)؛ هذا Accessor يُحتسب لحظياً من student_accounts عند كل استدعاء.
     */
    public function getPaidAmountAttribute(): float
    {
        return (float) $this->ledgerEntries()->sum('credit');
    }

    /**
     * المتبقي على الفاتورة = قيمتها الإجمالية ناقص ما تم سداده حتى الآن.
     * نستخدم max(0, ...) لتفادي ظهور رصيد سالب في واجهة المستخدم في حال تجاوز
     * السداد القيمة الأصلية لأي سبب استثنائي (تسوية يدوية مثلاً).
     */
    public function getBalanceAmountAttribute(): float
    {
        return max(0, round((float) $this->amount - $this->paid_amount, 2));
    }

    /**
     * حالة الفاتورة: مدفوعة بالكامل / مدفوعة جزئياً / غير مدفوعة — محتسبة من المتبقي
     * والمدفوع لحظياً، وليست عموداً مخزَّناً، لذا لا يمكن أن "تنحرف" عن الحقيقة المحاسبية.
     */
    public function getStatusAttribute(): string
    {
        if ($this->balance_amount <= 0.0) {
            return 'paid';
        }

        if ($this->paid_amount > 0.0) {
            return 'partially_paid';
        }

        return 'unpaid';
    }
}
