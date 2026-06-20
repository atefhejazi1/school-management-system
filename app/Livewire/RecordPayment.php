<?php

namespace App\Livewire;

use App\Models\Fee_invoice;
use App\Models\FundAccount;
use App\Models\ReceiptStudent;
use App\Models\StudentAccount;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;

/**
 * نافذة منبثقة (Modal) لتسجيل دفعة جديدة على فاتورة رسوم محدَّدة، ضمن دفتر الأستاذ
 * المحاسبي القائم أصلاً في النظام (وليس جدول payments منفصل — راجع قرار التصميم في
 * resources/views/pages/Fees_Invoices/outstanding.blade.php).
 *
 * ملاحظة تصميم Livewire 3: مبلغ الدفعة (amount) ووسيلة الدفع (method) يُقرآن من
 * خاصيتي المكوّن العامتين (المرتبطتين بحقول النموذج عبر wire:model) لا كمعاملات
 * تُمرَّر مباشرة داخل استدعاء recordPayment() من الـ Blade. هذا هو الأسلوب السليم
 * في Livewire 3 لأن القيم تأتي من نموذج تفاعلي يتحقق منه المستخدم قبل الإرسال،
 * وليس قيماً ثابتة تُمرَّر كنص داخل HTML. مُعرّف الفاتورة (invoiceId) وحده يُمرَّر
 * كمعامل فعلي عند فتح النافذة لأنه يأتي من زر "تسجيل دفعة" في كل صف من الجدول.
 */
class RecordPayment extends Component
{
    public bool $showModal = false;
    public ?int $invoiceId = null;
    public ?string $invoiceStudentName = null;
    public float $invoiceTotalAmount = 0;
    public float $invoiceBalanceAmount = 0;
    public float $amount = 0;
    public string $method = 'كاش';

    /**
     * فتح النافذة من جدول الفواتير غير المسدَّدة، عبر الحدث المُرسَل من زر كل صف.
     * نُعيد جلب الفاتورة هنا بدلاً من الاعتماد على بيانات الجدول كما هي في الصفحة،
     * لضمان أن المتبقي المعروض في النافذة محتسَب من أحدث بيانات قاعدة البيانات.
     */
    #[On('open-record-payment-modal')]
    public function openModal(int $invoiceId): void
    {
        $this->resetErrorBag();

        $invoice = Fee_invoice::with('student')->findOrFail($invoiceId);

        $this->invoiceId = $invoice->id;
        $this->invoiceStudentName = $invoice->student->name ?? '';
        $this->invoiceTotalAmount = (float) $invoice->amount;
        $this->invoiceBalanceAmount = $invoice->balance_amount;
        $this->amount = $this->invoiceBalanceAmount;
        $this->method = 'كاش';
        $this->showModal = true;
    }

    public function closeModal(): void
    {
        $this->reset(['showModal', 'invoiceId', 'invoiceStudentName', 'invoiceTotalAmount', 'invoiceBalanceAmount', 'amount']);
        $this->method = 'كاش';
    }

    /**
     * تسجيل الدفعة فعلياً: نُنشئ ثلاثة قيود متَّسقة مع نمط دفتر الأستاذ المستخدَم في
     * بقية النظام (راجع ReceiptStudentsRepository::store() الأصلية):
     *   1) receipt_students  — سند القبض نفسه (يحمل الآن أيضاً وسيلة الدفع ومُسجِّلها).
     *   2) fund_accounts     — يزيد رصيد صندوق المدرسة النقدي.
     *   3) student_accounts  — قيد "دائن" (credit) يُخفّض ما على الطالب، ومربوط هذه
     *      المرة بعمود fee_invoice_id الموجود مسبقاً في الجدول، وهو ما يسمح لاحقاً
     *      بحساب accessor الفاتورة (paid_amount/balance_amount/status) بدقة لكل
     *      فاتورة على حِدة، بدل الاعتماد فقط على رصيد الطالب الإجمالي.
     */
    public function recordPayment(): void
    {
        $this->validate([
            'amount' => ['required', 'numeric', 'min:0.01'],
            'method' => ['required', 'string', 'max:50'],
        ]);

        // نُعيد التحقق من المتبقي الحقيقي لحظة الحفظ (لا من القيمة المعروضة سابقاً في
        // النافذة)، تفادياً لتجاوز السداد للمتبقي الفعلي لو تغيّر بين فتح النافذة والحفظ
        // (مثلاً: مستخدم آخر سجَّل دفعة على نفس الفاتورة في هذه الأثناء)
        $invoice = Fee_invoice::findOrFail($this->invoiceId);

        if ($this->amount > $invoice->balance_amount + 0.01) {
            $this->addError('amount', trans('Fees_trans.amount_exceeds_balance'));
            return;
        }

        DB::transaction(function () use ($invoice) {
            $description = trans('Fees_trans.payment_against_invoice', ['id' => $invoice->id]);

            $receipt = new ReceiptStudent();
            $receipt->date = now()->toDateString();
            $receipt->student_id = $invoice->student_id;
            $receipt->Debit = $this->amount;
            $receipt->payment_method = $this->method;
            $receipt->recorded_by = Auth::id();
            $receipt->description = $description;
            $receipt->save();

            $fundAccount = new FundAccount();
            $fundAccount->date = now()->toDateString();
            $fundAccount->receipt_id = $receipt->id;
            $fundAccount->Debit = $this->amount;
            $fundAccount->credit = 0.00;
            $fundAccount->description = $description;
            $fundAccount->save();

            $studentAccount = new StudentAccount();
            $studentAccount->date = now()->toDateString();
            $studentAccount->type = 'receipt';
            $studentAccount->fee_invoice_id = $invoice->id;
            $studentAccount->receipt_id = $receipt->id;
            $studentAccount->student_id = $invoice->student_id;
            $studentAccount->Debit = 0.00;
            $studentAccount->credit = $this->amount;
            $studentAccount->description = $description;
            $studentAccount->save();
        });

        $this->dispatch('payment-recorded');
        toastr()->success(trans('Fees_trans.payment_recorded_success'));
        $this->closeModal();
    }

    public function render()
    {
        return view('livewire.record-payment');
    }
}
