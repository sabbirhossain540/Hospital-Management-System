<?php

namespace App\Http\Controllers;

use App\MedicalCollege;
use Illuminate\Http\Request;

class MedicalCollegeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $collegeList = MedicalCollege::all();
        $this->activity_log("get medical college list", "index");
        return view('admin.medicalCollege.index')->with('collegeList', $collegeList);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->activity_log("open Medical College from", "create");
        return view('admin.medicalCollege.create');
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
            'name' => 'required|unique:medical_colleges',
        ]);
        $medicalCollege = new MedicalCollege();
        $medicalCollege->name = $request->name;
        $medicalCollege->save();

        session()->flash('success', 'Medical College created successfully');
        $this->activity_log("store new Medical College. { name:".$request->name." }", "store");
        return redirect()->route('medicalCollege.index');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $collegeInfo = MedicalCollege::where('id',$id)->first();
        $this->activity_log("edit College. { name:".$collegeInfo->name." id:".$collegeInfo->id." }", "edit");
        return view('admin.medicalCollege.create')->with('collegeInfo', $collegeInfo);
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
        $collegeInfo = MedicalCollege::findOrFail($id);

        $this->validate($request, [
            'name' => 'required',
        ]);

        $collegeInfo->name = $request->name;
        $collegeInfo->save();
        $this->activity_log("updated Medical College. { name:".$collegeInfo->name." id:".$collegeInfo->id." }", "update");
        session()->flash('success', 'Medical College updated successfully');
        return redirect()->route('medicalCollege.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $medicalCollege = MedicalCollege::findOrFail($id);
        $this->activity_log("deleted medical college { name:".$medicalCollege->name." id:".$medicalCollege->id." }", "destroy");
        $medicalCollege->delete();
        session()->flash('success', 'Medical College deleted successfully');
        return redirect()->route('medicalCollege.index');
    }

    public function activity_log($log_details, $fn){
        $ac = new ActiveController();
        $ac->saveLogData(auth()->user()->id, $log_details, 'MedicalCollegeController', $fn);
    }
}
