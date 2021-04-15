@extends('admin.layouts')

@section("content")

    <div class="row justify-content-md-center">
        <div class="col-md-10">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <div class="d-flex flex-row">
                        <div class="col-md-10">
                            <h6 class="m-0 font-weight-bold text-primary">Change Password</h6>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @if(session()->has('error'))
                        <div class="alert alert-danger">
                            {{ session()->get('error') }}
                        </div>
                    @endif
                    <form method="POST" action="{{route('updatePassword')}}" >
                        @csrf
                        <div class="row mb-3">
                            <div class="col-3"></div>
                            <div class="col-6">
                                <input type="text" name="old_pasword" id="old_pasword" class="form-control" placeholder="Enter your old password"  required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-3"></div>
                            <div class="col-6">
                                <input type="text" name="new_password" id="new_password" class="form-control" placeholder="Enter your new password" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-3"></div>
                            <div class="col-6">
                                <input type="text" name="confirm_password" id="confirm_password" class="form-control" placeholder="Enter confirm pasword" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col"></div>
                            <div class="col">
                                <a href="{{route('showProfile')}}" class="btn btn-danger btn-sm">Back to profile</a>
                                <button type="submit" class="btn btn-success btn-sm">Submit</button>
                            </div>
                        </div>


                    </form>
                </div>
            </div>
        </div>
    </div>


@endsection
