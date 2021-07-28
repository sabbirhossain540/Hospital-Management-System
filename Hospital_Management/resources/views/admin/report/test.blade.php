<h1 style="text-align: center;">Boshundhara Clinic and Digonestic center</h1>
<h3 style="text-align: center;">Sales Report</h3>

<table width="100%">
    <thead style="border: 1px solid black">
        <tr>
            <th style="border-right: 1px solid black">SN</th>
            <th style="border-right: 1px solid black">Sales Date</th>
            <th style="border-right: 1px solid black">Service Name</th>
            <th style="border-right: 1px solid black">Price</th>
            <th style="border-right: 1px solid black">Quantity</th>
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
                <td style="text-align: center;">{{ $list->total }}</td>
            </tr>
        @endforeach

    <tr style="border-top: 2px solid black !important;">
        <td colspan="3"></td>
        <td style="text-align: center; font-weight: bold;">Total</td>
        <td style="text-align: center; font-weight: bold;">{{ $totalQuantity }}</td>
        <td style="text-align: center; font-weight: bold;">{{ $totalAmount }}</td>
    </tr>

    </tbody>

</table>


