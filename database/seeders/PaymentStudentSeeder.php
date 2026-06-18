<?php

namespace Database\Seeders;

use App\Models\PaymentStudent;
use App\Models\School;
use App\Models\students;
use Illuminate\Database\Seeder;

class PaymentStudentSeeder extends Seeder
{
    public function run(School $school): void
    {
        $studentIds = students::where('school_id', $school->id)->pluck('id');

        PaymentStudent::whereIn('student_id', $studentIds)->delete();

        foreach ($studentIds as $studentId) {
            PaymentStudent::create([
                'date' => now()->subDays(rand(1, 20))->toDateString(),
                'student_id' => $studentId,
                'amount' => 200,
                'description' => 'دفعة نقدية من ولي الأمر',
            ]);
        }
    }
}
