<?php

namespace App\Http\Controllers;

use App\Invoice;
use App\InvoiceDetails;
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
        $invoiceList = Invoice::with('getPatient', 'getDoctor', 'getReference')->get();
        return view('admin.invoice.index', compact('invoiceList'));
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
        if($request->id != ''){
            $invoiceMaster = Invoice::findOrFail($request->id);
            $invoiceMaster->pataint_id = $request->pataint_id;
            $invoiceMaster->doctor_id = $request->doctor_id;
            $invoiceMaster->reference_id = $request->reference_id;
            $invoiceMaster->ic_date = $request->ic_date;
            $invoiceMaster->remark = $request->remark;
            $invoiceMaster->save();

            $invoiceDetails = InvoiceDetails::where('invoice_id', $request->id)->get();
            foreach($invoiceDetails as $idetails)
            {
                $idetails->delete();
            }

            $size = count($request->invoice_details);

            for($i = 0; $i < $size ; $i++){
                $invoiceDetails = new InvoiceDetails();
                $invoiceDetails->invoice_id = $invoiceMaster->id;
                $invoiceDetails->service_id = $request->invoice_details[$i]['service_id'];
                $invoiceDetails->price = $request->invoice_details[$i]['price'];
                $invoiceDetails->quantity = $request->invoice_details[$i]['quantity'];
                $invoiceDetails->total = $request->invoice_details[$i]['total'];
                $invoiceDetails->save();
            }

            return true;

        }else{
            $invoiceMaster = new Invoice();
            $invoiceMaster->pataint_id = $request->pataint_id;
            $invoiceMaster->doctor_id = $request->doctor_id;
            $invoiceMaster->reference_id = $request->reference_id;
            $invoiceMaster->ic_date = $request->ic_date;
            $invoiceMaster->remark = $request->remark;
            $invoiceMaster->save();

            $size = count($request->invoice_details);

            for($i = 0; $i < $size ; $i++){
                $invoiceDetails = new InvoiceDetails();
                $invoiceDetails->invoice_id = $invoiceMaster->id;
                $invoiceDetails->service_id = $request->invoice_details[$i]['service_id'];
                $invoiceDetails->price = $request->invoice_details[$i]['price'];
                $invoiceDetails->quantity = $request->invoice_details[$i]['quantity'];
                $invoiceDetails->total = $request->invoice_details[$i]['total'];
                $invoiceDetails->save();
            }

            return true;
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $invoiceInfo = Invoice::with('invoiceDetails.getServiceName', 'getPatient', 'getDoctor', 'getReference')->where('id', $id)->first();
        //dd($invoiceInfo);
        return view('admin.invoice.show', compact('invoiceInfo'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $patientList = User::where('role', 'patient')->get();
        $doctorList = User::where('role', 'doctor')->with('Specialist')->get();
        $referenceList = References::all();
        $serviceList = Services::all();
        $invoiceList = Invoice::with('invoiceDetails', 'invoiceDetails.getServiceName')->where('id', $id)->first();
        //dd($invoiceList);
        return view('admin.invoice.edit', compact('invoiceList', 'patientList', 'doctorList', 'referenceList', 'serviceList'));

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
        $invoiceInfo = Invoice::findOrFail($id);
        $invoiceDetails = InvoiceDetails::where('invoice_id', $invoiceInfo->id)->get();
        foreach($invoiceDetails as $idetails)
        {
            $idetails->delete();
        }

        $invoiceInfo->delete();
        session()->flash('success', 'Invoice deleted successfully');
        return redirect()->route('invoices.index');
    }

    public function getServiceInfo($id){
        $serviceInfo = Services::where('id',$id)->first();
        return $serviceInfo;
    }

    public function postServiceInfo(Request $request){

        $this->validate($request, [
            'service_id' => 'required',
        ]);

        if($request->id == ''){
            $temp_data = new TempSales();
            $temp_data->service_id = $request->service_id;
            $temp_data->price = $request->price;
            $temp_data->quantity = $request->quantity;
            $temp_data->total = $request->total;
            $temp_data->save();
            return "success";


        }else{
            $temp_data = TempSales::findOrFail($request->id);
            $temp_data->service_id = $request->service_id;
            $temp_data->price = $request->price;
            $temp_data->quantity = $request->quantity;
            $temp_data->total = $request->total;
            $temp_data->save();
            return "success";
        }


    }


    public function getTempInvoiceDetails(){
        $tempInvoiceDetails = TempSales::with('serviceName')->get();
        return $tempInvoiceDetails;
    }

    public function deleteTempService($id){
        $tempRecord = TempSales::findOrFail($id);
        $tempRecord->delete();
        return "Delete Successfully";
    }

    public function getTempServiceForEdit($id){
        $tempRecord = TempSales::findOrFail($id);
        return $tempRecord;
    }
}
