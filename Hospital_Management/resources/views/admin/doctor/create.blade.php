@extends('admin.layouts')

@section("content")

    <div class="row justify-content-md-center">
        <div class="col-md-10">
            <div class="card shadow mb-4">

                <div class="card-header py-3">
                    <div class="d-flex flex-row">
                        <div class="col-md-10">
                            <h6 class="m-0 font-weight-bold text-primary">Create Doctor</h6>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{route('doctorList.store')}}" >
                        @csrf
                        <div class="row mb-3">
                            <div class="col">
                                <label for="Fullname">Fullname</label>
                                <input type="text" name="name" id="name" class="form-control" placeholder="Enter your fullname" value="{{ old('name') }}" required>
                                @error('name')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col">
                                <label for="Email">Email</label>
                                <input type="text" name="email" id="email" class="form-control" placeholder="Enter email" value="{{ old('email') }}" required>
                                @error('email')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col">
                                <label for="Usename">Username</label>
                                <input type="text" name="username" id="username" class="form-control" placeholder="Enter username" value="{{ old('username') }}">
                                @error('username')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col">
                                <label for="mobile_no">Mobile No</label>
                                <input type="text" name="mobile_no" id="mobile_no" class="form-control" placeholder="Enter mobile No" value="{{ old('mobile_no') }}" required>
                                @error('mobile_no')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col">
                                <label for="gander">Gander</label>
                                <select name="gander" id="gander" class="form-control" required>
                                    <option value="">Select Gender</option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                </select>
                            </div>
                            <div class="col">
                                <label for="dateOfBirth">Date Of Birth</label>
                                <input type="date" id="birth_day" name="birth_day" class="form-control" placeholder="Birth Day" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col">
                                <label for="eq">Educational Qualification</label>
                                <select name="educational_qualification" id="educational_qualification" class="form-control" required>
                                    <option value="">Select educational qualification</option>
                                    @foreach($qualificationList as $ql)
                                        <option value="{{ $ql->id }}">{{ $ql->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col">
                                <label for="Specialist">Specialist</label>
                                <select name="specialist" id="specialist" class="form-control" required>
                                    <option value="">Select specialist area</option>
                                    @foreach($specialistAreaList as $sa)
                                        <option value="{{ $sa->id }}">{{ $sa->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col">
                                <label for="mcn">Medical College Name</label>
                                <select name="institute_name" id="institute_name" class="form-control" required>
                                    <option value="">Select college name</option>
                                    @foreach($collegeList as $cl)
                                        <option value="{{ $cl->id }}">{{ $cl->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col">
                                <label for="py">Passing Year</label>
                                <input type="text" name="passing_year" id="passing_year" class="form-control" placeholder="Enter Passing Year" value="{{ old('passing_year') }}">
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col">
                                <label for="address">Address</label>
                                <textarea name="address" class="form-control" id="address" cols="30" rows="5" placeholder="Address">{{ old('address') }}</textarea>
                            </div>
                        </div>

                        <div class="d-flex flex-row mb-3">
                            <div class="col-10 p-2"></div>
                            <div class="col-2 p-2">
                                <a href="{{route('doctorList.index')}}" class="btn btn-danger btn-sm">Cancel</a>
                                <button type="submit" class="btn btn-success btn-sm">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        $( document ).ready(function() {
            flatpickr("#birth_day");
        });
    </script>


@endsection
