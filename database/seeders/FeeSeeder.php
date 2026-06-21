<?php

namespace Database\Seeders;

use App\Models\Classroom;
use App\Models\Fees;
use App\Models\School;
use Illuminate\Database\Seeder;

class FeeSeeder extends Seeder
{
    /**
     * جدول fees ليس عليه school_id مباشرة، فهو معزول عملياً عبر Grade_id/Classroom_id
     * (المرحلة والصف نفسهما معزولان بـ school_id)؛ لذلك نحذف فقط الرسوم المرتبطة
     * بصفوف هذه المدرسة بالتحديد، لا كل جدول fees.
     */
    public function run(School $school): void
    {
        $classrooms = Classroom::where('school_id', $school->id)->get();

        Fees::whereIn('Grade_id', $classrooms->pluck('Grade_id'))->delete();

        if ($classrooms->isEmpty()) {
            return;
        }

        $feeTypes = [
            ['title' => 'رسوم دراسية', 'amount' => 5000, 'Fee_type' => 1],
            ['title' => 'رسوم أنشطة', 'amount' => 500, 'Fee_type' => 2],
            ['title' => 'رسوم كتب', 'amount' => 300, 'Fee_type' => 3],
        ];

        foreach ($feeTypes as $fee) {
            // نختار صفاً دراسياً واحداً ونشتق منه المرحلة الدراسية مباشرة، حتى لا تنتمي
            // هذه الرسوم لمرحلة لا تتبعها هذا الصف فعلياً
            $classroom = $classrooms->random();

            Fees::create([
                'title' => $fee['title'],
                'amount' => $fee['amount'],
                'Grade_id' => $classroom->Grade_id,
                'Classroom_id' => $classroom->id,
                'description' => $fee['title'] . ' للعام الدراسي الحالي',
                'year' => (string) now()->year,
                'Fee_type' => $fee['Fee_type'],
            ]);
        }
    }
}
