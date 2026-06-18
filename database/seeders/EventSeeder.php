<?php

namespace Database\Seeders;

use App\Models\Event;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    /**
     * أحداث تقويم تجريبية (لا عمود school_id في هذا الجدول، فهي مشتركة بصرياً
     * بين كل من يفتح التقويم حالياً). نمرّر فقط title/start، تماماً كما يفعل
     * Livewire\Calendar::addevent() فعلياً، لتفادي محاولة تعيين عمود "end" غير الموجود في الجدول.
     */
    public function run(): void
    {
        Event::query()->delete();

        $events = [
            ['title' => 'بداية العام الدراسي', 'start' => now()->addDays(3)->toDateString()],
            ['title' => 'اجتماع أولياء الأمور', 'start' => now()->addDays(10)->toDateString()],
            ['title' => 'امتحانات منتصف الفصل', 'start' => now()->addDays(20)->toDateString()],
        ];

        foreach ($events as $event) {
            Event::create($event);
        }
    }
}
