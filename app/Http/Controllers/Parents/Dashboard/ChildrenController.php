<?php

namespace App\Http\Controllers\Parents\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Degree;
use App\Models\Fee_invoice;
use App\Models\My_Parent;
use App\Models\ReceiptStudent;
use App\Models\students;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ChildrenController extends Controller
{
    public function index()
    {

        $students = students::where('parent_id', Auth::user()->id)->get();
        return view('pages.parents.children.index', compact('students'));
    }

    public function results($id)
    {

        $student = students::findorFail($id);

        if ($student->parent_id !== Auth::user()->id) {
            toastr()->error('يوجد خطا في كود الطالب');
            return redirect()->route('sons.index');
        }
        $degrees = Degree::where('student_id', $id)->get();

        if ($degrees->isEmpty()) {
            toastr()->error('لا توجد نتائج لهذا الطالب');
            return redirect()->route('sons.index');
        }

        return view('pages.parents.degrees.index', compact('degrees'));
    }


    public function attendances()
    {
        $students = students::where('parent_id', Auth::user()->id)->get();
        return view('pages.parents.Attendance.index', compact('students'));
    }

    public function attendanceSearch(Request $request)
    {
        $request->validate([
            'from' => 'required|date|date_format:Y-m-d',
            'to' => 'required|date|date_format:Y-m-d|after_or_equal:from'
        ], [
            'to.after_or_equal' => 'تاريخ النهاية لابد ان اكبر من تاريخ البداية او يساويه',
            'from.date_format' => 'صيغة التاريخ يجب ان تكون yyyy-mm-dd',
            'to.date_format' => 'صيغة التاريخ يجب ان تكون yyyy-mm-dd',
        ]);

        // نطاق الأبناء الفعلي لولي الأمر الحالي فقط — لمنع أي ولي أمر من قراءة سجلات حضور
        // طالب لا ينتمي إليه عبر تمرير student_id تعسفياً (كانت هذه الدالة تستخدم خطأً
        // معرّف ولي الأمر كمعرّف معلم في جدول teacher_section، وهو غير ذي صلة بالمرة)
        $myChildrenIds = students::where('parent_id', Auth::user()->id)->pluck('id');
        $students = students::where('parent_id', Auth::user()->id)->get();

        if ($request->student_id == 0) {

            $Students = Attendance::whereBetween('attendence_date', [$request->from, $request->to])
                ->whereIn('student_id', $myChildrenIds)->get();
            return view('pages.parents.Attendance.index', compact('Students', 'students'));
        } else {

            abort_unless($myChildrenIds->contains((int) $request->student_id), 403);

            $Students = Attendance::whereBetween('attendence_date', [$request->from, $request->to])
                ->where('student_id', $request->student_id)->get();
            return view('pages.parents.Attendance.index', compact('Students', 'students'));
        }
    }

    public function fees()
    {
        $students_ids = students::where('parent_id', Auth::user()->id)->pluck('id');
        $Fee_invoices = Fee_invoice::whereIn('student_id', $students_ids)->get();
        return view('pages.parents.fees.index', compact('Fee_invoices'));
    }

    public function receiptStudent($id)
    {

        $student = students::findorFail($id);
        if ($student->parent_id !== Auth::user()->id) {
            toastr()->error('يوجد خطا في كود الطالب');
            return redirect()->route('sons.fees');
        }

        $receipt_students = ReceiptStudent::where('student_id', $id)->get();

        if ($receipt_students->isEmpty()) {
            toastr()->error('لا توجد مدفوعات لهذا الطالب');
            return redirect()->route('sons.fees');
        }
        return view('pages.parents.Receipt.index', compact('receipt_students'));
    }


    public function profile()
    {
        $information = My_Parent::findorFail(Auth::user()->id);
        return view('pages.parents.profile', compact('information'));
    }

    public function update(Request $request, $id)
    {
        // $id قادم من الرابط ولا يُعتمَد عليه: يجب ألا يستطيع أي ولي أمر تعديل بيانات ولي أمر آخر
        // (بما فيها كلمة المرور) بمجرد تغيير الرقم في الطلب، لذا نستخدم هوية المستخدم المسجَّل دخوله فقط
        $information = My_Parent::findorFail(Auth::user()->id);

        if (!empty($request->password)) {
            $information->Name_Father = ['en' => $request->Name_en, 'ar' => $request->Name_ar];
            $information->password = Hash::make($request->password);
            $information->save();
        } else {
            $information->Name_Father = ['en' => $request->Name_en, 'ar' => $request->Name_ar];
            $information->save();
        }
        toastr()->success(trans('messages.Update'));
        return redirect()->back();
    }
}
