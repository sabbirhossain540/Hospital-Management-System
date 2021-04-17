@extends('admin.layouts')

@section("content")

    <div class="row justify-content-md-center">
        <div class="col-md-10">
            <div class="card shadow mb-4">

                <div class="card-header py-3">
                    <div class="d-flex flex-row">
                        <div class="col-md-10">
                            <h6 class="m-0 font-weight-bold text-primary">Create Medical College</h6>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form method="POST" action="@if(isset($collegeInfo)) {{route('medicalCollege.update',$collegeInfo->id)}} @else {{route('medicalCollege.store')}} @endif" >
                        @csrf
                        @if(isset($collegeInfo))
                            @method('PUT')
                        @endif
                        <div class="row mb-3">
                            <div class="col">
                                <label for="mcn">Medical College Name</label>
                                <input type="text" name="name" id="name" class="form-control" placeholder="Enter medical college name" @if(isset($collegeInfo)) value="{{ $collegeInfo->name }}" @else value="{{ old('college_name') }} @endif" required>
                                @error('college_name')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="d-flex flex-row mb-3">
                            <div class="col-10 p-2"></div>
                            <div class="col-2 p-2">
                                <a href="{{route('medicalCollege.index')}}" class="btn btn-danger btn-sm">Cancel</a>
                                <button type="submit" class="btn btn-success btn-sm">@if(isset($collegeInfo)) Update @else Submit @endif</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


@endsection
