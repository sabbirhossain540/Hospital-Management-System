<table>
    <tr>
        <td colspan="5"><img src="{{ public_path('img/report.webp') }}" style="border-radius: 45px; text-align: center;" alt="logo" width="90" height="90"></td>
        <td><h1 style="text-align: center;">Boshundhara Clinic and Digonestic center</h1></td>
    </tr>
</table>

<h3 style="text-align: center;margin-top: -10px;"><span style="border: 2px solid black;padding: 10px; border-radius: 10px !important;">Sales Report</span></h3>

<h4 style="text-align: center;">Date Range: {{ $fromDate }} -- {{ $originalToDate }}</h4>

<table width="100%">
    <thead style="border: 1px solid black">
        <tr>
            <th style="border-right: 1px solid black">SN</th>
            <th style="border-right: 1px solid black">Sales Date</th>
            <th style="border-right: 1px solid black">Service Name</th>
            <th style="border-right: 1px solid black">Price</th>
            <th style="border-right: 1px solid black">Quantity</th>
            <th style="border-right: 1px solid black">Sub Total</th>
            <th style="border-right: 1px solid black">Discount</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
        @foreach($invoiceList as $key=>$list)
            <tr style="border: 1px solid black;">
                <td style="text-align: center;">{{ $key+1 }}</td>
                <td style="text-align: center;">{{ $list->created_at->format('d/m/Y') }}</td>
                <td style="text-align: left;">{{ $list->getServiceName->name }}</td>
                <td style="text-align: center;">{{ $list->price }}</td>
                <td style="text-align: center;">{{ $list->quantity }}</td>
                <td style="text-align: center;">{{ $list->subtotal }}</td>
                <td style="text-align: center;">{{ $list->discountAmount }}({{ $list->discount }}%)</td>
                <td style="text-align: center;">{{ $list->total }}</td>
            </tr>
        @endforeach

    <tr style="border-top: 2px solid black !important;">
        <td colspan="3"></td>
        <td style="text-align: center; font-weight: bold;">Total</td>
        <td style="text-align: center; font-weight: bold;">{{ $totalQuantity }}</td>
        <td style="text-align: center; font-weight: bold;">{{ $totalSubTotal }}</td>
        <td style="text-align: center; font-weight: bold;">{{ $totalDiscount }}</td>
        <td style="text-align: center; font-weight: bold;">{{ floor($totalAmount) }}</td>
    </tr>

    </tbody>

</table>


