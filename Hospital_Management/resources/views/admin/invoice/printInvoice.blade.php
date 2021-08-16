<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <title>Print Invoice</title>
</head>
<body>
<table class="mb-5">
    <tr>
        <td colspan="5"><img src="{{ public_path('img/report.webp') }}" style="border-radius: 45px; text-align: center;" alt="logo" width="100" height="100"></td>
        <td><h2 class="text-center">Boshundhara Clinic and Digonestic center</h2><br><p class="text-center" style="margin-top: -35px;">Hospital Road, Chapai Nawabganj Sadar</p><p class="text-center" style="margin-top: -20px;">Mobile no: 01771-256625, 01761-242121 (Reception)<br> 01320-788677 (Manager)</p></td>
    </tr>
    <tr></tr>
</table>
<h4 class="text-center mb-3" style="margin-top: -25px;">INVOICE</h4>
<table class="table table-bordered">
    <tr>
        <td width="20%" class="text-right"><strong>Invoice No</strong></td>
        <td width="30%">{{ $invoiceInfo->iv_no }}</td>
        <td width="20%" class="text-right"><strong>Invoice Date</strong></td>
        <td width="30%">{{ date_format($invoiceInfo->formated_ic_date,'jS M, Y') }}</td>
    </tr>
    <tr>
        <td width="20%" class="text-right"><strong>Patient Name</strong></td>
        <td width="30%">{{ $invoiceInfo->getPatient->name }}</td>
        <td width="20%" class="text-right"><strong>Doctor Name</strong></td>
        <td width="30%">{{ $invoiceInfo->getDoctor->name }}</td>
    </tr>
    <tr>
        <td width="20%" class="text-right"><strong>Age</strong></td>
        <td width="30%">{{ $invoiceInfo->getPatient->age }}</td>
        <td width="20%" class="text-right"><strong>Remark</strong></td>
        <td width="30%">{{ $invoiceInfo->remark }}</td>
    </tr>
</table>

<div class="table-responsive mt-3">
    <table class="table table-bordered" width="100%" cellspacing="0">
        <thead>
        <tr>
            <th width="10%">SN</th>
            <th width="25%">Service Name</th>
            <th width="10%">Price</th>
            <th width="10%">Quantity</th>
            <th width="15%">Sub Total</th>
            <th width="15%">Discount</th>
            <th width="15%">Total</th>
        </tr>
        </thead>
        <tbody>

        @foreach($invoiceInfo->invoiceDetails as $key=>$invoice)
            <tr>
                <td>{{ $key+1 }}</td>
                <td>{{ $invoice->getServiceName->name }}</td>
                <td>{{ $invoice->price }}</td>
                <td>{{ $invoice->quantity }}</td>
                <td>{{ $invoice->subtotal }}</td>
                <td>{{ $invoice->disAmount }} ({{ $invoice->discount }}%)</td>
                <td>{{ floor($invoice->total) }}</td>
            </tr>
        @endforeach
        <tr>
            <td colspan="4" align="right">Total</td>
            <td>{{ $tSubtotal }}</td>
            <td>{{ $totalDiscountAmount }}</td>
            <td>{{ $totalAmount }}</td>
        </tr>
        </tbody>
    </table>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>
</html>
