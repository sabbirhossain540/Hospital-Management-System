<?php

namespace App\Http\Controllers;

use App\Invoice;
use App\Expense;
use App\ExpenseDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\ExpenceCategory;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $expanseList = Expense::all();
        foreach($expanseList as $list){
            $list['formated_exp_date'] = Carbon::parse($list->exp_date);
        }
        return view('admin.expense.index', compact('expanseList'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $expenseList = ExpenceCategory::all();
        return view('admin.expense.create', compact('expenseList'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        dd($request->all());
        //
//        $getExpense = Expense::latest()->first();
//        if($getExpense != ''){
//            $expNo = $getExpense->id+1;
//        }else{
//            $expNo = 1;
//        }
//
//        $exNo = "BCADC/".date("Y")."/".date('M')."/".$expNo."/Exp";
//        $expMaster = new Expense();
//        $expMaster->exp_no = $exNo;
//        $expMaster->comments = $ivno;
//        $expMaster->amount = $ivno;
//        $expMaster->exp_date = $ivno;
//        $expMaster->created_user = Auth::user()->id;
//        $expMaster->save();
//
//        $size = count($request->invoice_details);
//
//        for($i = 0; $i < $size ; $i++){
//            $invoiceDetails = new ExpenseDetails();
//            $invoiceDetails->invoice_id = $invoiceMaster->id;
//            $invoiceDetails->service_id = $request->invoice_details[$i]['service_id'];
//            $invoiceDetails->price = $request->invoice_details[$i]['price'];
//            $invoiceDetails->quantity = $request->invoice_details[$i]['quantity'];
//            $invoiceDetails->subtotal = $request->invoice_details[$i]['subTotal'];
//            $invoiceDetails->discount = $request->invoice_details[$i]['discount'];
//            $invoiceDetails->total = $request->invoice_details[$i]['total'];
//            $invoiceDetails->save();
//        }
//
//        return true;
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

    public function getExpenseCategoryInfo($id){
        $ExpenseCategory = ExpenceCategory::where('id',$id)->first();
        return $ExpenseCategory;
    }
}
