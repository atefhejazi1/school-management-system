<?php


namespace App\Repository;


use App\Models\Fee;
use App\Models\Fees;
use App\Models\Grade;

class FeesRepository implements FeesRepositoryInterface
{

    public function index()
    {

        $fees = Fees::all();
        $Grades = Grade::all();
        return view('pages.Fees.index', compact('fees', 'Grades'));
    }

    public function create()
    {

        $Grades = Grade::all();
        return view('pages.Fees.add', compact('Grades'));
    }

    public function edit($id)
    {

        $fee = Fees::findorfail($id);
        $Grades = Grade::all();
        return view('pages.Fees.edit', compact('fee', 'Grades'));
    }


    public function store($request)
    {
        try {

            $fees = new Fees();

            $fees
                ->setTranslation('title', 'en', $request->title_en)
                ->setTranslation('title', 'ar', $request->title_ar);


            $fees->amount  = $request->amount;
            $fees->Grade_id  = $request->Grade_id;
            $fees->Classroom_id  = $request->Classroom_id;
            $fees->description  = $request->description;
            $fees->year  = $request->year;
            $fees->save();
            toastr()->success(trans('messages.success'));
            return redirect()->route('Fees.create');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function update($request)
    {
        try {
            $fees = Fees::findorfail($request->id);
            $fees
                ->setTranslation('title', 'en', $request->title_en)
                ->setTranslation('title', 'ar', $request->title_ar);

            $fees->amount  = $request->amount;
            $fees->Grade_id  = $request->Grade_id;
            $fees->Classroom_id  = $request->Classroom_id;
            $fees->description  = $request->description;
            $fees->year  = $request->year;
            $fees->save();
            toastr()->success(trans('messages.Update'));
            return redirect()->route('Fees.index');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function destroy($request)
    {
        try {
            Fees::destroy($request->id);
            toastr()->error(trans('messages.Delete'));
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
