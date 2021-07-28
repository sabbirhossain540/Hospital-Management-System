<?php

namespace App\Http\Controllers;

use App\Invoice;
use App\InvoiceDetails;
use Illuminate\Http\Request;

class ReportController extends Controller
{
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
