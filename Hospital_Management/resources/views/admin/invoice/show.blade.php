@extends('admin.layouts')

@section("content")
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="d-flex flex-row">
                <div class="col-md-10">
                    <h6 class="m-0 font-weight-bold text-primary">Invoice Details</h6>
                </div>
                <div class="col-md-2" style="margin-left: 65px;">
                    <a href="{{route('invoices.index')}}" class="btn btn-primary btn-sm">Back</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <td width="20%" class="text-right"><strong>Invoice No</strong></td>
                    <td width="30%">{{ $invoiceInfo->iv_no }}</td>
                    <td width="20%" class="text-right"><strong>Invoice Date</strong></td>
                    <td width="30%">{{ $invoiceInfo->ic_date }}</td>
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

            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th width="10%">SN</th>
                        <th width="15%">Service Name</th>
                        <th width="15%">Price</th>
                        <th width="15%">Quantity</th>
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
                            <td>{{ $invoice->total }}</td>
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

        </div>
    </div>


@endsection
