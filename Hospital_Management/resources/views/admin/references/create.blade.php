@extends('admin.layouts')

@section("content")

    <div class="row justify-content-md-center">
        <div class="col-md-10">
            <div class="card shadow mb-4">

                <div class="card-header py-3">
                    <div class="d-flex flex-row">
                        <div class="col-md-10">
                            @if(isset($referenceInfo))
                                <h6 class="m-0 font-weight-bold text-primary">Update Reference</h6>
                            @else
                                <h6 class="m-0 font-weight-bold text-primary">Create Reference</h6>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form method="POST" action="@if(isset($referenceInfo)) {{route('references.update',$referenceInfo->id)}} @else {{route('references.store')}} @endif" >
                        @csrf
                        @if(isset($referenceInfo))
                            @method('PUT')
                        @endif
                        <div class="row mb-3">
                            <div class="col">
                                <label for="mcn">Name</label>
                                <input type="text" name="name" id="name" class="form-control" placeholder="Enter reference name" @if(isset($referenceInfo)) value="{{ $referenceInfo->name }}" @else value="{{ old('name') }} @endif" required>
                                @error('name')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <label for="mcn">Mobile No</label>
                                <input type="number" name="mobile_no" id="mobile_no" class="form-control" placeholder="Enter mobile no" @if(isset($referenceInfo)) value="{{ $referenceInfo->mobile_no }}" @else value="{{ old('mobile_no') }} @endif" required>
                                @error('mobile_no')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col">
                                <label for="mcn">Comission (%)</label>
                                <input type="text" name="comission" id="comission" class="form-control" placeholder="Enter reference commission" @if(isset($referenceInfo)) value="{{ $referenceInfo->comission }}" @else value="{{ old('comission') }} @endif" required>
                                @error('comission')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col">
                                <label for="address">Address</label>
                                <textarea name="address" class="form-control" id="address" cols="30" rows="5" placeholder="Address">@if(isset($referenceInfo)) {{ $referenceInfo->address }} @else {{ old('address') }} @endif</textarea>
                            </div>
                        </div>
                        <div class="d-flex flex-row mb-3">
                            <div class="col-10 p-2"></div>
                            <div class="col-2 p-2">
                                <a href="{{route('references.index')}}" class="btn btn-danger btn-sm">Cancel</a>
                                <button type="submit" class="btn btn-success btn-sm">@if(isset($referenceInfo)) Update @else Submit @endif</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


@endsection
