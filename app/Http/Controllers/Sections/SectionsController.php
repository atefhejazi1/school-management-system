<?php

namespace App\Http\Controllers\Sections;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSections;
use App\Models\Classroom;
use App\Models\Grade;
use App\Models\sections;
use App\Models\Teachers;
use Illuminate\Http\Request;

class SectionsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Eager Loading
        $Grades = Grade::with(['Sections'])->get();

        $list_Grades = Grade::all();
        $teachers = Teachers::all();

        return view('pages.Sections.Sections', compact('Grades', 'list_Grades', 'teachers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSections $request)
    {
        try {

            $validated = $request->validated();
            $Sections = new sections();

            $Sections
                ->setTranslation('Name_Section', 'en', $request->Name_Section_En)
                ->setTranslation('Name_Section', 'ar', $request->Name_Section_Ar);


            $Sections->Grade_id = $request->Grade_id;
            $Sections->Class_id = $request->Class_id;
            $Sections->Status = 1;
            $Sections->save();

            $Sections->teachers()->attach($request->teacher_id);


            toastr()->success(trans('messages.success'));

            return redirect()->route('Sections.index');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(sections $sections)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(sections $sections)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreSections $request)
    {
        try {
            $validated = $request->validated();
            $Sections = sections::findOrFail($request->id);

            $Sections
                ->setTranslation('Name_Section', 'en', $request->Name_Section_En)
                ->setTranslation('Name_Section', 'ar', $request->Name_Section_Ar);


            $Sections->Grade_id = $request->Grade_id;
            $Sections->Class_id = $request->Class_id;

            if (isset($request->Status)) {
                $Sections->Status = 1;
            } else {
                $Sections->Status = 2;
            }


            // update pivot tABLE
            // $sections->teachers()->sync($request->teacher_id); // this will replace the pivot table with the new array
            // instead of this, we can use sync method which will sync the pivot table with the new array, keeping the old ones if they still exist in the new array
            //  and deleting the ones that are not.
            if (isset($request->teacher_id)) {
                $Sections->teachers()->sync($request->teacher_id);
            } else {
                $Sections->teachers()->sync(array());
            }


            $Sections->save();
            toastr()->success(trans('messages.Update'));

            return redirect()->route('Sections.index');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        sections::findOrFail($request->id)->delete();
        toastr()->error(trans('messages.Delete'));
        return redirect()->route('Sections.index');
    }

    public function getclasses($id)
    {
        $list_classes = Classroom::where("Grade_id", $id)->pluck("Name_Class", "id");

        return $list_classes;
    }
}
