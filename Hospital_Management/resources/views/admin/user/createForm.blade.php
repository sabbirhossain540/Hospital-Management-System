@extends('admin.layouts')

@section("content")
    <div class="row justify-content-md-center">
        <div class="col-md-10">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <div class="d-flex flex-row">
                        <div class="col-md-10">
                            <h6 class="m-0 font-weight-bold text-primary">Create User</h6>
                        </div>
                        <div class="col-md-2" style="">
                            <a href="{{route('userList')}}" class="btn btn-success btn-sm pl-10">Back to List</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form>
                        <div class="row">
                            <div class="col">
                                <input type="text" class="form-control" placeholder="First name">
                            </div>
                            <div class="col">
                                <input type="text" class="form-control" placeholder="Last name">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


@endsection
