<?php

namespace Database\Seeders;

use App\Models\Fee_invoice;
use App\Models\Fees;
use App\Models\School;
use App\Models\students;
use Illuminate\Database\Seeder;

class FeeInvoiceSeeder extends Seeder
{
    /**
     * fee_invoices ليس عليه school_id مباشرة؛ يُعزل عملياً عبر student_id
     * (الطالب نفسه معزول بـ school_id)، فنحذف فقط فواتير طلاب هذه المدرسة بالتحديد.
     */
    public function run(School $school): void
    {
        $studentIds = students::where('school_id', $school->id)->pluck('id');

        Fee_invoice::whereIn('student_id', $studentIds)->delete();

        $fees = Fees::whereIn('Grade_id', \App\Models\Grade::where('school_id', $school->id)->pluck('id'))->get();

        if ($fees->isEmpty()) {
            return;
        }

        foreach (students::where('school_id', $school->id)->get() as $student) {
            $fee = $fees->random();

            Fee_invoice::create([
                'invoice_date' => now()->subDays(rand(1, 30))->toDateString(),
                'student_id' => $student->id,
                'Grade_id' => $student->Grade_id,
                'Classroom_id' => $student->Classroom_id,
                'fee_id' => $fee->id,
                'amount' => $fee->amount,
                'description' => $fee->title . ' - ' . $student->name,
            ]);
        }
    }
}
