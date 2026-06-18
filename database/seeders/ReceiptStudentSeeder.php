<?php

namespace Database\Seeders;

use App\Models\ReceiptStudent;
use App\Models\School;
use App\Models\students;
use Illuminate\Database\Seeder;

class ReceiptStudentSeeder extends Seeder
{
    public function run(School $school): void
    {
        $studentIds = students::where('school_id', $school->id)->pluck('id');

        ReceiptStudent::whereIn('student_id', $studentIds)->delete();

        foreach ($studentIds as $studentId) {
            ReceiptStudent::create([
                'date' => now()->subDays(rand(1, 20))->toDateString(),
                'student_id' => $studentId,
                'Debit' => 1000,
                'description' => 'سند قبض دفعة من الرسوم الدراسية',
            ]);
        }
    }
}
