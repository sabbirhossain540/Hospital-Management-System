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
                                <h6 class="m-0 font-weight-bold text-primary">Create Invoice</h6>
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
                                <label for="pn">Patient Name</label>
                                <select name="pataint_id" id="pataint_id" class="form-control" required>
                                    <option value="">Select Patient Name</option>
                                    @foreach($patientList as $patient)
                                        <option value="{{ $patient->id }}">{{ $patient->name }}</option>
                                    @endforeach
                                </select>
                                @error('pataint_id')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col">
                                <label for="pn">Doctor Name</label>
                                <select name="doctor_id" id="doctor_id" class="form-control" required>
                                    <option value="">Select Doctor Name</option>
                                    @foreach($doctorList as $doctor)
                                        <option value="{{ $doctor->id }}">{{ $doctor->name }} ({{ $doctor->Specialist->name }})</option>
                                    @endforeach
                                </select>
                                @error('doctor_id')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col">
                                <label for="rn">Reference No</label>
                                <select name="reference_id" id="reference_id" class="form-control">
                                    <option value="">Select reference no</option>
                                    @foreach($referenceList as $reference)
                                        <option value="{{ $reference->id }}">{{ $reference->name }}</option>
                                    @endforeach
                                </select>
                                @error('reference_id')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col">
                                <label for="date">Invoice Date</label>
                                <input type="date" name="ic_date" id="ic_date" class="form-control">
                                @error('ic_date')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col">
                                <label for="remark">Remark</label>
                                <input type="text" name="remark" id="remark" class="form-control">
                                @error('remark')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>


                        <div class=" py-3">
                            <div class="d-flex flex-row">
                                <div class="col-md-10">

                                </div>
                                <div class="col-md-2" style="margin-left: 65px;">
                                    <a class="btn btn-success btn-sm " onclick="handleItem()">Add Item</a>
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTabledd" width="100%" cellspacing="0">
                                <thead>
                                <tr>
                                    <th width="25%">Name</th>
                                    <th width="15%">Mobile No</th>
                                    <th width="25%">Address</th>
                                    <th width="15%">Comission(%)</th>
                                    <th width="20">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                {{--                    @foreach($referenceList as $reference)--}}
                                {{--                        <tr>--}}
                                {{--                            <td>{{ $reference->name }}</td>--}}
                                {{--                            <td>{{ $reference->mobile_no }}</td>--}}
                                {{--                            <td>{{ $reference->address }}</td>--}}
                                {{--                            <td>{{ $reference->comission }}</td>--}}
                                {{--                            <td>--}}
                                {{--                                <a href="{{route('references.edit',$reference->id)}}" class="btn btn-primary btn-sm">Edit</a>--}}
                                {{--                                <button class="btn btn-danger btn-sm" onclick="handleDelete({{ $reference->id }})">Delete</button>--}}
                                {{--                            </td>--}}
                                {{--                        </tr>--}}
                                {{--                    @endforeach--}}

                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex flex-row mb-3">
                            <div class="col-10 p-2"></div>
                            <div class="col-2 p-2">
                                <a href="{{route('references.index')}}" class="btn btn-danger btn-sm">Cancel</a>
                                <button type="submit" class="btn btn-success btn-sm">@if(isset($referenceInfo)) Update @else Save @endif</button>
                            </div>
                        </div>
                    </form>



                    <!-- Modal -->
{{--                    <form action="" method="POST" id="deleteForm">--}}
{{--                        @csrf--}}
                        <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                            <div class="modal-dialog" style="margin-top: 90px;">
                                <div class="modal-content" style="width: 500px;">
                                        <div class="modal-body">
                                            <div class="row mb-2">
                                                <div class="col">
                                                    <input type="hidden" name="csrf-token" id="csrf-token" value="{{ csrf_token() }}">
                                                    <label for="pn">Item Name</label>
                                                    <select name="service_id" id="service_id" class="form-control" onchange="getProductDetails()" required>
                                                        <option value="">Select a service</option>
                                                        @foreach($serviceList as $service)
                                                            <option value="{{ $service->id }}">{{ $service->name }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('service_id')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col">
                                                    <label for="price">Price</label>
                                                    <input type="text" name="price" id="price" class="form-control" placeholder="0" readonly>
                                                    @error('price')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>

                                                <div class="col">
                                                    <label for="quantity">Quantity</label>
                                                    <input type="number" name="quantity" id="quantity" class="form-control" placeholder="0" onkeyup="calculatePrice()">
                                                    @error('quantity')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col">
                                                    <label for="total">Total</label>
                                                    <input type="text" name="total" id="total" class="form-control" placeholder="0" readonly>
                                                    @error('total')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger btn-sm cancel-button" data-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-success btn-sm save-data">Save</button>
                                    </div>
                                </div>
                            </div>
                        </div>
{{--                    </form>--}}




                </div>
            </div>
        </div>
    </div>

    <script>
        function handleItem(){
            $('#deleteModal').modal('show')
        }


        function getProductDetails(){
            var service_id = $("#service_id").val();

            $.ajax({
                type:"GET",
                url:"{{url('getServiceInfo')}}/"+service_id,
                success: function(data) {
                    $('#price').val(data.price);
                    $('#quantity').val(1);
                    $('#total').val(data.price);
                }
            });
        }

        function calculatePrice(){
            var price = $("#price").val();
            var quantity = $("#quantity").val();
            var totalAmount = price * quantity;
            $('#total').val(totalAmount);
        }

        function formReset(){
            $('#service_id').val('');
            $('#price').val(0);
            $('#quantity').val(0);
            $('#total').val(0);
        }


        $(".save-data").click(function(event){
            event.preventDefault();

            let _token   = $("#csrf-token").val();
            let service_id   = $("#service_id").val();
            let price   = $("#price").val();
            let quantity   = $("#quantity").val();
            let total   = $("#total").val();

            $.ajax({
                url: "{{url('postServiceInfo')}}",
                type:"POST",
                data:{
                    service_id:service_id,
                    price:price,
                    quantity:quantity,
                    total:total,
                    _token: _token
                },
                success:function(response){
                    formReset();
                    $('.cancel-button').click();
                },
            });
        });


    </script>


@endsection
