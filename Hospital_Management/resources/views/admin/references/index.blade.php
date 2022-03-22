@extends('admin.layouts')

@section("content")
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="d-flex flex-row">
                <div class="col-md-10">
                    <h6 class="m-0 font-weight-bold text-primary">References List</h6>
                </div>
                <div class="col-md-2" style="margin-left: 30px;">
                    <a href="{{route('references.create')}}" class="btn btn-primary btn-sm pl-10"><i class="fas fa-plus"></i> Create Reference</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th width="5%">SN</th>
                        <th width="20%">Name</th>
                        <th width="10%">Code</th>
                        <th width="15%">Mobile No</th>
                        <th width="25%">Address</th>
                        <th width="5%">Comission(%)</th>
                        <th width="20">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($referenceList as $key=>$reference)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>{{ $reference->name }}</td>
                            <td>{{ $reference->code }}</td>
                            <td>{{ $reference->mobile_no }}</td>
                            <td>{{ $reference->address }}</td>
                            <td>{{ $reference->comission }}</td>
                            <td>
                                <a href="{{route('references.edit',$reference->id)}}" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>
                                <button class="btn btn-danger btn-sm" onclick="handleDelete({{ $reference->id }})"><i class="fas fa-trash-alt"></i></button>
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
                        <h4>Are you sure want to delete this Reference?</h4>
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
            form.action = '/deleteReference/'+id
            $('#deleteModal').modal('show')
        }
    </script>
@endsection
