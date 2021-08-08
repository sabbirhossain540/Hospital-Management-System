<?php

namespace App\Http\Controllers;

use App\Invoice;
use App\InvoiceDetails;
//use Barryvdh\DomPDF\PDF;
use App\References;
use App\Services;
use App\User;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\App;

class ReportController extends Controller
{
    public function __construct()
    {
        set_time_limit(8000000);
    }

    public function generatePdfSalesReport($fromDate, $toDate){
        $originalToDate = $toDate;
        if(date('Y-m-d') == $toDate){
            $toDate = Carbon::parse($toDate)->addDays(1);
        }
        $invoiceList = InvoiceDetails::with('getServiceName')->where('created_at', '>=', $fromDate)
            ->where('created_at', '<=', $toDate)
            ->get();

        $totalAmount = 0;
        $totalQuantity = 0;
        $totalSubTotal = 0;
        $totalDiscount = 0;
        foreach($invoiceList as $list){
            $totalSubTotal = $totalSubTotal + $list->subtotal;
            $discountAmount = $list->subtotal * $list->discount / 100;
            $totalDiscount = $totalDiscount + floor($discountAmount);
            $totalAmount = $totalAmount + $list->total;
            $totalQuantity = $totalQuantity + $list->quantity;
            $list['discountAmount'] = floor($discountAmount);
        }

        $pdf = PDF::loadView('admin.report.salesReportPdf', compact('invoiceList','totalAmount', 'totalQuantity', 'totalSubTotal', 'totalDiscount', 'fromDate', 'originalToDate'));
        //return $pdf->stream();
        return $pdf->download('SalesReport.pdf');
    }


    public function getSalesReport(){
        return view('admin.report.salesReport');
    }

    public function generateSalesReport($fromDate, $toDate){
        if(date('Y-m-d') == $toDate){
            $toDate = Carbon::parse($toDate)->addDays(1);
        }
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
        if(date('Y-m-d') == $toDate){
            $toDate = Carbon::parse($toDate)->addDays(1);
        }
        $recordList = InvoiceDetails::with('getServiceName')
            ->where('service_id', $serviceId)
            ->where('created_at', '>=', $fromDate)
            ->where('created_at', '<=', $toDate)
            ->orderBy('created_at', 'DESC')
            ->get();

        return $recordList;
    }

    public function generatePdfServiceWiseSalesReport($fromDate, $toDate, $serviceId){
        $originalToDate = $toDate;
        if(date('Y-m-d') == $toDate){
            $toDate = Carbon::parse($toDate)->addDays(1);
        }
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

        $pdf = PDF::loadView('admin.report.serviceWiseSalesReportPdf', compact('invoiceList','totalAmount', 'totalQuantity', 'fromDate', 'originalToDate', 'serviceName'));
        //return $pdf->stream();
        return $pdf->download('ServiceWiseSalesReport.pdf');
    }

    //Reference Wise Report
    public function getReferenceWiseReport(){
        $referenceList = References::all();
        return view('admin.report.referenceWiseReport', compact('referenceList'));
    }

    public function generateReferenceWiseReport($fromDate, $toDate, $referenceId){
        if(date('Y-m-d') == $toDate){
            $toDate = Carbon::parse($toDate)->addDays(1);
        }
        $recordList = Invoice::with('invoiceDetails', 'getReference', 'getPatient', 'getDoctor')
            ->where('reference_id', $referenceId)
            ->where('created_at', '>=', $fromDate)
            ->where('created_at', '<=', $toDate)
            ->orderBy('created_at', 'DESC')
            ->get();
        foreach($recordList as $record){
            $subtotal = 0;
            $discountAmount = 0;
            $totalAmount = 0;
            foreach($record->invoiceDetails as $ids){
                $subtotal = $subtotal + $ids->subtotal;
                $discount = $ids->subtotal * $ids->discount / 100;
                $discountAmount = $discountAmount + $discount;
                $totalAmount = $totalAmount + $ids->total;
            }

            $referenceAmount = $totalAmount * $record->getReference->comission / 100;

            $record['subtotal'] = floor($subtotal);
            $record['discount'] = floor($discountAmount);
            $record['total'] = floor($totalAmount);
            $record['referalParcentage'] = $record->getReference->comission;
            $record['referalAmount'] = floor($referenceAmount);
        }

        return $recordList;
    }



    public function generatePdfReferenceWiseReport($fromDate, $toDate, $referenceId){
        $originalToDate = $toDate;
        if(date('Y-m-d') == $toDate){
            $toDate = Carbon::parse($toDate)->addDays(1);
        }
        $referelName = References::findOrFail($referenceId);

        $recordList = Invoice::with('invoiceDetails', 'getReference', 'getPatient', 'getDoctor')
            ->where('reference_id', $referenceId)
            ->where('created_at', '>=', $fromDate)
            ->where('created_at', '<=', $toDate)
            ->orderBy('created_at', 'DESC')
            ->get();

        $finalTotalAmount = 0;
        $finalTotalDiscount = 0;
        $finalTotalRefaralAmount = 0;
        $finalTotalSubtotal = 0;
        $finalreferelCommission = 0;

        foreach($recordList as $record){
            $subtotal = 0;
            $discountAmount = 0;
            $totalAmount = 0;
            foreach($record->invoiceDetails as $ids){
                $subtotal = $subtotal + $ids->subtotal;
                $discount = $ids->subtotal * $ids->discount / 100;
                $discountAmount = $discountAmount + $discount;
                $totalAmount = $totalAmount + $ids->total;
            }

            $referenceAmount = $totalAmount * $record->getReference->comission / 100;

            $record['subtotal'] = floor($subtotal);
            $record['discount'] = floor($discountAmount);
            $record['total'] = floor($totalAmount);
            $record['referalParcentage'] = $record->getReference->comission;
            $record['referalAmount'] = floor($referenceAmount);

            $finalTotalAmount = $finalTotalAmount + $totalAmount;
            $finalTotalDiscount = $finalTotalDiscount + $discountAmount;
            $finalTotalRefaralAmount = $finalTotalRefaralAmount + $referenceAmount;
            $finalTotalSubtotal = $finalTotalSubtotal + $subtotal;
            $finalreferelCommission = $record->getReference->comission;
        }

        $pdf = PDF::loadView('admin.report.referenceWiseReportPdf', compact('recordList','finalTotalAmount', 'finalTotalDiscount','finalTotalRefaralAmount', 'finalTotalSubtotal','finalreferelCommission', 'fromDate', 'originalToDate', 'referelName'));
        //return $pdf->stream();
        return $pdf->download('ReferenceWiseReport.pdf');
    }


    //Doctor Wise Report
    public function getDoctorWiseReport(){
        $doctorList = User::with('Specialist')->where('role','doctor')->orderBy('id','DESC')->get();
        return view('admin.report.doctorWiseReport', compact('doctorList'));
    }

    public function generateDoctorWiseReport($fromDate, $toDate, $doctor_id, $type){
        if(date('Y-m-d') == $toDate){
            $toDate = Carbon::parse($toDate)->addDays(1);
        }
        if($type == 'invoice'){
            $recordList = Invoice::with('invoiceDetails', 'getReference', 'getPatient', 'getDoctor')
                ->where('doctor_id', $doctor_id)
                ->where('created_at', '>=', $fromDate)
                ->where('created_at', '<=', $toDate)
                ->orderBy('created_at', 'DESC')
                ->get();
            foreach($recordList as $record){
                $subtotal = 0;
                $discountAmount = 0;
                $totalAmount = 0;
                foreach($record->invoiceDetails as $ids){
                    $subtotal = $subtotal + $ids->subtotal;
                    $discount = $ids->subtotal * $ids->discount / 100;
                    $discountAmount = $discountAmount + $discount;
                    $totalAmount = $totalAmount + $ids->total;
                }

                $referenceAmount = $totalAmount * $record->getReference->comission / 100;

                $record['subtotal'] = floor($subtotal);
                $record['discount'] = floor($discountAmount);
                $record['total'] = floor($totalAmount);
                $record['referalParcentage'] = $record->getReference->comission;
                $record['referalAmount'] = floor($referenceAmount);
            }
        }else{
            $recordList = InvoiceDetails::with('getServiceName')->whereHas('getInvoiceInfo', function ($query) use ($doctor_id) {
                $query->where('doctor_id', '=', $doctor_id);
            })->get();
        }


        return $recordList;
    }

    public function generatePdfDoctorWiseReport($fromDate, $toDate, $doctor_id, $type){
        $originalToDate = $toDate;
        if(date('Y-m-d') == $toDate){
            $toDate = Carbon::parse($toDate)->addDays(1);
        }
        $doctorName = User::with('Specialist')->findOrFail($doctor_id);

        if($type == 'invoice'){
            $recordList = Invoice::with('invoiceDetails', 'getReference', 'getPatient', 'getDoctor')
                ->where('doctor_id', $doctor_id)
                ->where('created_at', '>=', $fromDate)
                ->where('created_at', '<=', $toDate)
                ->orderBy('created_at', 'DESC')
                ->get();
            foreach($recordList as $record){
                $subtotal = 0;
                $discountAmount = 0;
                $totalAmount = 0;
                foreach($record->invoiceDetails as $ids){
                    $subtotal = $subtotal + $ids->subtotal;
                    $discount = $ids->subtotal * $ids->discount / 100;
                    $discountAmount = $discountAmount + $discount;
                    $totalAmount = $totalAmount + $ids->total;
                }

                $referenceAmount = $totalAmount * $record->getReference->comission / 100;

                $record['subtotal'] = floor($subtotal);
                $record['discount'] = floor($discountAmount);
                $record['total'] = floor($totalAmount);
                $record['referalParcentage'] = $record->getReference->comission;
                $record['referalAmount'] = floor($referenceAmount);
            }

            $finalTotalAmount = 0;
            $finalSubtotalAmount = 0;
            $finalDiscountAmount = 0;
            $finalRefaralAmount = 0;
            $refParcentage = 0;
            foreach($recordList as $rec){
                $finalTotalAmount = $finalTotalAmount + $rec->total;
                $finalSubtotalAmount = $finalSubtotalAmount + $rec->subtotal;
                $finalDiscountAmount = $finalDiscountAmount + $rec->discount;
                $finalRefaralAmount = $finalRefaralAmount + $rec->referalAmount;
                $refParcentage = $rec->referalParcentage;
            }

            $pdf = PDF::loadView('admin.report.doctorWiseInvoiceReportPdf', compact('recordList','finalTotalAmount', 'finalDiscountAmount','finalRefaralAmount', 'finalSubtotalAmount','refParcentage', 'fromDate', 'originalToDate', 'doctorName'));
            //return $pdf->stream();
            return $pdf->download('DoctorWiseInvoiceReport.pdf');

        }else{
            $recordList = InvoiceDetails::with('getServiceName')->whereHas('getInvoiceInfo', function ($query) use ($doctor_id) {
                $query->where('doctor_id', '=', $doctor_id);
            })->get();

            $totalQuantity = 0;
            $totalSubtotal = 0;
            $totalDiscount = 0;
            $totalAmount = 0;

            foreach($recordList as $list){
                $totalQuantity = $totalQuantity + $list->quantity;
                $totalSubtotal = $totalSubtotal + $list->subtotal;
                $discountCalculation = $list->subtotal * $list->discount / 100;
                $totalDiscount = $totalDiscount + $discountCalculation;
                $totalAmount = $totalAmount + $list->total;
            }

            $pdf = PDF::loadView('admin.report.doctorWiseSalesReportPdf', compact('recordList','totalQuantity', 'totalSubtotal','totalDiscount', 'totalAmount', 'fromDate', 'originalToDate', 'doctorName'));
            //return $pdf->stream();
            return $pdf->download('DoctorWiseSalesReport.pdf');
        }
    }


}
