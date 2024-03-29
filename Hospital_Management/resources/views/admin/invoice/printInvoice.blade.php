<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <title>Print Invoice</title>
    <style>
        .custom_font_size{
            font-size: 10px;
        }
    </style>
</head>
<body style="margin: 95px 0px 35px 0px;">
{{--<table class="mb-5">--}}
{{--    <tr>--}}
{{--        <td colspan="5"><img src="{{ public_path('img/report.webp') }}" style="border-radius: 45px; text-align: center;" alt="logo" width="100" height="100"></td>--}}
{{--        <td><h2 class="text-center">Bashundhara clinic & Diagnostic center</h2><br><p class="text-center" style="margin-top: -35px;">Hospital Road, Chapai Nawabganj Sadar</p><p class="text-center" style="margin-top: -20px;">Mobile no: 01771-256625, 01761-242121 (Reception)<br> 01320-788677 (Manager)</p></td>--}}
{{--    </tr>--}}
{{--    <tr></tr>--}}
{{--</table>--}}
{{--<h4 class="text-center mb-3" style="margin-top: -25px;">INVOICE</h4>--}}
<table class="table table-bordered table-sm custom_font_size p-0">
    <tr>
        <td width="20%" class="text-right"><strong>Invoice No</strong></td>
        <td width="30%">{{ $invoiceInfo->iv_no }}</td>
        <td width="20%" class="text-right"><strong>Invoice Date</strong></td>
        <td width="30%" style="font-size: 10px;">{{ date_format($invoiceInfo->formated_ic_date,'jS M, Y') }}, {{ $invoiceInfo->created_time }}</td>


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
        <td colspan="3">@if(!empty($invoiceInfo->getDoctor->name)){{ $invoiceInfo->getDoctor->name }}@endif @if(!empty($invoiceInfo->getDoctor->Specialist->name))({{ $invoiceInfo->getDoctor->Specialist->name }})@endif</td>
    </tr>
</table>

<div class="table-responsive mt-1 custom_font_size">
    <table class="table table-bordered table-sm" width="100%" cellspacing="0">
        <thead>
        <tr>
            <th width="10%">SN</th>
            <th width="45%" colspan="3">Service Name</th>
            <th width="30%" class="text-center" >Room No</th>
            <th width="15%">Price</th>


{{--            <th width="10%">Quantity</th>--}}
{{--            <th width="15%">Sub Total</th>--}}
{{--            <th width="15%">Discount</th>--}}
{{--            <th width="15%">Total</th>--}}
        </tr>
        </thead>
        <tbody>

        @foreach($invoiceInfo->invoiceDetails as $key=>$invoice)

            <tr>
                <td>{{ $key+1 }}</td>
                <td colspan="3">@if(!empty($invoice->getServiceName->name)){{ $invoice->getServiceName->name }}@endif</td>
                <td class="text-center">@if(!empty($invoice->getServiceName->room_no)){{$invoice->getServiceName->room_no}}@endif</td>
                <td>{{ $invoice->price }}</td>
{{--                <td>{{ $invoice->quantity }}</td>--}}
{{--                <td>{{ $invoice->subtotal }}</td>--}}
{{--                <td>{{ $invoice->disAmount }} ({{ $invoice->discount }}%)</td>--}}
{{--                <td>{{ floor($invoice->total) }}</td>--}}
            </tr>
        @endforeach
        <tr>
            <td colspan="4">@if($invoiceInfo->dueAmount == 0)<h5 class="mt-5 text-center" style="border: 2px solid black; border-radius: 20px;">Full Paid</h5>@endif</td>
            <td  align="right" class="text-dark">Sub total  <br> -Discount <br>Net Payble <br> Paid <br> Due</td>
            <td class="text-dark">{{ $tSubtotal }}  <br> {{ $totalDiscountAmount }} <br> {{ $totalAmount }}<br> {{ $invoiceInfo->paidAmount }}<br> {{ $invoiceInfo->dueAmount }}</td>
            {{--                            <td>{{ $totalDiscountAmount }}</td>--}}
            {{--                            <td>{{ $totalAmount }}</td>--}}
        </tr>
{{--        <tr>--}}
{{--            <td colspan="3" class="text-left">--}}
{{--                <p>Bill Officer: @if(!empty($invoiceInfo->getCreatedUser->name)) {{ $invoiceInfo->getCreatedUser->name }}@endif</p>--}}
{{--            </td>--}}
{{--        </tr>--}}
{{--        <tr>--}}
{{--            <td colspan="4" align="right">Total</td>--}}
{{--            <td>{{ $tSubtotal }}</td>--}}
{{--            <td>{{ $totalDiscountAmount }}</td>--}}
{{--            <td>{{ $totalAmount }}</td>--}}
{{--        </tr>--}}
        </tbody>
    </table>

    <p class="text-right pr-5 mt-3" style="font-size: 10px;">Bill Officer: @if(!empty($invoiceInfo->getCreatedUser->name)) {{ $invoiceInfo->getCreatedUser->name }}@endif</p>

{{--    <table width="100%">--}}
{{--        <tr>--}}
{{--            <td width="50%">--}}
{{--                <h7 style="font-size: 11px;"><span style="font-weight: bold;">Room No:</span> <br>--}}
{{--                    @foreach($invoiceInfo->invoiceDetails as $key=>$tfo)--}}
{{--                        <span>* @if(!empty($tfo->getServiceName->name)){{ $tfo->getServiceName->name }}@endif @if(!empty($tfo->getServiceName->room_no))({{$tfo->getServiceName->room_no}})@endif</span>--}}
{{--                        <br>--}}
{{--                    @endforeach--}}
{{--                </h7>--}}
{{--            </td>--}}
{{--            <td width="50%">--}}
{{--                <p class="mt-5">Signature: _________________</p>--}}
{{--                <p style="margin-top: -15px;">Bill Officer: <strong>@if(!empty($invoiceInfo->getCreatedUser->name)){{ $invoiceInfo->getCreatedUser->name }}@endif</strong></p>--}}
{{--            </td>--}}
{{--        </tr>--}}
{{--    </table>--}}

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>
</html>
