@extends('admin.layouts')

@section("content")

    <script>
        $( document ).ready(function() {
            $("#dwAddress").hide();
            $("#dwNewPatientArea").hide();

            $("#flexCheckDefault").click(function(){
                if($("#flexCheckDefault").is( ":checked" ) == true){
                    $("#dwPatient").hide();
                    $("#dwAddress").show();
                    $("#dwNewPatientArea").show();
                }else{
                    $("#dwPatient").show();
                    $("#dwAddress").hide();
                    $("#dwNewPatientArea").hide();
                }
            });

            $(".js-example-responsive").select2({
                width: 'resolve'
            });
        });
    </script>

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
{{--                    <form method="POST" action="@if(isset($referenceInfo)) {{route('references.update',$referenceInfo->id)}} @else {{route('invoices.store')}} @endif" >--}}
{{--                        @csrf--}}
{{--                        @if(isset($referenceInfo))--}}
{{--                            @method('PUT')--}}
{{--                        @endif--}}
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="flexCheckDefault" id="patientStatusCheck" name="patientStatusCheck">
                                <label class="form-check-label" for="flexCheckDefault">
                                    <strong>New Patient</strong>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3" id="dwNewPatientArea">
                        <div class="col-md-6 mb-2">
                            <label for="remark">Patient Name</label>
                            <input type="text" name="name" id="name" class="form-control" placeholder="Enter patient fullname" value="{{ old('name') }}" required>
                        </div>

                        <div class="col-md-6 mb-2">
                            <label for="remark">Mobile No</label>
                            <input type="text" name="mobile_no" id="mobile_no" class="form-control" placeholder="Enter mobile No" value="{{ old('mobile_no') }}" required>
                        </div>

                        <div class="col-md-6 ">
                            <label for="gander">Gander</label>
                            <select name="gander" id="gander" class="form-control">
                                <option value="">Select Gender</option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="age">Age</label>
                            <input type="text" id="age" name="age" class="form-control" placeholder="Age">
                        </div>
                    </div>

                        <div class="row mb-3">
                            <div class="col-md-6" id="dwAddress">
                                <label for="address">Address</label>
                                <input type="text" id="address" name="address" class="form-control" placeholder="Address">
                            </div>

                            <div class="col-md-6" id="dwPatient">
                                <label for="pn">Patient Name</label><br>
                                <select name="pataint_id" id="pataint_id" class="form-control search-option" required>
                                    <option value="">Select Patient Name</option>
                                    @foreach($patientList as $patient)
                                        <option value="{{ $patient->id }}">{{ $patient->name }}</option>
                                    @endforeach
                                </select>
                                @error('pataint_id')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="pn">Doctor Name</label><br>
                                <select name="doctor_id" id="doctor_id" class="form-control search-option" required>
                                    <option value="">Select Doctor Name</option>
                                    @foreach($doctorList as $doctor)
                                        <option value="{{ $doctor->id }}">{{ $doctor->name }} (@if(!empty($doctor->Specialist->name)){{ $doctor->Specialist->name }}@endif)</option>
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
                                <select name="reference_id" id="reference_id" class="search-option form-control">
                                    <option value="">Select reference no</option>
                                    @foreach($referenceList as $reference)
                                        <option value="{{ $reference->id }}">{{ $reference->code }}</option>
                                    @endforeach
                                </select>
                                @error('reference_id')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col">
                                <label for="date">Invoice Date</label>
                                <input type="text" name="ic_date" id="ic_date" class="form-control flatPickerCustom" value="{{ date("Y-m-d") }}" placeholder="Invoice Date">
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
                            <table class="table table-bordered" id="myTable" width="100%" cellspacing="0">
                                <thead>
                                <tr>
                                    <th width="25%">Service Name</th>
                                    <th width="12%">Price</th>
                                    <th width="12%">Quantity</th>
                                    <th width="11%">Discount(%)</th>
                                    <th width="10%">Sub total</th>
                                    <th width="10%">Total</th>
                                    <th width="20">Action</th>
                                </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex flex-row mb-3">
                            <div class="col-10 p-2"></div>
                            <div class="col-2 p-2">
                                <a href="{{route('invoices.index')}}" class="btn btn-danger btn-sm">Cancel</a>
                                <button type="submit" class="btn btn-success btn-sm main-form-submit">@if(isset($referenceInfo)) Update @else Save @endif</button>
                            </div>
                        </div>
                    </form>



                    <!-- Modal -->
{{--                    <form action="" method="POST" id="deleteForm">--}}
{{--                        @csrf--}}
                        <div class="modal fade" id="serviceModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                            <div class="modal-dialog" style="margin-top: 90px;">
                                <div class="modal-content" style="width: 500px;">
                                        <div class="modal-body">
                                            <div class="row mb-2">
                                                <div class="col">
                                                    <input type="hidden" name="csrf-token" id="csrf-token" value="{{ csrf_token() }}">
                                                    <input type="hidden" name="id" id="id">


                                                    <label for="pn">Item Name</label>
                                                    <input type="hidden" name="service_name" id="service_name" class="form-control" readonly>

                                                    <select name="service_id" id="service_id"  class="js-example-responsive" style="width: 100%" onchange="getProductDetails()" required>
                                                        <option value="">Select a service</option>
                                                        @foreach($serviceList as $service)
                                                            <option value="{{ $service->id }}">{{ $service->name }}</option>
                                                        @endforeach
                                                    </select>

{{--                                                    <select name="service_id" id="service_id" class="js-example-responsive" onchange="getProductDetails()" required>--}}
{{--                                                        <option value="">Select a service</option>--}}
{{--                                                        @foreach($serviceList as $service)--}}
{{--                                                            <option value="{{ $service->id }}">{{ $service->name }}</option>--}}
{{--                                                        @endforeach--}}
{{--                                                    </select>--}}
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
                                                    <label for="discount">Discount(%)</label>
                                                    <input type="number" name="discount" id="discount" class="form-control" placeholder="0" onkeyup="calculatePrice()">
                                                    @error('discount')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>

                                                <div class="col">
                                                    <label for="total">Sub total</label>
                                                    <input type="text" name="subTotal" id="subTotal" class="form-control" placeholder="0" readonly>
                                                    @error('subtotal')
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
        $(".search-option").select2({
            tags: true
        });


        $(".search-option1").select2({
            tags: true
        });


        $( document ).ready(function() {
            //showDataOnGrid();
            flatpickr("#ic_date");
        });

        let arr = []
        $(".main-form-submit").click(function(event){
            event.preventDefault();
            let _token   = $("#csrf-token").val();
            let pataint_id   = $("#pataint_id").val();
            let doctor_id   = $("#doctor_id").val();
            let reference_id   = $("#reference_id").val();
            let ic_date   = $("#ic_date").val();
            let remark   = $("#remark").val();
            let paidAmount   = $("#paidAmount").val();
            let discountAmount   = $("#discountAmount").val();
            let dueAmount   = $("#dueAmount").val();
            let patientStatusCheck = 0;

            if($("#flexCheckDefault").is( ":checked" ) == true){
                patientStatusCheck   = 1;
            }

            let patientName   = $("#name").val();
            let mobile_no   = $("#mobile_no").val();
            let gander   = $("#gander").val();
            let age   = $("#age").val();
            let address   = $("#address").val();


            $.ajax({
                url: "{{route('invoices.store')}}",
                type:"POST",
                data:{
                    pataint_id:pataint_id,
                    doctor_id:doctor_id,
                    reference_id:reference_id,
                    ic_date:ic_date,
                    remark:remark,
                    paidAmount:paidAmount,
                    discountAmount:discountAmount,
                    dueAmount:dueAmount,
                    patientStatusCheck:patientStatusCheck,
                    patientName:patientName,
                    mobile_no:mobile_no,
                    gander:gander,
                    age:age,
                    address:address,
                    invoice_details: arr,
                    _token: _token
                },
                success:function(response){
                    Swal.fire({
                        title: 'Invoice Created Successfully',
                        confirmButtonText: `OK`,
                    }).then((result) => {
                        window.location.href = "{{ route('invoices.index')}}";
                    });
                },
            });
        });

        let serviceDiscountAmount = 0;

        function showDataOnGrid(){

            let totalSubTotal = 0;
            let totalDiscountAmount = 0;
            let totalPayble = 0;
            for (var i=0; i<arr.length; i++) {
                totalSubTotal = totalSubTotal + parseInt(arr[i].subTotal);
                var discounted_price = (parseInt(arr[i].subTotal) * parseInt(arr[i].discount) / 100);
                totalDiscountAmount = totalDiscountAmount + discounted_price;
                totalPayble = totalPayble + parseInt(arr[i].total);
                var row = $('<tr class="rowTrack"><td>' + arr[i].service_name+ '</td><td>' + arr[i].price + '</td><td>' + arr[i].quantity + '</td><td>' + arr[i].discount + '</td><td>' + arr[i].subTotal + '</td><td>' + Math.floor(arr[i].total) + '</td><td><button class="btn btn-outline-danger btn-sm" onclick="handleDelete(' + arr[i].id + ')"><i class="fas fa-trash-alt"></i></button></td></tr>');
                //var row = $('<tr class="rowTrack"><td>' + arr[i].service_name+ '</td><td>' + arr[i].price + '</td><td>' + arr[i].quantity + '</td><td>' + arr[i].total + '</td><td><button class="btn btn-outline-info btn-sm" onclick="handleEdit(' + arr[i].id + ')"><i class="far fa-edit"></i></button> <button class="btn btn-outline-danger btn-sm" onclick="handleDelete(' + arr[i].id + ')"><i class="fas fa-trash-alt"></i></button></td></tr>');
                $('#myTable').append(row);
            }

            let rose = $('<tr class="rowTrack"><td class="text-right" colspan="4">Subtotal <br> +VAT TK, <br> <p style="margin-top: 5px; margin-bottom: -15px;">-Total Discount TK</p> <br> Payble TK. <br> Paid Amount <br> <p style="margin-top: 9px; margin-bottom: -15px;">General Discount</p>  <br> Due Amount</td>' +
                '<td colspan="2" class="text-center">'+totalSubTotal+'<br>0 <br>'+'<input type="number" name="totalDiscountAmount" id="totalDiscountAmount" readonly style="width: 80px;text-align: center;border-radius: 10px;outline: none;">'+'<br>'+'<input type="number" name="totalPayble" id="totalPayble" readonly style="width: 80px;text-align: center;border-radius: 10px;outline: none;">'+'<br> <input type="number" name="paidAmount" id="paidAmount" onkeyup="calculatePaidAmount('+totalPayble+')" style="width: 80px;text-align: center;border-radius: 10px;outline: none;"><br> <input type="number" name="discountAmount" id="discountAmount" onkeyup="calculatePaidAmount('+totalPayble+')" style="width: 80px;text-align: center;border-radius: 10px;outline: none;"> <br><input type="number" name="dueAmount" id="dueAmount" readonly style="width: 80px;text-align: center;border-radius: 10px;outline: none;"></td></tr>');
            $('#myTable').append(rose);
            $('#paidAmount').val(0);
            $('#discountAmount').val(0);
            $('#dueAmount').val(totalPayble);
            $('#totalPayble').val(Math.floor(totalPayble));
            $('#totalDiscountAmount').val(Math.floor(totalDiscountAmount));
            serviceDiscountAmount = totalDiscountAmount;
        }

        function calculatePaidAmount(payble){

            let paidAmount = $("#paidAmount").val();
            let discountAmount = $("#discountAmount").val();

            if(paidAmount == ''){
                $('#paidAmount').val(0);
            }

            if(discountAmount == ''){
                $('#discountAmount').val(0);
            }

            let remainingAmount = parseInt(payble) - parseInt(paidAmount);
            remainingAmount = parseInt(remainingAmount) - parseInt(discountAmount);

            let discountCalculation = parseInt(discountAmount) + parseInt(serviceDiscountAmount);
             $('#dueAmount').val(remainingAmount);
             $('#totalDiscountAmount').val(discountCalculation);

            if(paidAmount == ''){
                $('#dueAmount').val(payble);
            }

        }


        function handleDelete(id){
            $('.rowTrack').remove();
            arr = arr.filter(item => item.id != id);
            showDataOnGrid();
        }
        function handleEdit(id){
            $.ajax({
                type:"GET",
                url:"{{url('getTempServiceForEdit')}}/"+id,
                success: function(data) {
                    $('#serviceModal').modal('show')
                    $('#id').val(data.id);
                    $('#service_id').val(data.service_id);
                    $('#price').val(data.price);
                    $('#quantity').val(data.quantity);
                    $('#total').val(data.total);
                }
            });
        }
        function handleItem(){
            $('#serviceModal').modal('show')
        }


        function getProductDetails(){
            var service_id = $("#service_id").val();
            $.ajax({
                type:"GET",
                url:"{{url('getServiceInfo')}}/"+service_id,
                success: function(data) {
                    console.log(data);
                    $('#price').val(data.price);
                    $('#service_name').val(data.name);
                    $('#quantity').val(1);
                    $('#total').val(data.price);
                    $('#subTotal').val(data.price);
                    $('#discount').val(0);
                    $('#id').val(data.id);
                }
            });
        }
        function calculatePrice(){
            var price = $("#price").val();
            var quantity = $("#quantity").val();
            var discount = $("#discount").val();
            var totalAmount = price * quantity;
            var discounted_price = totalAmount - (totalAmount * discount / 100)
            $('#subTotal').val(Math.floor(totalAmount));
            $('#total').val(Math.floor(discounted_price));
        }
        function formReset(){
            $('#service_id').val('');
            $('#price').val(0);
            $('#quantity').val(0);
            $('#total').val(0);
            $('#subTotal').val(0);
            $('#discount').val(0);
        }
        $(".save-data").click(function(event){
            event.preventDefault();
            $('.rowTrack').remove();
            let _token   = $("#csrf-token").val();
            let service_id   = $("#service_id").val();
            let price   = $("#price").val();
            let quantity   = $("#quantity").val();
            let subTotal   = $("#subTotal").val();
            let discount   = $("#discount").val();
            let total   = $("#total").val();
            let service_name   = $("#service_name").val();
            let id   = $("#id").val();
            let serviceData = {
                "id": id,
                "service_id": service_id,
                "price": price,
                "quantity": quantity,
                "discount": discount,
                "subTotal": subTotal,
                "total": total,
                "service_name":service_name
            }

            arr.push(serviceData);
            showDataOnGrid();
            formReset();
            $('.cancel-button').click();
        });

    </script>


@endsection
