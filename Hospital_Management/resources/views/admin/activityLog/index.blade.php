@extends('admin.layouts')

@section("content")

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="d-flex flex-row">
                <div class="col-md-10">
                    <h6 class="m-0 font-weight-bold text-primary">Activity Log</h6>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>Log Details</th>
                        <th>User Role</th>
                        <th>Created By</th>
                        <th>Created At</th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach($activityList as $data)
                        <tr>
                            <td>{{ $data->log_details }}. <strong style="color: mediumvioletred">operated By {{ $data->users->username }}</strong></td>
                            <td>{{ $data->users->role }}</td>
                            <td>{{ $data->users->name }}</td>
                            <td>{{ $data->created_at }}</td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable({
                "order": [[ 1, "desc" ]]
            });
        });
    </script>

@endsection
