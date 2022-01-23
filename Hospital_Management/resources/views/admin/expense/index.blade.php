@extends('admin.layouts')

@section("content")
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="d-flex flex-row">
                <div class="col-md-10">
                    <h6 class="m-0 font-weight-bold text-primary">Expense List</h6>
                </div>
                <div class="col-md-2" style="margin-left: 65px;">
                    <a href="{{route('expenses.create')}}" class="btn btn-primary btn-sm pl-9">Create Expense</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th width="5%">SN</th>
                        <th width="15%" class="sorting_desc">Expanse No</th>
                        <th width="15%">Expanse Date</th>
                        <th width="10%">Amount</th>
                        <th width="20%">Comment</th>
                        @if(Auth::user()->role == "admin")
                        <th width="5%">Created By</th>
                        @endif
                        <th width="30%">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($expanseList as $key=>$expanse)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>{{ $expanse->exp_no }}</td>
                            <td>{{ date_format($expanse->formated_exp_date,'d-m-y') }}</td>
                            <td>{{ $expanse->amount }}</td>
                            <td>{{ $expanse->comments }}</td>
                            @if(Auth::user()->role == "admin")
                            <td>{{ $expanse->getCreatedUser['name'] }}</td>
                            @endif
                            <td>
                                <a href="{{route('expenses.show',$expanse->id)}}" class="btn btn-info btn-sm">View</a>
                                <a target="_blank" class="btn btn-warning btn-sm" href="{{route('printExpanse', $expanse->id)}}">Print</a>
                                <a href="{{route('expenses.edit',$expanse->id)}}" class="btn btn-primary btn-sm">Edit</a>
                                <button class="btn btn-danger btn-sm" onclick="handleDelete({{ $expanse->id }})">Delete</button>
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
                        <h4>Are you sure want to delete this Expense Voucher?</h4>
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
            form.action = '/deleteExpense/'+id
            $('#deleteModal').modal('show')
        }
    </script>
@endsection
