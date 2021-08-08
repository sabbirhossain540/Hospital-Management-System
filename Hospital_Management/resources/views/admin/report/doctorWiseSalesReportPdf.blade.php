<h1 style="text-align: center;">Boshundhara Clinic and Digonestic center</h1>
<h3 style="text-align: center;">Doctor Wise Sales Report</h3>
<h4 style="text-align: center;">Doctor Name: {{ $doctorName->name }} ({{ $doctorName->Specialist->name }})</h4>
<h4 style="text-align: center;">Date: {{ $fromDate }} -- {{ $originalToDate }}</h4>

<table width="100%">
    <thead style="border: 1px solid black">
    <tr>
        <th style="border-right: 1px solid black">SN</th>
        <th style="border-right: 1px solid black">Date</th>
        <th style="border-right: 1px solid black">Service Name</th>
        <th style="border-right: 1px solid black">Price</th>
        <th style="border-right: 1px solid black">Quantity</th>
        <th style="border-right: 1px solid black">Sub Total</th>
        <th style="border-right: 1px solid black">Discount</th>
        <th style="border-right: 1px solid black">Total</th>
    </tr>
    </thead>
    <tbody>
    @foreach($recordList as $key=>$list)
        <tr style="border: 1px solid black;">
            <td style="text-align: center;">{{ $key+1 }}</td>
            <td style="text-align: center;">{{ $list->created_at->format('d/m/Y') }}</td>
            <td style="text-align: center;">{{ $list->getServiceName->name }}</td>
            <td style="text-align: center;">{{ $list->price }}</td>
            <td style="text-align: center;">{{ $list->quantity }}</td>
            <td style="text-align: center;">{{ $list->subtotal }}</td>
            <td style="text-align: center;">{{ $list->discount }}</td>
            <td style="text-align: center;">{{ $list->total }}</td>
        </tr>
    @endforeach

    <tr style="border-top: 2px solid black !important;">
        <td colspan="3"></td>
        <td style="text-align: center; font-weight: bold;">Total</td>
        <td style="text-align: center; font-weight: bold;">{{ floor($totalQuantity) }}</td>
        <td style="text-align: center; font-weight: bold;">{{ floor($totalSubtotal) }}</td>
        <td style="text-align: center; font-weight: bold;">{{ floor($totalDiscount) }}</td>
        <td style="text-align: center; font-weight: bold;">{{ floor($totalAmount) }}</td>
    </tr>

    </tbody>

</table>


