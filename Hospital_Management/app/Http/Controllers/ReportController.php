<?php

namespace App\Http\Controllers;

use App\Invoice;
use App\InvoiceDetails;
//use Barryvdh\DomPDF\PDF;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\App;

class ReportController extends Controller
{
    public function generatePdfSalesReport(){
        $invoiceList = InvoiceDetails::with('getServiceName')->get();
        $totalAmount = 0;
        $totalQuantity = 0;
        foreach($invoiceList as $list){
            $totalAmount = $totalAmount + $list->price;
            $totalQuantity = $totalQuantity + $list->quantity;
        }

        $pdf = PDF::loadView('admin.report.test', compact('invoiceList','totalAmount', 'totalQuantity'));
        return $pdf->stream();
        //return $pdf->download('invoice.pdf');
    }


    public function getSalesReport(){
        return view('admin.report.salesReport');
    }

    public function generateSalesReport($fromDate, $toDate){
        $endDate =  Carbon::parse($toDate)->addDays(1);
        $endDate = $endDate->format('Y-m-d');
        $recordList = InvoiceDetails::with('getServiceName')->whereBetween('created_at', [$fromDate, $endDate])->get();
        return $recordList;
    }
}
