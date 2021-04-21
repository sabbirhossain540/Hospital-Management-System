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
        $referenceList = References::all();
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
        $this->activity_log("open service create from", "create");
        return view('admin.services.create');
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
            'price' => 'required',
        ]);

        $services = new Services();
        $services->name = $request->name;
        $services->price = $request->price;
        $services->unit = $request->unit;
        $services->save();

        session()->flash('success', $request->name.' created successfully');
        $this->activity_log("store new service. { name:".$request->name." }", "store");
        return redirect()->route('services.index');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $serviceInfo = Services::where('id',$id)->first();
        $this->activity_log("edit service. { name:".$serviceInfo->name." id:".$serviceInfo->id." }", "edit");
        return view('admin.services.create')->with('serviceInfo', $serviceInfo);
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
        $serviceInfo = Services::findOrFail($id);

        $this->validate($request, [
            'name' => 'required',
            'price' => 'required',
        ]);

        $serviceInfo->name = $request->name;
        $serviceInfo->price = $request->price;
        $serviceInfo->unit = $request->unit;
        $serviceInfo->save();
        $this->activity_log("updated service. { name:".$serviceInfo->name." id:".$serviceInfo->id." }", "update");
        session()->flash('success', $serviceInfo->name.' service updated successfully');
        return redirect()->route('services.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $medicalCollege = Services::findOrFail($id);
        $this->activity_log("deleted service { name:".$medicalCollege->name." id:".$medicalCollege->id." }", "destroy");
        $medicalCollege->delete();
        session()->flash('success', 'Service deleted successfully');
        return redirect()->route('services.index');
    }

    public function activity_log($log_details, $fn){
        $ac = new ActiveController();
        $ac->saveLogData(auth()->user()->id, $log_details, 'ServicesController', $fn);
    }
}
