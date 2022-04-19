@extends('admin.layouts')

@section("content")

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="d-flex flex-row">
                <div class="col-md-10">
                    <h6 class="m-0 font-weight-bold text-primary">Doctor Wise Report</h6>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="d-flex flex-nowrap bd-highlight mb-3">
                <div class="order-1 p-2 bd-highlight" >
                    <select name="doctor_id" id="doctor_id" class="form-control" style="width: 150px;">
                        <option value="">Select a Doctor</option>
                        @foreach($doctorList as $doctor)
                            <option value="{{ $doctor->id }}">{{ $doctor->name }} @if(isset($doctor->Specialist->name))({{ $doctor->Specialist->name }})@endif</option>
                        @endforeach
                    </select>
                </div>
                <div class="order-2 p-2 bd-highlight">
                    <input type="text" class="form-control disableChecker" name="fromDate" id="fromDate" placeholder="From Date">
                </div>
                <div class="order-3 p-2 bd-highlight">
                    <input type="text" class="form-control disableChecker" name="toDate" id="toDate" placeholder="To Date">
                </div>
                <div class="order-3 p-2 bd-highlight">
                    <select name="reportType" id="reportType" class="form-control">
                        <option value="">Select report type</option>
                        <option value="sales">Sales</option>
                        <option value="invoice">Invoice</option>
                    </select>
                </div>
                <div class="order-4 p-2 bd-highlight">
                    <button type="submit" class="btn btn-success generate-report" disabled>Report</button>
{{--                    <button type="submit" class="btn btn-info print-report">Print</button>--}}
                    <button type="submit" class="btn btn-warning generate-pdf-report" disabled>PDF</button>
                </div>
            </div>


            <div class="table-responsive">
                <table class="table table-bordered forInvoice" id="myTableForInvoice" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="5%">SN</th>
                            <th width="10%">Date</th>
                            <th width="10%">IV No</th>
                            <th width="15%">Patient Name</th>
                            <th width="15%">Reference Name</th>
                            <th width="10%">Sub Total</th>
                            <th width="10%">Discount</th>
                            <th width="5%">Total</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>

                <table class="table table-bordered forSales" id="myTableForSales" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="5%">SN</th>
                            <th width="10%">Date</th>
                            <th width="15%">Service Name</th>
                            <th width="10%">Price</th>
                            <th width="10%">Quantity</th>
                            <th width="10%">Subtotal</th>
                            <th width="10%">Discount</th>
                            <th width="10%">Total</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>






    <script>
        $( document ).ready(function() {
            $( "#myTableForInvoice" ).hide();
            $( "#myTableForSales" ).hide();
            //$( ".print-report" ).hide();
            flatpickr("#fromDate");
            flatpickr("#toDate");
        });


        // $('.print-report').click(function(){
        //     window.print();
        //     return false;
        // });

        $(".disableChecker").change(function(event){
            let fromDate   = $("#fromDate").val();
            let toDate   = $("#toDate").val();
            let doctor_id = $("#doctor_id").val();

            if(fromDate <= toDate && doctor_id != null){
                $(".generate-report").prop('disabled', false);
                $(".generate-pdf-report").prop('disabled', false);
            }else{
                $(".generate-report").prop('disabled', true);
                $(".generate-pdf-report").prop('disabled', true);
            }
        });

        $(".generate-pdf-report").click(function(event){
            let doctor_id = $("#doctor_id").val();
            let fromDate   = $("#fromDate").val();
            let toDate   = $("#toDate").val();
            let type = $("#reportType").val();
            window.location.href = "{{ url('generatePdfDoctorWiseReport')}}/"+fromDate+"/"+toDate+"/"+doctor_id+"/"+type;
        });

        $(".generate-report").click(function(event){
            $('.rowTrack').remove();
            let doctor_id = $("#doctor_id").val();
            let fromDate   = $("#fromDate").val();
            let toDate   = $("#toDate").val();
            let type = $("#reportType").val();
            $( "#myTableForInvoice" ).hide();
            $( "#myTableForSales" ).hide();

            $.ajax({
                type:"GET",
                url:"{{url('generateDoctorWiseReport')}}/"+fromDate+"/"+toDate+"/"+doctor_id+"/"+type,
                success: function(data) {
                    console.log(data);
                    if(type == 'sales'){
                        $( "#myTableForSales" ).show();
                        let totalAmount = 0;
                        let totalQty = 0;
                        let totalSubTotal = 0;
                        let totalDiscount = 0

                        for (var i=0; i<data.length; i++) {
                            let serial_no = i+1;
                            let discountCalculate = parseInt(data[i].subtotal) * parseInt(data[i].discount) / 100;
                            totalAmount = totalAmount + parseInt(data[i].total);
                            totalDiscount = totalDiscount + discountCalculate;
                            totalQty = totalQty + parseInt(data[i].quantity);
                            totalSubTotal = totalSubTotal + parseInt(data[i].subtotal);

                            let serviceName = data[i].get_service_name['name'];

                            let formatedDate = formatDate(data[i].created_at);
                            let row = $('<tr class="rowTrack"><td>' + serial_no + '</td><td>' + formatedDate + '</td><td>' + serviceName + '</td><td>' + data[i].price + '</td><td>' + data[i].quantity + '</td><td>' + data[i].subtotal + '</td><td>' + discountCalculate + '</td><td>' + data[i].total + '</td></tr>');
                            $('#myTableForSales').append(row);
                        }
                        let finalRow = $('<tr class="rowTrack" style="font-weight: bold;"><td colspan="3"></td><td style="text-align: right;">Total</td><td>' + totalQty + '</td><td>' + totalSubTotal + '</td><td>' + totalDiscount + '</td><td>' + totalAmount + '</td></tr>');
                        $('#myTableForSales').append(finalRow);
                    }else{
                        $( "#myTableForInvoice" ).show();
                        let totalAmount = 0;
                        let totalDiscount = 0;
                        let totalRefaralAmount = 0
                        let totalSubtotal = 0;
                        let referelCommission = 0;

                        for (var i=0; i<data.length; i++) {

                            let referenceName = "";
                            if(data[i].get_reference != null){
                                referenceName = data[i].get_reference['name'];
                            }
                           // let referenceName = data[i].get_reference['name'];
                            let patientName = data[i].get_patient['name'];
                            let IVNO = data[i].iv_no;
                            let serial_no = i+1;

                            totalAmount = totalAmount + parseInt(data[i].total);
                            totalDiscount = totalDiscount + parseInt(data[i].discount);
                            totalRefaralAmount = totalRefaralAmount + parseInt(data[i].referalAmount);
                            totalSubtotal = totalSubtotal + parseInt(data[i].subtotal);
                            referelCommission = data[i].referalParcentage;

                            let formatedDate = formatDate(data[i].created_at);
                            let row = $('<tr class="rowTrack"><td>' + serial_no + '</td><td>' + formatedDate + '</td><td>' + IVNO + '</td><td>' + patientName + '</td><td>' + referenceName + '</td><td>' + data[i].subtotal + '</td><td>' + data[i].discount + '</td><td>' + data[i].total + '</td></tr>');
                            $('#myTableForInvoice').append(row);
                        }

                        let finalRow = $('<tr class="rowTrack" style="font-weight: bold;"><td colspan="4"></td><td style="text-align: right;">Total</td><td>' + totalSubtotal + '</td><td>' + totalDiscount + '</td><td>' + totalAmount + '</td></tr>');
                        $('#myTableForInvoice').append(finalRow);
                    }


                    $( ".print-report" ).show();


                }
            });
        });

        function formatDate(date) {
            var d = new Date(date),
                month = '' + (d.getMonth() + 1),
                day = '' + d.getDate(),
                year = d.getFullYear();

            if (month.length < 2)
                month = '0' + month;
            if (day.length < 2)
                day = '0' + day;
            return [day, month, year].join('-');
        }
    </script>
@endsection
