@extends('admin.layouts')

@section("content")

    <div class="row justify-content-md-center">
        <div class="col-md-10">
            <div class="card shadow mb-4">

                <div class="card-header py-3">
                    <div class="d-flex flex-row">
                        <div class="col-md-10">
                            @if(isset($saList))
                                <h6 class="m-0 font-weight-bold text-primary">Update Specialist Area</h6>
                            @else
                                <h6 class="m-0 font-weight-bold text-primary">Create Specialist Area</h6>
                            @endif

                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form method="POST" action="@if(isset($saList)) {{route('specialistArea.update',$saList->id)}} @else {{route('specialistArea.store')}} @endif" >
                        @csrf
                        @if(isset($saList))
                            @method('PUT')
                        @endif
                        <div class="row mb-3">
                            <div class="col">
                                <label for="mcn">Specialist Area Name</label>
                                <input type="text" name="name" id="name" class="form-control" placeholder="Enter specialist area name" @if(isset($saList)) value="{{ $saList->name }}" @else value="{{ old('name') }} @endif" required>
                                @error('name')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="d-flex flex-row mb-3">
                            <div class="col-9 p-2"></div>
                            <div class="col-3 p-2">
                                <a href="{{route('specialistArea.index')}}" class="btn btn-danger btn-sm ml-5">Cancel</a>
                                <button type="submit" class="btn btn-success btn-sm">@if(isset($saList)) Update @else Submit @endif</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


@endsection
