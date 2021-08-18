@extends('admin.layouts')

@section("content")

    <div class="row justify-content-md-center">
        <div class="col-md-10">
            <div class="card shadow mb-4">

                <div class="card-header py-3">
                    <div class="d-flex flex-row">
                        <div class="col-md-10">
                            <h6 class="m-0 font-weight-bold text-primary">Update Patient</h6>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{route('patientList.update',$userInfo->id)}}" >
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
                                <label for="mobile_no">Mobile No</label>
                                <input type="text" name="mobile_no" id="mobile_no" class="form-control" placeholder="Enter mobile No" value="{{ $userInfo->mobile_no }}" required>
                                @error('mobile_no')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col">
                                <label for="gander">Gander</label>
                                <select name="gander" id="gander" class="form-control">
                                    <option value="">Select Gender</option>
                                    <option @if($userInfo->gander == 'male') selected @endif value="male">Male</option>
                                    <option @if($userInfo->gander == 'female') selected @endif value="female">Female</option>
                                </select>
                            </div>
                            <div class="col">
                                <label for="age">Age</label>
                                <input type="text" id="age" name="age" class="form-control" placeholder="Age" value="{{ $userInfo->age }}">
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
                                <a href="{{route('patientList.index')}}" class="btn btn-danger btn-sm">Cancel</a>
                                <button type="submit" class="btn btn-success btn-sm">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


@endsection
