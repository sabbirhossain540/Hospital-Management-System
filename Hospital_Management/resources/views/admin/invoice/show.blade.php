@extends('admin.layouts')

@section("content")
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="d-flex flex-row">
                <div class="col-md-10">
                    <h6 class="m-0 font-weight-bold text-primary">Invoice Details</h6>
                </div>
                <div class="col-md-2" style="margin-left: 65px;">
                    <a target="_blank" class="btn btn-warning btn-sm" href="{{route('printInvoice', $invoiceInfo->id)}}">Print</a>
                    <a href="{{route('invoices.index')}}" class="btn btn-primary btn-sm">Back</a>
                </div>
            </div>
        </div>
        <div class="card-body" class="printScrent">
            <table class="table table-bordered table-sm text-dark">
                <tr>
                    <td width="20%" class="text-right"><strong>Invoice No</strong></td>
                    <td width="30%">{{ $invoiceInfo->iv_no }}</td>
                    <td width="20%" class="text-right"><strong>Invoice Date</strong></td>
                    <td width="30%">{{ date_format($invoiceInfo->formated_ic_date,'jS M, Y') }}, {{ $invoiceInfo->created_time }}</td>
                </tr>
                <tr>

                    <td width="20%" class="text-right"><strong>Patient Name</strong></td>
                    <td width="30%">@if(!empty($invoiceInfo->getPatient->name)){{ $invoiceInfo->getPatient->name }}@endif</td>
                    <td width="20%" class="text-right"><strong>Sex</strong></td>
                    <td width="30%">@if(!empty($invoiceInfo->getPatient->gander)){{ $invoiceInfo->getPatient->gander }}@endif</td>
                </tr>
                <tr>
                    <td width="20%" class="text-right"><strong>Age</strong></td>
                    <td width="30%">@if(!empty($invoiceInfo->getPatient->age)){{ $invoiceInfo->getPatient->age }}@endif</td>
                    <td width="20%" class="text-right"><strong>Phone no</strong></td>
                    <td width="30%">@if(!empty($invoiceInfo->getPatient->mobile_no)){{ $invoiceInfo->getPatient->mobile_no }}@endif</td>
                </tr>
                <tr>
                    <td width="20%" class="text-right"><strong>Ref. By:</strong></td>
                    <td colspan="3">@if(!empty($invoiceInfo->getDoctor->name)) {{ $invoiceInfo->getDoctor->name }}@endif @if(!empty($invoiceInfo->getDoctor->Specialist->name))({{ $invoiceInfo->getDoctor->Specialist->name }})@endif</td>
                </tr>
            </table>

            <div class="table-responsive">
                <table class="table table-bordered table-sm text-dark" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th width="5%">SN</th>
                        <th width="70%">Service Name</th>
                        <th width="25%">Price</th>
{{--                        <th width="15%">Quantity</th>--}}
{{--                        <th width="15%">Sub Total</th>--}}
{{--                        <th width="15%">Discount</th>--}}
{{--                        <th width="15%">Total</th>--}}
                    </tr>
                    </thead>
                    <tbody>

                    @foreach($invoiceInfo->invoiceDetails as $key=>$invoice)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>@if(!empty($invoice->getServiceName->name)){{ $invoice->getServiceName->name }}@endif</td>
                            <td>{{ $invoice->price }}</td>
{{--                            <td>{{ $invoice->quantity }}</td>--}}
{{--                            <td>{{ $invoice->subtotal }}</td>--}}
{{--                            <td>{{ $invoice->disAmount }} ({{ $invoice->discount }}%)</td>--}}
{{--                            <td>{{ $invoice->total }}</td>--}}
                        </tr>
                    @endforeach
                        <tr>
                            <td colspan="2" align="right" class="text-dark">Sub total <br> +VAT TK. <br> -Discount TK. <br> -General Dis. <br>Net Payble <br> Paid Amount <br> Due TK</td>
                            <td class="text-dark">{{ $tSubtotal }} <br> 0 <br> {{ $totalDiscountAmount }} <br> {{ $generalDiscount }} <br> {{ $totalAmount }}<br> {{ $invoiceInfo->paidAmount }}<br> {{ $invoiceInfo->dueAmount }}</td>
{{--                            <td>{{ $totalDiscountAmount }}</td>--}}
{{--                            <td>{{ $totalAmount }}</td>--}}
                        </tr>
                        <tr>
                            <td colspan="3" class="text-left">
                                <p>Bill Officer: @if(!empty($invoiceInfo->getCreatedUser->name)) {{ $invoiceInfo->getCreatedUser->name }}@endif</p>
                            </td>
                        </tr>
                    </tbody>
                </table>

        </div>
    </div>


        <script>
            function printDiv()
            {
                var printContents = document.getElementById('#printScrent').innerHTML;
                var originalContents = document.body.innerHTML;

                document.body.innerHTML = printContents;

                window.print();

                document.body.innerHTML = originalContents;

                // var divToPrint=document.getElementById('#printScrent');
                //
                // var newWin=window.open('','Print-Window');
                //
                // newWin.document.open();
                //
                // newWin.document.write('<html><body onload="window.print()">'+divToPrint.innerHTML+'</body></html>');
                //
                // newWin.document.close();
                //
                // setTimeout(function(){newWin.close();},10);

            }
        </script>


@endsection
