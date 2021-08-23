@extends('admin.layouts')

@section("content")
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="d-flex flex-row">
                <div class="col-md-10">
                    <h6 class="m-0 font-weight-bold text-primary">Patient Information</h6>
                </div>

                <div class="col-md-2" style="margin-left: 65px;">
                    <a href="{{route('patientList.index')}}" class="btn btn-info btn-sm pl-10">Back to list</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <div class="d-flex flex-row mb-3">
                    <div class="col-3 p-2"></div>
                    <div class="col-4 p-2" style="border-right: 1px dotted black">
                        <tr>
                            <td>Name: </td>
                            <td>{{ $userInfo->name }}</td>
                        </tr>
                        <br>
                        <tr>
                            <td>Email: </td>
                            <td>{{ $userInfo->email }}</td>
                        </tr>
                        <br>
                        <tr>
                            <td>Username: </td>
                            <td>{{ $userInfo->username }}</td>
                        </tr>
                        <br>
                        <tr>
                            <td>Gander: </td>
                            <td>{{ $userInfo->gander }}</td>
                        </tr>
                        <br>
                        <tr>
                            <td>Date of Birth: </td>
                            <td>{{ $userInfo->date_of_birth }}</td>
                        </tr>
                        <br>
                        <tr>
                            <td>Age: </td>
                            <td>{{ $userInfo->age }}</td>
                        </tr>
                        <br>
                        <tr>
                            <td>Mobile No: </td>
                            <td>{{ $userInfo->mobile_no }}</td>
                        </tr>
                        <br>
                        <tr>
                            <td>Address: </td>
                            <td>{{ $userInfo->address }}</td>
                        </tr>
                    </div>
                    <div class="col-5 p-10">
                        <img class="img-profile rounded-circle ml-5"
                             src="{{ asset('template/img/undraw_profile.svg') }}" width="100" height="100" >
                    </div>
                </div>

            </div>
            <h5 class="text-center mt-5 mb-3">Invoice List</h5>
            <div class="table-responsive">
                <table class="table table-bordered table-sm" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th width="5%">SN</th>
                        <th width="15%" class="sorting_desc">Invoice No</th>
                        <th width="20%">Invoice Date</th>
                        <th width="20%">Ref. Doctor</th>
                        <th width="10%">Paid Amount</th>
                        <th width="10%">Dues</th>
                        <th width="20%">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($invoiceList as $key=>$invoice)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>{{ $invoice->iv_no }}</td>
                            <td>{{ date_format($invoice->formated_ic_date,'d-m-y') }}</td>
                            <td>@if(!empty($invoice->getDoctor->name)){{ $invoice->getDoctor->name }}@endif</td>
                            <td>{{ $invoice->paidAmount }}</td>
                            <td>{{ $invoice->dueAmount }}</td>
                            <td><a target="_blank" class="btn btn-warning btn-sm" href="{{route('printInvoice', $invoice->id)}}">Invoice Print</a></td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection
