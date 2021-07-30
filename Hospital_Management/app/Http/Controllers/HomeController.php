<?php

namespace App\Http\Controllers;

use App\Invoice;
use App\InvoiceDetails;
use App\Services;
use App\User;
use Illuminate\Http\Request;

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

        $totalService = Services::all()->count();
        $totalInvoice = Invoice::all()->count();
        $totalUser = User::all()->count();
        $totalDoctor = User::where('role','doctor')->count();
        $totalPatient = User::where('role', 'patient')->count();

        //Invoice
        $invoiceMaster = Invoice::with('invoiceDetails', 'getDoctor', 'getPatient')->take(5)->orderBy('created_at', 'DESC')->get();

        return view('admin.index', compact('salesAmount', 'totalService', 'totalInvoice', 'totalUser', 'totalDoctor', 'totalPatient', 'invoiceMaster'));
    }
}
