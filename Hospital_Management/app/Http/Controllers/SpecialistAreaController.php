<?php

namespace App\Http\Controllers;

use App\MedicalCollege;
use App\SpecialistArea;
use App\User;
use Illuminate\Http\Request;

class SpecialistAreaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $saList = SpecialistArea::all();
        $this->activity_log("get Specialist area list", "index");
        return view('admin.specialistArea.index')->with('saList', $saList);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->activity_log("open Specialist area from", "create");
        return view('admin.specialistArea.create');
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
        $saList = new SpecialistArea();
        $saList->name = $request->name;
        $saList->save();

        session()->flash('success', 'Specialist area created successfully');
        $this->activity_log("store new specialist area. { name:".$request->name." }", "store");
        return redirect()->route('specialistArea.index');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $saList = SpecialistArea::where('id',$id)->first();
        $this->activity_log("edit specialist area. { name:".$saList->name." id:".$saList->id." }", "edit");
        return view('admin.specialistArea.create')->with('saList', $saList);
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
        $saList = SpecialistArea::findOrFail($id);

        $this->validate($request, [
            'name' => 'required',
        ]);

        $saList->name = $request->name;
        $saList->save();
        $this->activity_log("updated specialist area. { name:".$saList->name." id:".$saList->id." }", "update");
        session()->flash('success', 'Specialist area updated successfully');
        return redirect()->route('specialistArea.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $userInfo = User::where('doctor_specialist', $id)->get();
        if(count($userInfo) > 0){
            session()->flash('warning', 'You can not delete this option. Because a user already use this option');
            return redirect()->route('specialistArea.index');
        }else{
            $saList = SpecialistArea::findOrFail($id);
            $this->activity_log("deleted specialist area { name:".$saList->name." id:".$saList->id." }", "destroy");
            $saList->delete();
            session()->flash('success', 'Special Area deleted successfully');
            return redirect()->route('specialistArea.index');
        }

    }

    public function activity_log($log_details, $fn){
        $ac = new ActiveController();
        $ac->saveLogData(auth()->user()->id, $log_details, 'SpecialistAreaController', $fn);
    }
}
