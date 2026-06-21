<?php

namespace Database\Seeders;

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

        $schoolSections = sections::where('school_id', $school->id)->get();

        if ($schoolSections->isEmpty()) {
            return;
        }

        // نختار قسماً واحداً ونشتق منه المرحلة والصف الدراسي مباشرة، حتى تبقى الحصة
        // مرتبطة فعلياً بقسم ينتمي لذلك الصف وتلك المرحلة بالتحديد
        $section = $schoolSections->random();

        Online_class::create([
            'integration' => true,
            'Grade_id' => $section->Grade_id,
            'Classroom_id' => $section->Class_id,
            'section_id' => $section->id,
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
