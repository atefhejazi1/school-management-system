<?php

namespace Database\Seeders;

use App\Models\Library;
use App\Models\School;
use App\Models\sections;
use App\Models\Teachers;
use Illuminate\Database\Seeder;

class LibrarySeeder extends Seeder
{
    /**
     * library ليس عليه school_id مباشرة؛ يُعزل عملياً عبر Grade_id (المرحلة نفسها معزولة بـ school_id).
     */
    public function run(School $school): void
    {
        $schoolSections = sections::where('school_id', $school->id)->get();
        $teacherIds = Teachers::where('school_id', $school->id)->pluck('id');

        Library::whereIn('Grade_id', $schoolSections->pluck('Grade_id'))->delete();

        if ($schoolSections->isEmpty() || $teacherIds->isEmpty()) {
            return;
        }

        $resources = ['ملخص الوحدة الأولى', 'كتاب التمارين', 'عرض تقديمي للمراجعة'];

        foreach ($resources as $title) {
            // نختار قسماً واحداً ونشتق منه المرحلة والصف الدراسي مباشرة، حتى لا يُرفَق
            // المورد بمرحلة لا تتبعها القسم/الصف المختارين فعلياً
            $section = $schoolSections->random();

            Library::create([
                'title' => $title,
                'file_name' => 'placeholder.pdf',
                'Grade_id' => $section->Grade_id,
                'Classroom_id' => $section->Class_id,
                'section_id' => $section->id,
                'teacher_id' => $teacherIds->random(),
            ]);
        }
    }
}
