<?php

namespace App\Http\Controllers;

use App\Invoice;
use App\Expense;
use App\ExpenseDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\ExpenceCategory;

use App\User;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;


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

        if($request->id != ''){
            $ExpenseMaster = Expense::findOrFail($request->id);
            $ExpenseMaster->exp_date = $request->exp_date;
            $ExpenseMaster->comments = $request->comments;
            $ExpenseMaster->amount = $request->totalAmount;
            $ExpenseMaster->save();

            $expanseDetails = ExpenseDetails::where('exp_id', $request->id)->get();
            foreach($expanseDetails as $edetails)
            {
                $edetails->delete();
            }

            $size = count($request->expense_details);

            for($i = 0; $i < $size ; $i++){
                $expanseDetails = new ExpenseDetails();
                $expanseDetails->exp_title = $request->expense_details[$i]['exp_title'];
                $expanseDetails->exp_id = $ExpenseMaster->id;
                $expanseDetails->exp_category = $request->expense_details[$i]['id'];
                $expanseDetails->amount = $request->expense_details[$i]['exp_amount'];
                $expanseDetails->comments = $request->expense_details[$i]['exp_comment'];
                $expanseDetails->save();
            }

        }else{
            $getExpense = Expense::latest()->first();
            if($getExpense != ''){
                $expNo = $getExpense->id+1;
            }else{
                $expNo = 1;
            }

            $expNo = "BCADC/Exp/".date("y").date('m').date('d').$expNo;
            $expMaster = new Expense();
            $expMaster->exp_no = $expNo;
            $expMaster->comments = $request->comments;
            $expMaster->amount = $request->totalAmount;
            $expMaster->exp_date = $request->exp_date;
            $expMaster->created_user = Auth::user()->id;
            $expMaster->save();

            $size = count($request->expense_details);

            for($i = 0; $i < $size ; $i++){
                $expanseDetails = new ExpenseDetails();
                $expanseDetails->exp_title = $request->expense_details[$i]['exp_title'];
                $expanseDetails->exp_id = $expMaster->id;
                $expanseDetails->exp_category = $request->expense_details[$i]['expense_id'];
                $expanseDetails->amount = $request->expense_details[$i]['exp_amount'];
                $expanseDetails->comments = $request->expense_details[$i]['exp_comment'];
                $expanseDetails->save();
            }

        }

        return true;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $expanseList = Expense::with('expenseDetails', 'expenseDetails.getExpCategoryName', 'getCreatedUser')->where('id', $id)->first();
        $expanseList['formated_exp_date'] = Carbon::parse($expanseList->exp_date);
        return view('admin.expense.show', compact( 'expanseList'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $expenseCategoryList = ExpenceCategory::all();
        $expenseList = Expense::with('expenseDetails', 'expenseDetails.getExpCategoryName')->where('id', $id)->first();
        return view('admin.expense.edit', compact('expenseCategoryList', 'expenseList'));
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
        $expanseInfo = Expense::findOrFail($id);
        $expanseDetails = ExpenseDetails::where('exp_id', $expanseInfo->id)->get();
        foreach($expanseDetails as $edetails)
        {
            $edetails->delete();
        }

        $expanseInfo->delete();
        session()->flash('success', 'Expense Voucher deleted successfully');
        return redirect()->route('expenses.index');
    }

    public function getExpenseCategoryInfo($id){
        $ExpenseCategory = ExpenceCategory::where('id',$id)->first();
        return $ExpenseCategory;
    }

    public function printExpanse($id){
        $expanseList = Expense::with('expenseDetails', 'expenseDetails.getExpCategoryName', 'getCreatedUser')->where('id', $id)->first();
        $expanseList['formated_exp_date'] = Carbon::parse($expanseList->exp_date);
        $pdf = PDF::loadView('admin.expense.printExpanse', compact('expanseList'));
        return $pdf->stream();
    }
}
