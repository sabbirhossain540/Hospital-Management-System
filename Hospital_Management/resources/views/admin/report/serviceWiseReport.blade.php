@extends('admin.layouts')

@section("content")

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="d-flex flex-row">
                <div class="col-md-10">
                    <h6 class="m-0 font-weight-bold text-primary">Service Wise Sales Report</h6>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="d-flex flex-nowrap bd-highlight mb-3">
                <div class="order-1 p-2 bd-highlight">
                    <select name="service_id" id="service_id" class="form-control">
                        <option value="">Select a service</option>
                        @foreach($serviceList as $service)
                            <option value="{{ $service->id }}">{{ $service->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="order-2 p-2 bd-highlight">
                    <input type="text" class="form-control disableChecker" name="fromDate" id="fromDate" placeholder="From Date">
                </div>
                <div class="order-3 p-2 bd-highlight">
                    <input type="text" class="form-control disableChecker" name="toDate" id="toDate" placeholder="To Date">
                </div>
                <div class="order-4 p-2 bd-highlight">
                    <button type="submit" class="btn btn-success generate-report" disabled>Generate Report</button>
{{--                    <button type="submit" class="btn btn-info print-report">Print Report</button>--}}
                    <button type="submit" class="btn btn-warning generate-pdf-report" disabled>Generate PDF</button>
                </div>
            </div>


            <div class="table-responsive">
                <table class="table table-bordered" id="myTable" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th width="5%">SN</th>
                        <th width="10%">Sales Date</th>
                        <th width="15%">Ref. Doctor</th>
                        <th width="10%">Price</th>
                        <th width="10%">Quantity</th>
                        <th width="10%">Sub Total</th>
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
            $( "#myTable" ).hide();
            $( ".print-report" ).hide();
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
            let service_id = $("#service_id").val();

            if(fromDate <= toDate && service_id != null){
                $(".generate-report").prop('disabled', false);
                $(".generate-pdf-report").prop('disabled', false);
            }else{
                $(".generate-report").prop('disabled', true);
                $(".generate-pdf-report").prop('disabled', true);
            }
        });

        $(".generate-pdf-report").click(function(event){
            let service_id = $("#service_id").val();
            let fromDate   = $("#fromDate").val();
            let toDate   = $("#toDate").val();
            window.location.href = "{{ url('generatePdfServiceWiseSalesReport')}}/"+fromDate+"/"+toDate+"/"+service_id;
        });

        $(".generate-report").click(function(event){
            $('.rowTrack').remove();
            let service_id = $("#service_id").val();
            let fromDate   = $("#fromDate").val();
            let toDate   = $("#toDate").val();
            $( "#myTable" ).show();

            $.ajax({
                type:"GET",
                url:"{{url('generateServiceWiseSalesReport')}}/"+fromDate+"/"+toDate+"/"+service_id,
                success: function(data) {
                    console.log(data);

                    let totalAmount = 0;
                    let totalQuantity = 0;
                    let totalSubTotal = 0;
                    let totalDiscount = 0;
                    for (var i=0; i<data.length; i++) {
                        let doctorName = data[i].get_invoice_info.get_doctor['name'];
                        let serviceName = data[i].get_service_name['name'];
                        let serial_no = i+1;

                        totalQuantity = totalQuantity + parseInt(data[i].quantity);
                        totalSubTotal = totalSubTotal + parseInt(data[i].subtotal);
                        let discountAmount = parseInt(data[i].subtotal) * parseInt(data[i].discount) / 100;
                        totalDiscount = totalDiscount + discountAmount;
                        let tot = parseInt(data[i].subtotal) - totalDiscount;

                        totalAmount = totalAmount + parseInt(data[i].total);
                        let formatedDate = formatDate(data[i].created_at);
                        let row = $('<tr class="rowTrack"><td>' + serial_no + '</td><td>' + formatedDate + '</td><td>' + doctorName + '</td><td>' + data[i].price + '</td><td>' + data[i].quantity + '</td><td>' + data[i].subtotal + '</td><td>' + discountAmount +'('+data[i].discount+'%)' + '</td><td>' + data[i].total + '</td></tr>');
                        $('#myTable').append(row);
                    }

                    let finalRow = $('<tr class="rowTrack" style="font-weight: bold;"><td colspan="3"></td><td style="text-align: right;">Total</td><td>' + totalQuantity + '</td><td>' + totalSubTotal + '</td><td>' + totalDiscount + '</td><td>' + totalAmount + '</td></tr>');
                    $('#myTable').append(finalRow);

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
