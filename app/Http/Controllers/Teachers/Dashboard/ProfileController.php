<?php

namespace App\Http\Controllers\Teachers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Teachers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index()
    {

        $information = Teachers::findorFail(Auth::user()->id);
        return view('pages.Teachers.dashboard.profile', compact('information'));
    }

    public function update(Request $request, $id)
    {
        // $id قادم من الرابط ولا يُعتمَد عليه: يجب ألا يستطيع أي معلم تعديل بيانات معلم آخر
        // (بما فيها كلمة المرور) بمجرد تغيير الرقم في الطلب، لذا نستخدم هوية المستخدم المسجَّل دخوله فقط
        $information = Teachers::findorFail(Auth::id());

        if (!empty($request->password)) {
            $information
                ->setTranslation('Name', 'en', $request->Name_en)
                ->setTranslation('Name', 'ar', $request->Name_ar);
            $information->password = Hash::make($request->password);
            $information->save();
        } else {
            $information->Name = ['en' => $request->Name_en, 'ar' => $request->Name_ar];
            $information->save();
        }
        toastr()->success(trans('messages.Update'));
        return redirect()->back();
    }
}
