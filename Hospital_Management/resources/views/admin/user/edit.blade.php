@extends('admin.layouts')

@section("content")

    <div class="row justify-content-md-center">
        <div class="col-md-10">
            <div class="card shadow mb-4">

                <div class="card-header py-3">
                    <div class="d-flex flex-row">
                        <div class="col-md-10">
                            <h6 class="m-0 font-weight-bold text-primary">Update User</h6>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form method="post" action="{{route('updateUser')}}" >
                        @csrf
                        <div class="row mb-3">
                            <div class="col">
                                <label for="Fullname">Fullname</label>
                                <input type="hidden" name="id" value="@if(isset($userInfo)) {{ $userInfo->id }} @endif">
                                <input type="hidden" name="edittype" value="{{ $editStatus }}">
                                <input type="text" name="name" id="name" class="form-control" placeholder="Enter your fullname" value="@if(isset($userInfo)) {{ $userInfo->name }} @endif" required>
                                @error('name')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col">
                                <label for="Email">Email</label>
                                <input type="text" name="email" id="email" class="form-control" placeholder="Enter email" value="@if(isset($userInfo)) {{ $userInfo->email }} @endif" required>
                                @error('email')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col">
                                <label for="Usename">Username</label>
                                <input type="text" name="username" id="username" class="form-control" placeholder="Enter username" value="@if(isset($userInfo)) {{ $userInfo->username }} @endif" required>
                                @error('username')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col" @if($editStatus == 'PE') hidden @endif>
                                <label for="mobile_no">Password</label>
                                <input type="text" name="password" id="password" class="form-control" placeholder="Enter Password" value="@if(isset($userInfo)) {{ $userInfo->password_ref }} @endif" required>
                            </div>


                            <div class="col">
                                <label for="mobile_no">Mobile No</label>
                                <input type="text" name="mobile_no" id="mobile_no" class="form-control" placeholder="Enter mobile No" value="@if(isset($userInfo)) {{ $userInfo->mobile_no }} @endif" required>
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
                                    <option @if(isset($userInfo)) @if($userInfo->gander == 'male') selected @endif @endif value="male">Male</option>
                                    <option @if(isset($userInfo)) @if($userInfo->gander == 'female') selected @endif @endif value="female">Female</option>
                                </select>
                            </div>
                            <div class="col">
                                <label for="dateOfBirth">Date Of Birth</label>
                                <input type="date" id="birth_day" name="birth_day" class="form-control" placeholder="Birth Day" value="@if(isset($userInfo)) {{ $userInfo->date_of_birth }} @endif">
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col">
                                <label for="address">Address</label>
                                <textarea name="address" class="form-control" id="address" cols="30" rows="5" placeholder="Address">@if(isset($userInfo)) {{ $userInfo->address }} @endif</textarea>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col"></div>
                            <div class="col"></div>
                            <div class="col"></div>
                            <div class="col"></div>
                            <div class="col">
                                <a href="{{route('userList')}}" class="btn btn-danger btn-sm">Cancel</a>
                                <button type="submit" class="btn btn-success btn-sm">Update</button>
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


