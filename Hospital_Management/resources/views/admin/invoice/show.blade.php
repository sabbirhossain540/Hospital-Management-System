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
                    <td width="20%">Invoice No</td>
                    <td>BCAD{{ $invoiceInfo->id }}</td>
                </tr>
                <tr>
                    <td>Invoice Date</td>
                    <td>{{ $invoiceInfo->ic_date }}</td>
                </tr>
                <tr>
                    <td>Patient Name</td>
                    <td>{{ $invoiceInfo->getPatient->name }}</td>
                </tr>
                <tr>
                    <td>Doctor Name</td>
                    <td>{{ $invoiceInfo->getDoctor->name }}</td>
                </tr>
                <tr>
                    <td>Reference</td>
                    <td>{{ $invoiceInfo->getReference->name }}</td>
                </tr>
                <tr>
                    <td>Remark</td>
                    <td>{{ $invoiceInfo->remark }}</td>
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
                            <td>{{ $invoice->total }}</td>
                        </tr>
                    @endforeach
                        <tr>
                            <td colspan="4" align="right">Total</td>
                            <td>{{ $totalAmount }}</td>
                        </tr>
                    </tbody>
                </table>

        </div>
    </div>


@endsection
