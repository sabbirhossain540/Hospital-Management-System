<h1 style="text-align: center;">Boshundhara Clinic and Digonestic center</h1>
<h3 style="text-align: center;">Reference Wise Report</h3>
<h4 style="text-align: center;">Reference Name: {{ $referelName->name }} ({{ $referelName->code }})</h4>
<h4 style="text-align: center;">Date: {{ $fromDate }} -- {{ $toDate }}</h4>

<table width="100%">
    <thead style="border: 1px solid black">
    <tr>
        <th style="border-right: 1px solid black">SN</th>
        <th style="border-right: 1px solid black">Date</th>
        <th style="border-right: 1px solid black">IV No</th>
        <th style="border-right: 1px solid black">Patient Name</th>
        <th style="border-right: 1px solid black">Doctor Name</th>
        <th style="border-right: 1px solid black">Sub Total</th>
        <th style="border-right: 1px solid black">Discount</th>
        <th style="border-right: 1px solid black">Total</th>
        <th style="border-right: 1px solid black">Comission(%)</th>
        <th>Referal Amount</th>
    </tr>
    </thead>
    <tbody>
    @foreach($recordList as $key=>$list)
        <tr style="border: 1px solid black;">
            <td style="text-align: center;">{{ $key+1 }}</td>
            <td style="text-align: center;">{{ $list->created_at->format('d/m/Y') }}</td>
            <td style="text-align: center;">Demo</td>
            <td style="text-align: center;">{{ $list->getPatient->name }}</td>
            <td style="text-align: center;">{{ $list->getDoctor->name }}</td>
            <td style="text-align: center;">{{ $list->subtotal }}</td>
            <td style="text-align: center;">{{ $list->discount }}</td>
            <td style="text-align: center;">{{ $list->total }}</td>
            <td style="text-align: center;">{{ $list->referalParcentage }}</td>
            <td style="text-align: center;">{{ $list->referalAmount }}</td>
        </tr>
    @endforeach

    <tr style="border-top: 2px solid black !important;">
        <td colspan="4"></td>
        <td style="text-align: center; font-weight: bold;">Total</td>
        <td style="text-align: center; font-weight: bold;">{{ floor($finalTotalSubtotal) }}</td>
        <td style="text-align: center; font-weight: bold;">{{ floor($finalTotalDiscount) }}</td>
        <td style="text-align: center; font-weight: bold;">{{ floor($finalTotalAmount) }}</td>
        <td style="text-align: center; font-weight: bold;">{{ $finalreferelCommission }}</td>
        <td style="text-align: center; font-weight: bold;">{{ floor($finalTotalRefaralAmount) }}</td>
    </tr>

    </tbody>

</table>


