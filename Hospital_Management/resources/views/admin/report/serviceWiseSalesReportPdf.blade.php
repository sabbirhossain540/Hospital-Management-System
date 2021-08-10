<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <title>Service Wise Report</title>
</head>
<body>
<table>
    <tr>
        <td colspan="5"><img src="{{ public_path('img/report.webp') }}" style="border-radius: 45px; text-align: center;" alt="logo" width="100" height="100"></td>
        <td><h2 class="text-center">Boshundhara Clinic and Digonestic center</h2></td>
    </tr>
</table>

<h4 class="text-center" style="margin-top: -25px;">Service Wise Sales Report</h4>
<h6 class="text-center">Service Name: {{ $serviceName->name }}</h6>
<h6 class="text-center mb-4">Date Range: {{ $fromDate }} -- {{ $originalToDate }}</h6>

<table class="table table-sm table-bordered">
    <thead>
    <tr>
        <th class="text-center" scope="col">SN</th>
        <th class="text-center" scope="col">Sales Date</th>
        <th class="text-center" scope="col">Price</th>
        <th class="text-center" scope="col">Quantity</th>
        <th class="text-center" scope="col">Subtotal</th>
        <th class="text-center" scope="col">Discount(%)</th>
        <th class="text-center" scope="col">Total</th>
    </tr>
    </thead>
    <tbody>
    @foreach($invoiceList as $key=>$list)
        <tr>
            <td class="text-center">{{ $key+1 }}</td>
            <td class="text-center">{{ $list->created_at->format('d/m/Y') }}</td>
            <td class="text-center">{{ $list->price }}</td>
            <td class="text-center">{{ $list->quantity }}</td>
            <td class="text-center">{{ $list->subtotal }}</td>
            <td class="text-center">{{ $list->discountAmount }}({{ $list->discount }})</td>
            <td class="text-center">{{ $list->total }}</td>
        </tr>
    @endforeach

    <tr>
        <td colspan="2"></td>
        <td style="text-align: center; font-weight: bold;">Total</td>
        <td class="text-center">{{ $totalQuantity }}</td>
        <td class="text-center">{{ $totalSubTotal }}</td>
        <td class="text-center">{{ floor($totalDiscount) }}</td>
        <td class="text-center">{{ floor($totalAmount) }}</td>
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
