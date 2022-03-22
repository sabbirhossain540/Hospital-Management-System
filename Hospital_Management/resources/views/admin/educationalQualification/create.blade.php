@extends('admin.layouts')

@section("content")

    <div class="row justify-content-md-center">
        <div class="col-md-10">
            <div class="card shadow mb-4">

                <div class="card-header py-3">
                    <div class="d-flex flex-row">
                        <div class="col-md-10">
                            @if(isset($eduQualification))
                                <h6 class="m-0 font-weight-bold text-primary">Update Educational Qualification</h6>
                            @else
                                <h6 class="m-0 font-weight-bold text-primary">Create Educational Qualification</h6>
                            @endif

                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form method="POST" action="@if(isset($eduQualification)) {{route('educationalQualification.update',$eduQualification->id)}} @else {{route('educationalQualification.store')}} @endif" >
                        @csrf
                        @if(isset($eduQualification))
                            @method('PUT')
                        @endif
                        <div class="row mb-3">
                            <div class="col">
                                <label for="mcn">Educational Qualification Name</label>
                                <input type="text" name="name" id="name" class="form-control" placeholder="Enter education qualification name" @if(isset($eduQualification)) value="{{ $eduQualification->name }}" @else value="{{ old('name') }} @endif" required>
                                @error('name')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="d-flex flex-row mb-3">
                            <div class="col-9 p-2"></div>
                            <div class="col-3 p-2">
                                <a href="{{route('educationalQualification.index')}}" class="btn btn-danger btn-sm ml-5">Cancel</a>
                                <button type="submit" class="btn btn-success btn-sm">@if(isset($eduQualification)) Update @else Submit @endif</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


@endsection
