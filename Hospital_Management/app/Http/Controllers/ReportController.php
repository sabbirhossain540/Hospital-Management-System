<?php

namespace App\Http\Controllers;

use App\Invoice;
use App\InvoiceDetails;
//use Barryvdh\DomPDF\PDF;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class ReportController extends Controller
{
    public function generatePdfSalesReport(){
        $invoiceList = InvoiceDetails::all();
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
        //return $fromDate;
        $recordList = InvoiceDetails::with('getServiceName')->whereBetween('created_at', [$fromDate, $toDate])->get();
//        Reservation::whereBetween('reservation_from', [$from, $to])->get();
//        $recordList = InvoiceDetails::all();
        return $recordList;

    }
}
