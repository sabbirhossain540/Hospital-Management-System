<?php

namespace App\Http\Controllers;

use App\Invoice;
use App\InvoiceDetails;
//use Barryvdh\DomPDF\PDF;
use App\References;
use App\Services;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\App;

class ReportController extends Controller
{
    public function generatePdfSalesReport($fromDate, $toDate){

        $invoiceList = InvoiceDetails::with('getServiceName')->where('created_at', '>=', $fromDate)
            ->where('created_at', '<=', $toDate)
            ->get();

        $totalAmount = 0;
        $totalQuantity = 0;
        foreach($invoiceList as $list){
            $totalAmount = $totalAmount + $list->price;
            $totalQuantity = $totalQuantity + $list->quantity;
        }

        $pdf = PDF::loadView('admin.report.salesReportPdf', compact('invoiceList','totalAmount', 'totalQuantity', 'fromDate', 'toDate'));
        //return $pdf->stream();
        return $pdf->download('SalesReport.pdf');
    }


    public function getSalesReport(){
        return view('admin.report.salesReport');
    }

    public function generateSalesReport($fromDate, $toDate){
        $recordList = InvoiceDetails::with('getServiceName')->where('created_at', '>=', $fromDate)
            ->where('created_at', '<=', $toDate)
            ->get();
//        return $toDate;
//        $endDate =  Carbon::parse($toDate)->addDays(1);
//        $endDate = $endDate->format('Y-m-d');
//        $recordList = InvoiceDetails::with('getServiceName')->whereBetween('created_at', [$fromDate, $toDate])->get();
        return $recordList;
    }



    //Service Wise Sales Report
    public function getServiceWiseSalesReport(){
        $serviceList = Services::all();
        return view('admin.report.serviceWiseReport', compact('serviceList'));
    }

    public function generateServiceWiseSalesReport($fromDate, $toDate, $serviceId){
        $recordList = InvoiceDetails::with('getServiceName')
            ->where('service_id', $serviceId)
            ->where('created_at', '>=', $fromDate)
            ->where('created_at', '<=', $toDate)
            ->orderBy('created_at', 'DESC')
            ->get();

        return $recordList;
    }

    public function generatePdfServiceWiseSalesReport($fromDate, $toDate, $serviceId){
        $serviceName = Services::findOrFail($serviceId);

        $invoiceList = InvoiceDetails::with('getServiceName')
            ->where('service_id', $serviceId)
            ->where('created_at', '>=', $fromDate)
            ->where('created_at', '<=', $toDate)
            ->orderBy('created_at', 'DESC')
            ->get();
        //dd($invoiceList);
        $totalAmount = 0;
        $totalQuantity = 0;
        foreach($invoiceList as $list){
            $totalAmount = $totalAmount + $list->price;
            $totalQuantity = $totalQuantity + $list->quantity;
        }

        $pdf = PDF::loadView('admin.report.serviceWiseSalesReportPdf', compact('invoiceList','totalAmount', 'totalQuantity', 'fromDate', 'toDate', 'serviceName'));
        //return $pdf->stream();
        return $pdf->download('ServiceWiseSalesReport.pdf');
    }

    //Reference Wise Report
    public function getReferenceWiseReport(){
        $referenceList = References::all();
        return view('admin.report.referenceWiseReport', compact('referenceList'));
    }

    public function generateReferenceWiseReport($fromDate, $toDate, $referenceId){
        //return $referenceId;
        $recordList = Invoice::with('invoiceDetails')
            ->where('reference_id', $referenceId)
            ->where('created_at', '>=', $fromDate)
            ->where('created_at', '<=', $toDate)
            ->orderBy('created_at', 'DESC')
            ->get();
        foreach($recordList as $record){
            //$record['sdvsd'] = "saca";

            //dd($record);
        }
        dd($recordList);
        //$allRecord = collect($recordList);

        dd($recordList);


        return $recordList;
    }


}
