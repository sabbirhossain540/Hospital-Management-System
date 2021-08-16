@extends('admin.layouts')

@section("content")

    <div class="row justify-content-md-center">
        <div class="col-md-10">
            <div class="card shadow mb-4">

                <div class="card-header py-3">
                    <div class="d-flex flex-row">
                        <div class="col-md-10">
                            @if(isset($serviceInfo))
                                <h6 class="m-0 font-weight-bold text-primary">Update Service</h6>
                            @else
                                <h6 class="m-0 font-weight-bold text-primary">Create Service</h6>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form method="POST" action="@if(isset($serviceInfo)) {{route('services.update',$serviceInfo->id)}} @else {{route('services.store')}} @endif" >
                        @csrf
                        @if(isset($serviceInfo))
                            @method('PUT')
                        @endif
                        <div class="row mb-3">
                            <div class="col">
                                <label for="mcn">Service Name</label>
                                <input type="text" name="name" id="name" class="form-control" placeholder="Enter service name" @if(isset($serviceInfo)) value="{{ $serviceInfo->name }}" @else value="{{ old('name') }} @endif" required>
                                @error('name')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <label for="mcn">Price</label>
                                <input type="number" name="price" id="price" class="form-control" placeholder="Enter service price" @if(isset($serviceInfo)) value="{{ $serviceInfo->price }}" @else value="{{ old('price') }} @endif" required>
                                @error('price')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col">
                                <label for="mcn">Room No</label>
                                <input type="text" name="room_no" id="room_no" class="form-control" placeholder="Enter Room No" @if(isset($serviceInfo)) value="{{ $serviceInfo->room_no }}" @else value="{{ old('unit') }} @endif">
                                @error('room_no')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="d-flex flex-row mb-3">
                            <div class="col-10 p-2"></div>
                            <div class="col-2 p-2">
                                <a href="{{route('services.index')}}" class="btn btn-danger btn-sm">Cancel</a>
                                <button type="submit" class="btn btn-success btn-sm">@if(isset($serviceInfo)) Update @else Submit @endif</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


@endsection
