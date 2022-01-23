<?php

namespace App\Http\Controllers;

use App\EducationalQualification;
use Illuminate\Http\Request;
use App\ExpenceCategory;

class ExpenceCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $expCategory = ExpenceCategory::all();
        return view('admin.expenseCategory.index', compact('expCategory'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.expenseCategory.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
        ]);
        $expenceCategory = new ExpenceCategory();
        $expenceCategory->name = $request->name;
        $expenceCategory->save();

        session()->flash('success', 'Expence Category created successfully');
        //$this->activity_log("store new educational qualification. { name:".$request->name." }", "store");
        return redirect()->route('expenseCategory.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $expanceCategory = ExpenceCategory::where('id',$id)->first();
        //$this->activity_log("edit qualification. { name:".$eduQualification->name." id:".$eduQualification->id." }", "edit");
        return view('admin.expenseCategory.create', compact('expanceCategory'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $expCategory = ExpenceCategory::findOrFail($id);

        $this->validate($request, [
            'name' => 'required',
        ]);

        $expCategory->name = $request->name;
        $expCategory->save();
        //$this->activity_log("updated educational qualification. { name:".$eduQualification->name." id:".$eduQualification->id." }", "update");
        session()->flash('success', 'Expense Category updated successfully');
        return redirect()->route('expenseCategory.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $expCategory = ExpenceCategory::findOrFail($id);
        //$this->activity_log("deleted educational qualification { name:".$eduQualification->name." id:".$eduQualification->id." }", "destroy");
        $expCategory->delete();
        session()->flash('success', 'Expense Category deleted successfully');
        return redirect()->route('expenseCategory.index');
    }
}
