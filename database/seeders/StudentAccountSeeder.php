<?php

namespace Database\Seeders;

use App\Models\Fee_invoice;
use App\Models\PaymentStudent;
use App\Models\ProcessingFee;
use App\Models\ReceiptStudent;
use App\Models\School;
use App\Models\StudentAccount;
use App\Models\students;
use Illuminate\Database\Seeder;

class StudentAccountSeeder extends Seeder
{
    /**
     * يجمع student_accounts حركات الحساب المالي للطالب (مديونية من الفواتير والمصاريف،
     * ودائنية من السندات والدفعات)، استناداً إلى السجلات التي أنشأتها السيدرز السابقة
     * (FeeInvoiceSeeder, ReceiptStudentSeeder, ProcessingFeeSeeder, PaymentStudentSeeder).
     */
    public function run(School $school): void
    {
        $studentIds = students::where('school_id', $school->id)->pluck('id');

        StudentAccount::whereIn('student_id', $studentIds)->delete();

        foreach ($studentIds as $studentId) {
            if ($invoice = Fee_invoice::where('student_id', $studentId)->first()) {
                StudentAccount::create([
                    'date' => $invoice->invoice_date,
                    'type' => 'fee_invoice',
                    'fee_invoice_id' => $invoice->id,
                    'student_id' => $studentId,
                    'Debit' => $invoice->amount,
                    'description' => 'فاتورة رسوم: ' . $invoice->description,
                ]);
            }

            if ($receipt = ReceiptStudent::where('student_id', $studentId)->first()) {
                StudentAccount::create([
                    'date' => $receipt->date,
                    'type' => 'receipt',
                    'receipt_id' => $receipt->id,
                    'student_id' => $studentId,
                    'credit' => $receipt->Debit,
                    'description' => $receipt->description,
                ]);
            }

            if ($processing = ProcessingFee::where('student_id', $studentId)->first()) {
                StudentAccount::create([
                    'date' => $processing->date,
                    'type' => 'processing_fee',
                    'processing_id' => $processing->id,
                    'student_id' => $studentId,
                    'Debit' => $processing->amount,
                    'description' => $processing->description,
                ]);
            }

            if ($payment = PaymentStudent::where('student_id', $studentId)->first()) {
                StudentAccount::create([
                    'date' => $payment->date,
                    'type' => 'payment',
                    'payment_id' => $payment->id,
                    'student_id' => $studentId,
                    'credit' => $payment->amount,
                    'description' => $payment->description,
                ]);
            }
        }
    }
}
