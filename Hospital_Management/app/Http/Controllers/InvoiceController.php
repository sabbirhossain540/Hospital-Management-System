<?php

namespace App\Http\Controllers;

use App\Invoice;
use App\InvoiceDetails;
use App\References;
use App\Services;
use App\TempSales;
use App\User;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use phpDocumentor\Reflection\Types\False_;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $invoiceList = Invoice::with('getPatient', 'getDoctor', 'getReference', 'getCreatedUser')->get();
        foreach($invoiceList as $list){
            $list['formated_ic_date'] = Carbon::parse($list->ic_date);
        }

        //dd($invoiceList->getCreatedUser()->name);
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
        //dd($doctorList);
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
        $this->validate($request, [
            'doctor_id' => 'required',
            //'pataint_id' => 'required',
        ]);

        if($request->patientStatusCheck == 0){
            $this->validate($request, [
                'pataint_id' => 'required',
            ]);
        }

        if($request->id != ''){
            $invoiceMaster = Invoice::findOrFail($request->id);
            $invoiceMaster->pataint_id = $request->pataint_id;
            $invoiceMaster->doctor_id = $request->doctor_id;
            $invoiceMaster->reference_id = $request->reference_id;
            $invoiceMaster->ic_date = $request->ic_date;
            $invoiceMaster->remark = $request->remark;
            $invoiceMaster->paidAmount = $request->paidAmount;
            $invoiceMaster->discountAmount = $request->discountAmount;
            $invoiceMaster->dueAmount = $request->dueAmount;
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
                $invoiceDetails->subtotal = $request->invoice_details[$i]['subTotal'];
                $invoiceDetails->discount = $request->invoice_details[$i]['discount'];
                $invoiceDetails->total = $request->invoice_details[$i]['total'];
                $invoiceDetails->save();
            }

            return true;

        }else{
            $pat_id = '';

            if($request->patientStatusCheck == 1){
                $ac = new PatientController();
                $temp_password = rand(10000000,99999999);
                $username = $ac->randomUsername();


                $user = new User;
                $user->password = Hash::make(trim($temp_password));
                $user->password_ref = trim($temp_password);
                $user->role = 'patient';
                $user->username = $username;

                $user->name = $request->patientName;
                $user->mobile_no = $request->mobile_no;
                $user->gander = $request->gander;
                $user->age = $request->age;
                $user->address = $request->address;
                $user->save();
                $pat_id = $user->id;
            }else{
                $pat_id = $request->pataint_id;

}

            $getInvoice = Invoice::latest()->first();

            if($getInvoice != ''){
                $ivNo = $getInvoice->id+1;
            }else{
                $ivNo = 1;
            }


            $ivNo = "BCADC/INV/".date("y").date('m').date('d').$ivNo;
            $invoiceMaster = new Invoice();
            $invoiceMaster->iv_no = $ivNo;
            $invoiceMaster->pataint_id = $pat_id;
            $invoiceMaster->doctor_id = $request->doctor_id;
            $invoiceMaster->reference_id = $request->reference_id;
            $invoiceMaster->ic_date = $request->ic_date;
            $invoiceMaster->remark = $request->remark;
            $invoiceMaster->paidAmount = $request->paidAmount;
            $invoiceMaster->discountAmount = $request->discountAmount;
            $invoiceMaster->dueAmount = $request->dueAmount;
            $invoiceMaster->created_user = Auth::user()->id;
            $invoiceMaster->save();

            $size = count($request->invoice_details);

            for($i = 0; $i < $size ; $i++){
                $invoiceDetails = new InvoiceDetails();
                $invoiceDetails->invoice_id = $invoiceMaster->id;
                $invoiceDetails->service_id = $request->invoice_details[$i]['service_id'];
                $invoiceDetails->price = $request->invoice_details[$i]['price'];
                $invoiceDetails->quantity = $request->invoice_details[$i]['quantity'];
                $invoiceDetails->subtotal = $request->invoice_details[$i]['subTotal'];
                $invoiceDetails->discount = $request->invoice_details[$i]['discount'];
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
        $invoiceInfo = Invoice::with('invoiceDetails.getServiceName', 'getPatient', 'getDoctor', 'getDoctor.Specialist', 'getReference')->where('id', $id)->first();
        $invoiceInfo['formated_ic_date'] = Carbon::parse($invoiceInfo->ic_date);
        $invoiceInfo['created_time'] = Carbon::createFromFormat('Y-m-d H:i:s', $invoiceInfo->created_at)->format('H:i:s');

        $totalAmount = 0;
        $totalQuantity = 0;
        $tSubtotal = 0;
        $totalDiscountAmount = 0;
        foreach($invoiceInfo->invoiceDetails as $invoiceList){
            $totalAmount = $totalAmount + floor($invoiceList->total);
            $totalQuantity = $totalQuantity + $invoiceList->quantity;
            $tSubtotal = $tSubtotal + floor($invoiceList->subtotal);
            $disCalculate = $invoiceList->subtotal * $invoiceList->discount / 100;
            $totalDiscountAmount = $totalDiscountAmount + floor($disCalculate);
            $invoiceList['disAmount'] = floor($disCalculate);
        }



        //$totalDiscountAmount += $invoiceInfo->discountAmount;
        $generalDiscount = $invoiceInfo->discountAmount;
        $totalAmount -= $invoiceInfo->discountAmount;

        $Different =  $tSubtotal - (($totalDiscountAmount + $invoiceInfo->discountAmount) + $invoiceInfo->paidAmount + $invoiceInfo->dueAmount);
        $totalDiscountAmount = $totalDiscountAmount + $Different;

        return view('admin.invoice.show', compact('invoiceInfo', 'totalAmount', 'totalQuantity', 'tSubtotal', 'totalDiscountAmount', 'generalDiscount'));
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

    /**
     * @param $id
     * @return mixed
     */
    public function getServiceInfo($id){
        $serviceInfo = Services::where('id',$id)->first();
        return $serviceInfo;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function printInvoice($id){
        $invoiceInfo = Invoice::with('invoiceDetails.getServiceName', 'getCreatedUser','getPatient', 'getDoctor', 'getDoctor.Specialist', 'getReference')->where('id', $id)->first();
        $invoiceInfo['formated_ic_date'] = Carbon::parse($invoiceInfo->ic_date);
        $invoiceInfo['created_time'] = Carbon::createFromFormat('Y-m-d H:i:s', $invoiceInfo->created_at)->format('H:i:s');

        $totalAmount = 0;
        $totalQuantity = 0;
        $tSubtotal = 0;
        $totalDiscountAmount = 0;
        foreach($invoiceInfo->invoiceDetails as $invoiceList){
            $totalAmount = $totalAmount + floor($invoiceList->total);
            $totalQuantity = $totalQuantity + $invoiceList->quantity;
            $tSubtotal = $tSubtotal + floor($invoiceList->subtotal);
            $disCalculate = $invoiceList->subtotal * $invoiceList->discount / 100;
            $totalDiscountAmount = $totalDiscountAmount + floor($disCalculate);
            $invoiceList['disAmount'] = floor($disCalculate);
        }
        $Different =  $tSubtotal - (($totalDiscountAmount + $invoiceInfo->discountAmount) + $invoiceInfo->paidAmount + $invoiceInfo->dueAmount);
        $totalDiscountAmount = $totalDiscountAmount + $Different;

        $totalDiscountAmount += $invoiceInfo->discountAmount;
        $totalAmount -= $invoiceInfo->discountAmount;



        $customPaper = array(0,0,380,576);
        $pdf = PDF::loadView('admin.invoice.printInvoice', compact('invoiceInfo', 'totalAmount', 'totalQuantity', 'tSubtotal', 'totalDiscountAmount'))->setPaper($customPaper, 'portrait');;
        return $pdf->stream();
    }


}
