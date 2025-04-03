<?php

namespace App\Http\Controllers\Students;

use App\Http\Controllers\Controller;
use App\Models\Grade;
use App\Models\Online_class;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Jubaer\Zoom\Facades\Zoom;

class OnlineClassController extends Controller
{
    public function index()
    {
        $online_classes = online_class::all();
        return view('pages.online_classes.index', compact('online_classes'));
    }


    public function create()
    {
        $Grades = Grade::all();
        return view('pages.online_classes.add', compact('Grades'));
    }


    public function indirectCreate()
    {
        $Grades = Grade::all();
        return view('pages.online_classes.indirect', compact('Grades'));
    }


    public function store(Request $request)
    {
        // try {
        $requestData = [
            "topic" => $request->topic,
            "type" => 2, // 2 = scheduled meeting
            "start_time" => $request->start_time, // يجب أن يكون بصيغة ISO 8601 مثل: "2025-04-01T10:00:00Z"
            "duration" => (int) $request->duration, // يجب أن يكون عددًا صحيحًا
            "timezone" => 'Asia/Gaza',
            "password" => "",
            "settings" => [
                'join_before_host' => false,
                'host_video' => true,
                'participant_video' => false,
                'mute_upon_entry' => true,
                'waiting_room' => true,
                'audio' => 'both',
                'auto_recording' => 'cloud',
                'approval_type' => 0,
            ],
        ];

        $meeting = Zoom::createMeeting($requestData);

        online_class::create([
            'integration' => true,
            'Grade_id' => $request->Grade_id,
            'Classroom_id' => $request->Classroom_id,
            'section_id' => $request->section_id,
            'user_id' => auth()->user()->id,
            'meeting_id' => $meeting['data']['id'],  // ✅ استخراج id الصحيح
            'topic' => $request->topic,
            'start_at' => $request->start_time,
            'duration' => $meeting['data']['duration'],
            'password' => $meeting['data']['password'],
            'start_url' => $meeting['data']['start_url'],
            'join_url' => $meeting['data']['join_url'],
        ]);




        toastr()->success(trans('messages.success'));
        return redirect()->route('online_classes.index');
        // } catch (\Exception $e) {
        //     return redirect()->back()->with(['error' => $e->getMessage()]);
        // }
    }

    public function storeIndirect(Request $request)
    {
        try {
            online_class::create([
                'integration' => false,
                'Grade_id' => $request->Grade_id,
                'Classroom_id' => $request->Classroom_id,
                'section_id' => $request->section_id,
                'user_id' => auth()->user()->id,
                'meeting_id' => $request->meeting_id,
                'topic' => $request->topic,
                'start_at' => $request->start_time,
                'duration' => $request->duration,
                'password' => $request->password,
                'start_url' => $request->start_url,
                'join_url' => $request->join_url,
            ]);
            toastr()->success(trans('messages.success'));
            return redirect()->route('online_classes.index');
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        //
    }


    public function destroy(Request $request)
    {
        try {
            $meetings = Zoom::deleteMeeting($request->id);
            Online_class::where('meeting_id', $request->id)->delete();
            toastr()->success(trans('messages.Delete'));
            return redirect()->route('online_classes.index');
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }
}
