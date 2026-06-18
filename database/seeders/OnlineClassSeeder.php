<?php

namespace Database\Seeders;

use App\Models\Classroom;
use App\Models\Grade;
use App\Models\Online_class;
use App\Models\School;
use App\Models\sections;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OnlineClassSeeder extends Seeder
{
    public function run(School $school): void
    {
        DB::table('online_classes')->where('school_id', $school->id)->delete();

        $gradeIds = Grade::where('school_id', $school->id)->pluck('id');
        $classroomIds = Classroom::where('school_id', $school->id)->pluck('id');
        $sectionIds = sections::where('school_id', $school->id)->pluck('id');

        Online_class::create([
            'integration' => true,
            'Grade_id' => $gradeIds->random(),
            'Classroom_id' => $classroomIds->random(),
            'section_id' => $sectionIds->random(),
            'created_by' => 'admin',
            'meeting_id' => '000-000-' . random_int(1000, 9999),
            'topic' => 'حصة مراجعة عبر الإنترنت',
            'start_at' => now()->addDay()->setTime(10, 0),
            'duration' => 60,
            'password' => (string) random_int(100000, 999999),
            'start_url' => 'https://zoom.us/s/placeholder',
            'join_url' => 'https://zoom.us/j/placeholder',
            'school_id' => $school->id, // حقن مباشر لأن السيدنج لا يعمل تحت جلسة auth حقيقية
        ]);
    }
}
