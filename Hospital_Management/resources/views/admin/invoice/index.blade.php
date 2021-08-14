@extends('admin.layouts')

@section("content")
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="d-flex flex-row">
                <div class="col-md-10">
                    <h6 class="m-0 font-weight-bold text-primary">Invoice List</h6>
                </div>
                <div class="col-md-2" style="margin-left: 65px;">
                    <a href="{{route('invoices.create')}}" class="btn btn-primary btn-sm pl-10">Create Invoice</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th width="5%">SN</th>
                        <th width="10%" class="sorting_desc">Invoice No</th>
                        <th width="10%">Invoice Date</th>
                        <th width="10%">Patient Name</th>
                        <th width="10%">Doctor Name</th>
                        <th width="10%">Refferal</th>
                        <th width="10%">Remark</th>
                        @if(Auth::user()->role == "admin")
                        <th width="5%">Created By</th>
                        @endif
                        <th width="20%">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($invoiceList as $key=>$invoice)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>{{ $invoice->iv_no }}</td>
                            <td>{{ date_format($invoice->formated_ic_date,'d-m-y') }}</td>
                            <td>{{ $invoice->getPatient->name }}</td>
                            <td>{{ $invoice->getDoctor->name }}</td>
                            <td>{{ $invoice->getReference->name }}</td>
                            <td>{{ $invoice->remark }}</td>
                            @if(Auth::user()->role == "admin")
                            <td>{{ $invoice->getCreatedUser['name'] }}</td>
                            @endif
                            <td>
                                <a href="{{route('invoices.show',$invoice->id)}}" class="btn btn-info btn-sm">View</a>
                                <a href="{{route('invoices.edit',$invoice->id)}}" class="btn btn-primary btn-sm">Edit</a>
                                <button class="btn btn-danger btn-sm" onclick="handleDelete({{ $invoice->id }})">Delete</button>
                            </td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <form action="" method="POST" id="deleteForm">
        @csrf
        <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4>Are you sure want to delete this Invoice?</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success btn-sm" data-dismiss="modal">No. Go back</button>
                        <button type="submit" class="btn btn-danger btn-sm">Yes. Delete</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable({
                "order": [[ 0, "desc" ]]
            });
        });

        function handleDelete(id){
            var form = document.getElementById('deleteForm')
            form.action = '/deleteInvoice/'+id
            $('#deleteModal').modal('show')
        }
    </script>
@endsection
