<?php

namespace App\Http\Controllers\Students\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\students;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{

    public function index()
    {
        $information = students::findorFail(Auth::user()->id);
        return view('pages.Students.dashboard.profile', compact('information'));
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        //
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
        $information = students::findorFail($id);

        if (!empty($request->password)) {
            $information
                ->setTranslation('name', 'en', $request->Name_en)
                ->setTranslation('name', 'ar', $request->Name_ar);
            $information->password = Hash::make($request->password);
            $information->save();
        } else {
            $information->name = ['en' => $request->Name_en, 'ar' => $request->Name_ar];
            $information->save();
        }
        toastr()->success(trans('messages.Update'));
        return redirect()->back();
    }


    public function destroy($id)
    {
        //
    }
}
