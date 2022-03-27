<?php

namespace App\Http\Controllers;

use App\ExpenceCategory;
use App\ExpenseDetails;
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
        //set_time_limit(8000000);
    }

    //Sales Report

    /**
     * @param $fromDate
     * @param $toDate
     * @return mixed
     */
    public function generatePdfSalesReport($fromDate, $toDate){
        $originalToDate = Carbon::parse($toDate)->format('jS M, Y');
        if(date('Y-m-d') == $toDate){
            $toDate = Carbon::parse($toDate)->addDays(1);
        }
        $invoiceList = InvoiceDetails::with('getServiceName','getInvoiceInfo.getReference')->where('created_at', '>=', $fromDate)
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

        $fromDate = Carbon::parse($fromDate)->format('jS M, Y');

        $pdf = PDF::loadView('admin.report.salesReportPdf', compact('invoiceList','totalAmount', 'totalQuantity', 'totalSubTotal', 'totalDiscount', 'fromDate', 'originalToDate'));
        //return $pdf->stream();
        return $pdf->download('SalesReport.pdf');
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getSalesReport(){
        return view('admin.report.salesReport');
    }


    /**
     * @param $fromDate
     * @param $toDate
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function generateSalesReport($fromDate, $toDate){
        if(date('Y-m-d') == $toDate){
            $toDate = Carbon::parse($toDate)->addDays(1);
        }
        $recordList = InvoiceDetails::with('getServiceName','getInvoiceInfo.getReference')->where('created_at', '>=', $fromDate)
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
        $recordList = InvoiceDetails::with('getServiceName','getInvoiceInfo.getDoctor')
            ->where('service_id', $serviceId)
            ->where('created_at', '>=', $fromDate)
            ->where('created_at', '<=', $toDate)
            ->orderBy('created_at', 'DESC')
            ->get();

        return $recordList;
    }

    public function generatePdfServiceWiseSalesReport($fromDate, $toDate, $serviceId){
        $originalToDate = Carbon::parse($toDate)->format('jS M, Y');;
        if(date('Y-m-d') == $toDate){
            $toDate = Carbon::parse($toDate)->addDays(1);
        }
        $serviceName = Services::findOrFail($serviceId);

        $invoiceList = InvoiceDetails::with('getServiceName','getInvoiceInfo.getDoctor')
            ->where('service_id', $serviceId)
            ->where('created_at', '>=', $fromDate)
            ->where('created_at', '<=', $toDate)
            ->orderBy('created_at', 'DESC')
            ->get();
        //dd($invoiceList);
        $totalAmount = 0;
        $totalQuantity = 0;
        $totalSubTotal = 0;
        $totalDiscount = 0;
        foreach($invoiceList as $list){
            $totalAmount = $totalAmount + $list->total;
            $totalQuantity = $totalQuantity + $list->quantity;
            $totalSubTotal = $totalSubTotal + $list->subtotal;
            $discountAmount = $list->subtotal * $list->discount / 100;
            $totalDiscount = $totalDiscount + floor($discountAmount);
            $list['discountAmount'] = floor($discountAmount);
        }

        $fromDate = Carbon::parse($fromDate)->format('jS M, Y');

        $pdf = PDF::loadView('admin.report.serviceWiseSalesReportPdf', compact('invoiceList','totalAmount', 'totalQuantity', 'totalSubTotal', 'totalDiscount', 'fromDate', 'originalToDate', 'serviceName'));
        //return $pdf->stream();
        return $pdf->download('ServiceWiseSalesReport.pdf');
    }

    //Reference Wise Report

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getReferenceWiseReport(){
        $referenceList = References::all();
        return view('admin.report.referenceWiseReport', compact('referenceList'));
    }

    /**
     * @param $fromDate
     * @param $toDate
     * @param $referenceId
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
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

    /**
     * @param $fromDate
     * @param $toDate
     * @param $referenceId
     * @return mixed
     */
    public function generatePdfReferenceWiseReport($fromDate, $toDate, $referenceId){
        $originalToDate = Carbon::parse($toDate)->format('jS M, Y');
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

        $fromDate = Carbon::parse($fromDate)->format('jS M, Y');

        $pdf = PDF::loadView('admin.report.referenceWiseReportPdf', compact('recordList','finalTotalAmount', 'finalTotalDiscount','finalTotalRefaralAmount', 'finalTotalSubtotal','finalreferelCommission', 'fromDate', 'originalToDate', 'referelName'));
        //return $pdf->stream();
        return $pdf->download('ReferenceWiseReport.pdf');
    }


    //Doctor Wise Report

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getDoctorWiseReport(){
        $doctorList = User::with('Specialist')->where('role','doctor')->orderBy('id','DESC')->get();
        return view('admin.report.doctorWiseReport', compact('doctorList'));
    }

    /**
     * @param $fromDate
     * @param $toDate
     * @param $doctor_id
     * @param $type
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
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
            })->where('created_at', '>=', $fromDate)
                ->where('created_at', '<=', $toDate)->get();
        }


        return $recordList;
    }

    /**
     * @param $fromDate
     * @param $toDate
     * @param $doctor_id
     * @param $type
     * @return mixed
     */
    public function generatePdfDoctorWiseReport($fromDate, $toDate, $doctor_id, $type){
        $originalToDate = Carbon::parse($toDate)->format('jS M, Y');
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
            })->where('created_at', '>=', $fromDate)
                ->where('created_at', '<=', $toDate)->get();

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
            $fromDate = Carbon::parse($fromDate)->format('jS M, Y');
            $pdf = PDF::loadView('admin.report.doctorWiseSalesReportPdf', compact('recordList','totalQuantity', 'totalSubtotal','totalDiscount', 'totalAmount', 'fromDate', 'originalToDate', 'doctorName'));
            //return $pdf->stream();
            return $pdf->download('DoctorWiseSalesReport.pdf');
        }
    }


    //Expense Report

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getExpenseReport(){
        return view('admin.report.expenseReport');
    }

    /**
     * @param $fromDate
     * @param $toDate
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function generateExpenseReport($fromDate, $toDate){
        if(date('Y-m-d') == $toDate){
            $toDate = Carbon::parse($toDate)->addDays(1);
        }
        $recordList = ExpenseDetails::with('getExpCategoryName', 'getExpenseNo')->where('created_at', '>=', $fromDate)
            ->where('created_at', '<=', $toDate)
            ->get();
        return $recordList;
    }

    /**
     * @param $fromDate
     * @param $toDate
     * @return mixed
     */
    public function generatePdfExpenseReport($fromDate, $toDate){
        $originalToDate = Carbon::parse($toDate)->format('jS M, Y');
        $pdfName = "ExpenseReport(".$fromDate."/".$toDate.").pdf";
        if(date('Y-m-d') == $toDate){
            $toDate = Carbon::parse($toDate)->addDays(1);
        }
        $expenseList = ExpenseDetails::with('getExpCategoryName', 'getExpenseNo')->where('created_at', '>=', $fromDate)
            ->where('created_at', '<=', $toDate)
            ->get();

        $totalAmount = 0;
        $totalQty = 0;
        foreach($expenseList as $list){
            $totalAmount += $list->amount;
            $totalQty++;
        }

        $fromDate = Carbon::parse($fromDate)->format('jS M, Y');

        $pdf = PDF::loadView('admin.report.expenseReportPdf', compact('expenseList', 'totalAmount', 'totalQty', 'fromDate', 'originalToDate'));
        //return $pdf->stream();
        return $pdf->download($pdfName);
    }

    //Category Wise Expense Report

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getCategoryWiseExpenseReport(){
        $expCategoryList = ExpenceCategory::all();
        return view('admin.report.categoryWiseExpenseReport', compact('expCategoryList'));
    }

    /**
     * @param $fromDate
     * @param $toDate
     * @param $catId
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function generateCategoryWiseExpenseReport($fromDate, $toDate, $catId){
        if(date('Y-m-d') == $toDate){
            $toDate = Carbon::parse($toDate)->addDays(1);
        }
        $recordList = ExpenseDetails::with('getExpCategoryName','getExpenseNo')
            ->where('exp_category', $catId)
            ->where('created_at', '>=', $fromDate)
            ->where('created_at', '<=', $toDate)
            ->orderBy('created_at', 'DESC')
            ->get();

        return $recordList;
    }

    /**
     * @param $fromDate
     * @param $toDate
     * @param $catId
     * @return mixed
     */
    public function generatePdfCategoryWiseExpenseReport($fromDate, $toDate, $catId){
        $originalToDate = Carbon::parse($toDate)->format('jS M, Y');
        $pdfName = "CategoryWiseExpenseReport(".$fromDate."/".$toDate.").pdf";
        if(date('Y-m-d') == $toDate){
            $toDate = Carbon::parse($toDate)->addDays(1);
        }
        $expCategoryName = ExpenceCategory::findOrFail($catId);

        $expenseList = ExpenseDetails::with('getExpCategoryName','getExpenseNo')
            ->where('exp_category', $catId)
            ->where('created_at', '>=', $fromDate)
            ->where('created_at', '<=', $toDate)
            ->orderBy('created_at', 'DESC')
            ->get();

        $totalAmount = 0;

        foreach($expenseList as $list){
            $totalAmount = $totalAmount + $list->amount;
        }

        $fromDate = Carbon::parse($fromDate)->format('jS M, Y');

        $pdf = PDF::loadView('admin.report.categoryWiseExpenseReportPdf', compact('expenseList','totalAmount', 'fromDate', 'originalToDate', 'expCategoryName'));
        //return $pdf->stream();
        return $pdf->download($pdfName);
    }

//    public function test(){
//        //dd("Here");
//        $pdf = PDF::loadView('admin.report.test');
//        return $pdf->stream();
//        return $pdf->download('SalesReport.pdf');
//    }


}
