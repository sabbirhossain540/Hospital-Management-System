<?php

namespace App\Http\Controllers;

use App\References;
use Illuminate\Http\Request;

class ReferencesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $referenceList = References::orderBy('id', 'DESC')->get();
        $this->activity_log("get all reference list", "index");
        return view('admin.references.index')->with('referenceList', $referenceList);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->activity_log("open reference create from", "create");
        return view('admin.references.create');
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
            'mobile_no' => 'required|min:11|max:11',
            'comission' => 'required',
            'code' => 'required',
        ]);

        $references = new References();
        $this->dataStore($references, $request);

        session()->flash('success', $request->name.' references created successfully');
        $this->activity_log("store new reference. { name:".$request->name." }", "store");
        return redirect()->route('references.index');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $referenceInfo = References::where('id',$id)->first();
        $this->activity_log("edit reference. { name:".$referenceInfo->name." id:".$referenceInfo->id." }", "edit");
        return view('admin.references.create')->with('referenceInfo', $referenceInfo);
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
        $referenceInfo = References::findOrFail($id);

        $this->validate($request, [
            'name' => 'required',
            'mobile_no' => 'required|min:11|max:11',
            'comission' => 'required',
        ]);
        $this->dataStore($referenceInfo, $request);

        $this->activity_log("updated reference. { name:".$referenceInfo->name." id:".$referenceInfo->id." }", "update");
        session()->flash('success', $referenceInfo->name.' reference updated successfully');
        return redirect()->route('references.index');

    }

    /**
     * @param $model
     * @param $request
     */
    public function dataStore($model, $request){
        $model->name = $request->name;
        $model->code = $request->code;
        $model->mobile_no = $request->mobile_no;
        $model->comission = $request->comission;
        $model->address = $request->address;
        $model->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $referenceInfo = References::findOrFail($id);
        $this->activity_log("deleted reference { name:".$referenceInfo->name." id:".$referenceInfo->id." }", "destroy");
        $referenceInfo->delete();
        session()->flash('success', 'Reference deleted successfully');
        return redirect()->route('references.index');
    }

    public function activity_log($log_details, $fn){
        $ac = new ActiveController();
        $ac->saveLogData(auth()->user()->id, $log_details, 'ReferencesController', $fn);
    }
}
