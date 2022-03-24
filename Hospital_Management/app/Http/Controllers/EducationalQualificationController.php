<?php

namespace App\Http\Controllers;

use App\EducationalQualification;
use App\MedicalCollege;
use App\User;
use Illuminate\Http\Request;

class EducationalQualificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $eduQualification = EducationalQualification::all();
        //$this->activity_log("get educational qualification list", "index");
        return view('admin.educationalQualification.index')->with('eduQualification', $eduQualification);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //$this->activity_log("open educational qualification form", "create");
        return view('admin.educationalQualification.create');
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
        $eduQualification = new EducationalQualification();
        $eduQualification->name = $request->name;
        $eduQualification->save();

        session()->flash('success', 'Educational Qualification created successfully');
        //$this->activity_log("store new educational qualification. { name:".$request->name." }", "store");
        return redirect()->route('educationalQualification.index');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $eduQualification = EducationalQualification::where('id',$id)->first();
        //$this->activity_log("edit qualification. { name:".$eduQualification->name." id:".$eduQualification->id." }", "edit");
        return view('admin.educationalQualification.create')->with('eduQualification', $eduQualification);
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
        $eduQualification = EducationalQualification::findOrFail($id);

        $this->validate($request, [
            'name' => 'required',
        ]);

        $eduQualification->name = $request->name;
        $eduQualification->save();
        //$this->activity_log("updated educational qualification. { name:".$eduQualification->name." id:".$eduQualification->id." }", "update");
        session()->flash('success', 'Education Qualification updated successfully');
        return redirect()->route('educationalQualification.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $userInfo = User::where('degree', $id)->get();
        if(count($userInfo) > 0){
            session()->flash('warning', 'You can not delete this degree. Because a user already use this degree');
            return redirect()->route('educationalQualification.index');
        }else{
            $eduQualification = EducationalQualification::findOrFail($id);
            //$this->activity_log("deleted educational qualification { name:".$eduQualification->name." id:".$eduQualification->id." }", "destroy");
            $eduQualification->delete();
            session()->flash('success', 'Educational Qualification deleted successfully');
            return redirect()->route('educationalQualification.index');
        }


    }

    public function activity_log($log_details, $fn){
        $ac = new ActiveController();
        $ac->saveLogData(auth()->user()->id, $log_details, 'EducationalQualificationController', $fn);
    }
}
