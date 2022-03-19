@extends('admin.layouts')

@section("content")

    <div class="row justify-content-md-center">
        <div class="col-md-10">
            <div class="card shadow mb-4">

                <div class="card-header py-3">
                    <div class="d-flex flex-row">
                        <div class="col-md-10">
                            @if(isset($expanceCategory))
                                <h6 class="m-0 font-weight-bold text-primary">Update Expense Category</h6>
                            @else
                                <h6 class="m-0 font-weight-bold text-primary">Create Expense Category</h6>
                            @endif

                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form method="POST" action="@if(isset($expanceCategory)) {{route('expenseCategory.update',$expanceCategory->id)}} @else {{route('expenseCategory.store')}} @endif" >
                        @csrf
                        @if(isset($expanceCategory))
                            @method('PUT')
                        @endif
                        <div class="row mb-3">
                            <div class="col">
                                <label for="mcn">Expense Category Name</label>
                                <input type="text" name="name" id="name" class="form-control" placeholder="Enter expense category name" @if(isset($expanceCategory)) value="{{ $expanceCategory->name }}" @else value="{{ old('name') }} @endif" required>
                                @error('name')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="d-flex flex-row mb-3">
                            <div class="col-10 p-2"></div>
                            <div class="col-2 p-2">
                                <a href="{{route('expenseCategory.index')}}" class="btn btn-danger btn-sm">Cancel</a>
                                <button type="submit" class="btn btn-success btn-sm">@if(isset($expanceCategory)) Update @else Submit @endif</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


@endsection
