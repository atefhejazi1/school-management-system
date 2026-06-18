<?php

namespace Database\Seeders;

use App\Models\Classroom;
use App\Models\Grade;
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
        $gradeIds = Grade::where('school_id', $school->id)->pluck('id');
        $classroomIds = Classroom::where('school_id', $school->id)->pluck('id');
        $sectionIds = sections::where('school_id', $school->id)->pluck('id');
        $teacherIds = Teachers::where('school_id', $school->id)->pluck('id');

        Library::whereIn('Grade_id', $gradeIds)->delete();

        $resources = ['ملخص الوحدة الأولى', 'كتاب التمارين', 'عرض تقديمي للمراجعة'];

        foreach ($resources as $title) {
            Library::create([
                'title' => $title,
                'file_name' => 'placeholder.pdf',
                'Grade_id' => $gradeIds->random(),
                'Classroom_id' => $classroomIds->random(),
                'section_id' => $sectionIds->random(),
                'teacher_id' => $teacherIds->random(),
            ]);
        }
    }
}
