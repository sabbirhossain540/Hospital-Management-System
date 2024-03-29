<?php

namespace App\Http\Controllers;

use App\Expense;
use App\ExpenseDetails;
use App\Invoice;
use App\InvoiceDetails;
use App\Patient;
use App\Services;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $invoiceList = InvoiceDetails::all();
        $salesAmount = 0;
        foreach($invoiceList as $sales){
            $salesAmount = $salesAmount + $sales->total;
        }

        $expenseList = ExpenseDetails::all();
        $expenseAmount = 0;
        foreach($expenseList as $exl){
            $expenseAmount += $exl->amount;
        }


        $totalExpence = Expense::all()->count();
        $totalService = Services::all()->count();
        $totalInvoice = Invoice::all()->count();
        $totalUser = User::where('role','!=','patient')->where('role','!=','doctor')->count();
        $totalDoctor = User::where('role','doctor')->count();
        $totalPatient = User::where('role', 'patient')->count();

        //Invoice
        $invoiceMaster = Invoice::with('invoiceDetails', 'getDoctor', 'getPatient')->take(4)->orderBy('created_at', 'DESC')->get();
        foreach($invoiceMaster as $InDetails){
            $totalAmount = 0;
            foreach($InDetails->invoiceDetails as $list){
                $totalAmount = $totalAmount + $list->total;
            }
            $InDetails['totalAmount'] = floor($totalAmount);
        }

        $patientList = User::where('role','patient')->take(5)->orderBy('created_at', 'DESC')->get();

        //Last 30 Days data
        $date = Carbon::today()->subDays(30);
        $InvoiceThityDays = Invoice::where('created_at','>=',$date)->count();
        $InvoiceDetailsThityDays = InvoiceDetails::where('created_at','>=',$date)->get();

        $leatestSalesAmount = 0;
        foreach($InvoiceDetailsThityDays as $sales){
            $leatestSalesAmount = $leatestSalesAmount + $sales->total;
        }

        $expenseThityDays = Expense::where('created_at','>=',$date)->count();
        $expenseDetailsThityDays = ExpenseDetails::where('created_at','>=',$date)->get();

        $leatestExpenseAmount = 0;
        foreach($expenseDetailsThityDays as $expense){
            $leatestExpenseAmount = $leatestExpenseAmount + $expense->amount;
        }
        //End

        return view('admin.index', compact('expenseAmount', 'totalExpence', 'salesAmount', 'totalService', 'totalInvoice', 'totalUser', 'totalDoctor', 'totalPatient', 'invoiceMaster', 'patientList', 'InvoiceThityDays' , 'leatestSalesAmount', 'expenseThityDays', 'leatestExpenseAmount'));
    }
}
