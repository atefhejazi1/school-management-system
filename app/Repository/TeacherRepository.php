<?php

namespace App\Repository;

use App\Models\Gender;
use App\Models\specializations;
use App\Models\Teachers;
use Exception;
use Illuminate\Support\Facades\Hash;

class TeacherRepository implements TeacherRepositoryInterface
{

    public function getAllTeachers()
    {
        return Teachers::all();
    }

    public function Getspecialization()
    {
        return specializations::all();
    }

    public function GetGender()
    {
        return Gender::all();
    }

    public function StoreTeachers($request)
    {

        try {
            $Teachers = new Teachers();
            $Teachers->email = $request->Email;
            $Teachers->password =  Hash::make($request->Password);

            $Teachers
                ->setTranslation('Name', 'en', $request->Name_en)
                ->setTranslation('Name', 'ar', $request->Name_ar);



            $Teachers->Specialization_id = $request->Specialization_id;
            $Teachers->Gender_id = $request->Gender_id;
            $Teachers->Joining_Date = $request->Joining_Date;
            $Teachers->Address = $request->Address;
            $Teachers->save();
            toastr()->success(trans('messages.success'));
            return redirect()->route('Teachers.create');
        } catch (Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }


    public function editTeachers($id)
    {
        return Teachers::findOrFail($id);
    }


    public function UpdateTeachers($request)
    {
        try {
            $Teachers = Teachers::findOrFail($request->id);
            $Teachers->email = $request->Email;
            $Teachers->password =  Hash::make($request->Password);

            $Teachers
                ->setTranslation('Name', 'en', $request->Name_en)
                ->setTranslation('Name', 'ar', $request->Name_ar);

            $Teachers->Specialization_id = $request->Specialization_id;
            $Teachers->Gender_id = $request->Gender_id;
            $Teachers->Joining_Date = $request->Joining_Date;
            $Teachers->Address = $request->Address;
            $Teachers->save();
            toastr()->success(trans('messages.Update'));
            return redirect()->route('Teachers.index');
        } catch (Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }


    public function DeleteTeachers($request)
    {
        Teachers::findOrFail($request->id)->delete();
        toastr()->error(trans('messages.Delete'));
        return redirect()->route('Teachers.index');
    }
}
