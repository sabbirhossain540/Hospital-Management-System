<?php

namespace App\Http\Controllers;

use App\References;
use App\Services;
use App\TempSales;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.invoice.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $patientList = User::where('role', 'patient')->get();
        $doctorList = User::where('role', 'doctor')->with('Specialist')->get();
        $referenceList = References::all();
        $serviceList = Services::all();
        return view('admin.invoice.create', compact('patientList', 'doctorList', 'referenceList', 'serviceList'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getServiceInfo($id){
        $serviceInfo = Services::where('id',$id)->first();
        return $serviceInfo;
    }

    public function postServiceInfo(Request $request){
        $this->validate($request, [
            'service_id' => 'required',
        ]);

        $temp_data = new TempSales();
        $temp_data->service_id = $request->service_id;
        $temp_data->price = $request->price;
        $temp_data->quantity = $request->quantity;
        $temp_data->total = $request->total;
        $temp_data->save();
        return "success";
    }
}
