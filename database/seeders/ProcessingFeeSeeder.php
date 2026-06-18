<?php

namespace Database\Seeders;

use App\Models\ProcessingFee;
use App\Models\School;
use App\Models\students;
use Illuminate\Database\Seeder;

class ProcessingFeeSeeder extends Seeder
{
    public function run(School $school): void
    {
        $studentIds = students::where('school_id', $school->id)->pluck('id');

        ProcessingFee::whereIn('student_id', $studentIds)->delete();

        foreach ($studentIds as $studentId) {
            ProcessingFee::create([
                'date' => now()->subDays(rand(1, 20))->toDateString(),
                'student_id' => $studentId,
                'amount' => 50,
                'description' => 'مصاريف إدارية',
            ]);
        }
    }
}
