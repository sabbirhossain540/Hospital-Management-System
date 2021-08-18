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
            $invoiceMaster->paidAmount = $request->paidAmount;
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
            $getInvoice = Invoice::latest()->first();
            $ivNo = $getInvoice->id+1;
            $ivno = "BCADC/".date("Y")."/".date('M')."/".$ivNo;
            $invoiceMaster = new Invoice();
            $invoiceMaster->iv_no = $ivno;
            $invoiceMaster->pataint_id = $request->pataint_id;
            $invoiceMaster->doctor_id = $request->doctor_id;
            $invoiceMaster->reference_id = $request->reference_id;
            $invoiceMaster->ic_date = $request->ic_date;
            $invoiceMaster->remark = $request->remark;
            $invoiceMaster->paidAmount = $request->paidAmount;
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
        //dd($invoiceInfo);
        $invoiceInfo['formated_ic_date'] = Carbon::parse($invoiceInfo->ic_date);

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

        return view('admin.invoice.show', compact('invoiceInfo', 'totalAmount', 'totalQuantity', 'tSubtotal', 'totalDiscountAmount'));
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


    public function printInvoice($id){
        $invoiceInfo = Invoice::with('invoiceDetails.getServiceName', 'getPatient', 'getDoctor', 'getReference')->where('id', $id)->first();
        $invoiceInfo['formated_ic_date'] = Carbon::parse($invoiceInfo->ic_date);

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

        $pdf = PDF::loadView('admin.invoice.printInvoice', compact('invoiceInfo', 'totalAmount', 'totalQuantity', 'tSubtotal', 'totalDiscountAmount'));
        return $pdf->stream();
    }


}
