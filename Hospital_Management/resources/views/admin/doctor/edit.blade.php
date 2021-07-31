@extends('admin.layouts')

@section("content")

    <div class="row justify-content-md-center">
        <div class="col-md-10">
            <div class="card shadow mb-4">

                <div class="card-header py-3">
                    <div class="d-flex flex-row">
                        <div class="col-md-10">
                            <h6 class="m-0 font-weight-bold text-primary">Update Doctor</h6>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{route('doctorList.update',$userInfo->id)}}" >
                        @csrf
                        @method('PUT')
                        <div class="row mb-3">
                            <div class="col">
                                <label for="Fullname">Fullname</label>
                                <input type="text" name="name" id="name" class="form-control" placeholder="Enter your fullname" value="{{ $userInfo->name }}" required>
                                @error('name')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col">
                                <label for="Email">Email</label>
                                <input type="text" name="email" id="email" class="form-control" placeholder="Enter email" value="{{ $userInfo->email }}" required>
                                @error('email')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col">
                                <label for="Usename">Username</label>
                                <input type="text" name="username" id="username" class="form-control" placeholder="Enter username" value="{{ $userInfo->username }}" required>
                                @error('username')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col">
                                <label for="Password">Password</label>
                                <input type="text" name="password" id="password" class="form-control" placeholder="Enter password" value="{{ $userInfo->password_ref }}" required>
                            </div>
                            <div class="col">
                                <label for="mobile_no">Mobile No</label>
                                <input type="text" name="mobile_no" id="mobile_no" class="form-control" placeholder="Enter mobile No" value="{{ $userInfo->mobile_no }}" required>
                                @error('mobile_no')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col">
                                <label for="gander">Gander</label>
                                <select name="gander" id="gander" class="form-control">
                                    <option value="">Select Gender</option>
                                    <option @if($userInfo->gander == 'male') selected @endif value="male">Male</option>
                                    <option @if($userInfo->gander == 'female') selected @endif value="female">Female</option>
                                </select>
                            </div>
                            <div class="col">
                                <label for="dateOfBirth">Date Of Birth</label>
                                <input type="date" id="birth_day" name="birth_day" class="form-control" placeholder="Birth Day" value="{{ $userInfo->date_of_birth }}">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col">
                                <label for="eq">Educational Qualification</label>
                                <select name="educational_qualification" id="educational_qualification" class="form-control">
                                    <option>Select educational qualification</option>
                                    @foreach($qualificationList as $ql)
                                        <option @if($userInfo->degree == $ql->id) selected @endif value="{{ $ql->id }}">{{ $ql->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col">
                                <label for="Specialist">Specialist</label>
                                <select name="specialist" id="specialist" class="form-control">
                                    <option>Select specialist area</option>
                                    @foreach($specialistAreaList as $sa)
                                        <option @if($userInfo->doctor_specialist == $sa->id) selected @endif value="{{ $sa->id }}">{{ $sa->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col">
                                <label for="mcn">Medical College Name</label>
                                <select name="institute_name" id="institute_name" class="form-control">
                                    <option>Select college name</option>
                                    @foreach($collegeList as $cl)
                                        <option @if($userInfo->institute_name == $cl->id) selected @endif value="{{ $cl->id }}">{{ $cl->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col">
                                <label for="py">Passing Year</label>
                                <input type="text" name="passing_year" id="passing_year" class="form-control" placeholder="Enter Passing Year" value="{{ $userInfo->passing_year }}">
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col">
                                <label for="address">Address</label>
                                <textarea name="address" class="form-control" id="address" cols="30" rows="5" placeholder="Address">{{ $userInfo->address }}</textarea>
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
