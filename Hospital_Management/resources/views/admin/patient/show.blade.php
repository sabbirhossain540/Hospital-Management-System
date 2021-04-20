@extends('admin.layouts')

@section("content")
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="d-flex flex-row">
                <div class="col-md-10">
                    <h6 class="m-0 font-weight-bold text-primary">Patient Information</h6>
                </div>

                <div class="col-md-2" style="margin-left: 65px;">
                    <a href="{{route('patientList.index')}}" class="btn btn-info btn-sm pl-10">Back to list</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <div class="d-flex flex-row mb-3">
                    <div class="col-3 p-2"></div>
                    <div class="col-4 p-2" style="border-right: 1px dotted black">
                        <tr>
                            <td>Name: </td>
                            <td>{{ $userInfo->name }}</td>
                        </tr>
                        <br>
                        <tr>
                            <td>Email: </td>
                            <td>{{ $userInfo->email }}</td>
                        </tr>
                        <br>
                        <tr>
                            <td>Username: </td>
                            <td>{{ $userInfo->username }}</td>
                        </tr>
                        <br>
                        <tr>
                            <td>Gander: </td>
                            <td>{{ $userInfo->gander }}</td>
                        </tr>
                        <br>
                        <tr>
                            <td>Date of Birth: </td>
                            <td>{{ $userInfo->date_of_birth }}</td>
                        </tr>
                        <br>
                        <tr>
                            <td>Mobile No: </td>
                            <td>{{ $userInfo->mobile_no }}</td>
                        </tr>
                        <br>
                        <tr>
                            <td>Address: </td>
                            <td>{{ $userInfo->address }}</td>
                        </tr>
                    </div>
                    <div class="col-5 p-10">
                        <img class="img-profile rounded-circle ml-5"
                             src="{{ asset('template/img/undraw_profile.svg') }}" width="100" height="100" >
                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection
