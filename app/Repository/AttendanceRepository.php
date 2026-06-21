<?php


namespace App\Repository;


use App\Models\Attendance;
use App\Models\Grade;
use App\Models\Student;
use App\Models\students;
use App\Models\Teacher;
use App\Models\Teachers;
use App\Services\WhatsAppNotificationService;

class AttendanceRepository implements AttendanceRepositoryInterface
{
    public function __construct(private WhatsAppNotificationService $whatsApp)
    {
    }

    public function index()
    {
        $Grades = Grade::with(['Sections'])->get();
        $list_Grades = Grade::all();
        $teachers = Teachers::all();
        return view('pages.Attendance.Sections', compact('Grades', 'list_Grades', 'teachers'));
    }

    public function show($id)
    {
        $students = students::with('attendance')->where('section_id', $id)->get();
        return view('pages.Attendance.index', compact('students'));
    }

    public function store($request)
    {
        try {
            foreach ($request->attendences as $studentid => $attendence) {
                if ($attendence == 'presence') {
                    $attendence_status = true;
                } else if ($attendence == 'absent') {
                    $attendence_status = false;
                }

                Attendance::create([
                    'student_id' => $studentid,
                    'grade_id' => $request->grade_id,
                    'classroom_id' => $request->classroom_id,
                    'section_id' => $request->section_id,
                    'teacher_id' => 1,
                    'attendence_date' => date('Y-m-d'),
                    'attendence_status' => $attendence_status
                ]);

                // إشعار فوري لولي الأمر عبر واتساب عند تسجيل غياب الطالب فقط (لا شيء عند الحضور)
                if (! $attendence_status) {
                    $this->notifyParentOfAbsence($studentid);
                }
            }

            toastr()->success(trans('messages.success'));
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * يرسل رسالة واتساب تلقائية لولي أمر الطالب فور تسجيله غائباً، باستخدام هاتف
     * الأب إن وُجد، وإلا هاتف الأم كخيار احتياطي. لا يُوقِف أي استثناء هنا عملية حفظ
     * الحضور نفسها — فشل إرسال الإشعار لا يجوز أن يُسقِط العملية المحاسبية/الأكاديمية الأساسية.
     */
    private function notifyParentOfAbsence($studentId): void
    {
        try {
            $student = students::with('myparent')->find($studentId);
            $phone = $student?->myparent?->Phone_Father ?? $student?->myparent?->Phone_Mother;

            if (! $student || ! $phone) {
                return;
            }

            $message = trans('Attendance_trans.absence_whatsapp_message', ['name' => $student->name], 'ar');
            $this->whatsApp->sendDynamicMessage($phone, $message);
        } catch (\Exception $e) {
            report($e);
        }
    }

    public function update($request)
    {
        // TODO: Implement update() method.
    }

    public function destroy($request)
    {
        // TODO: Implement destroy() method.
    }
}
