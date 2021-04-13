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
                    </div>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{route('postUserDate')}}" >
                        @csrf
                        <div class="row mb-2">
                            <div class="col">
                                <input type="text" name="name" id="name" class="form-control" placeholder="Fullname" value="{{ old('name') }}">
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col">
                                <input type="text" name="email" id="email" class="form-control" placeholder="Email" value="{{ old('email') }}" >
                                @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col">
                                <input type="text" name="username" id="username" class="form-control" placeholder="Username" value="{{ old('username') }}">
                                @error('username')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col">
                                <input type="text" name="password" id="password" class="form-control" placeholder="Password" value="{{ old('password') }}" >
                                @error('password')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col">
                                <input type="text" name="mobile_no" id="mobile_no" class="form-control" placeholder="Mobile No" value="{{ old('mobile_no') }}">
                            </div>
                            <div class="col">
                                <input type="date" id="joining_date" name="joining_date" class="form-control" placeholder="Joining Date">
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col">
                                <textarea name="address" class="form-control" id="address" cols="30" rows="5" placeholder="Address">{{ old('address') }}</textarea>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col"></div>
                            <div class="col"></div>
                            <div class="col"></div>
                            <div class="col"></div>
                            <div class="col">
                                <a href="{{route('userList')}}" class="btn btn-danger btn-sm">Cancel</a>
                                <button type="submit" class="btn btn-success btn-sm">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


@endsection
