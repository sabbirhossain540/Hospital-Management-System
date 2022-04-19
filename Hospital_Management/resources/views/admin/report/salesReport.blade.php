@extends('admin.layouts')

@section("content")

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="d-flex flex-row">
                <div class="col-md-10">
                    <h6 class="m-0 font-weight-bold text-primary">Sales Report</h6>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="d-flex flex-nowrap bd-highlight mb-3">
                <div class="order-1 p-2 bd-highlight">
                    <input type="text" class="form-control disableChecker" name="fromDate" id="fromDate" placeholder="From Date">
                </div>
                <div class="order-2 p-2 bd-highlight">
                    <input type="text" class="form-control disableChecker" name="toDate" id="toDate" placeholder="To Date">
                </div>
                <div class="order-3 p-2 bd-highlight">
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
                        <th width="15%">Sales Date</th>
                        <th width="15%">IV No</th>
                        <th width="15%">Patient Name</th>
                        <th width="15%">Doctor Name</th>
                        <th width="10%">Reference Name</th>
                        <th width="5%">Sub Total</th>
                        <th width="5%">Service Discount</th>
                        <th width="5%">General Discount</th>
                        <th width="5%">Total</th>
                        <th width="5%">Due</th>
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

            if(fromDate <= toDate){
                $(".generate-report").prop('disabled', false);
                $(".generate-pdf-report").prop('disabled', false);
            }else{
                $(".generate-report").prop('disabled', true);
                $(".generate-pdf-report").prop('disabled', true);
            }
        });

        $(".generate-pdf-report").click(function(event){
            let fromDate   = $("#fromDate").val();
            let toDate   = $("#toDate").val();
            window.location.href = "{{ url('generatePdfSalesReport')}}/"+fromDate+"/"+toDate;
        });

        $(".generate-report").click(function(event){
            $('.rowTrack').remove();
            let fromDate   = $("#fromDate").val();
            let toDate   = $("#toDate").val();
            $( "#myTable" ).show();

            $.ajax({
                type:"GET",
                url:"{{url('generateSalesReport')}}/"+fromDate+"/"+toDate,
                success: function(data) {
                    //console.log(data);

                    let totalSubtotal = 0;
                    let totalServiceDiscount = 0;
                    let totalGeneralDiscount = 0;
                    let totalPaidAmount = 0;
                    let dueAmount = 0;

                    for (var i=0; i<data.length; i++) {
                        console.log(data[i]);
                        let subtotal = 0;
                        let discountCalculation = 0;
                        for(var j=0; j<data[i].invoice_details.length; j++){
                            subtotal = parseInt(subtotal)+parseInt(data[i].invoice_details[j]['price']);
                            discountCalculation = discountCalculation + parseInt(data[i].invoice_details[j]['subtotal']) * parseInt(data[i].invoice_details[j]['discount']) / 100;
                        }


                        let doctorName = "";
                        let patientName = data[i].get_patient['name'];

                        if(data[i].get_doctor != null){
                            doctorName = data[i].get_doctor['name'];
                        }

                        let refName = "";
                        if(data[i].get_reference != null){
                            refName = data[i].get_reference['name'];
                        }

                        let serial_no = i+1;
                        totalSubtotal = totalSubtotal + parseInt(subtotal);
                        totalServiceDiscount = totalServiceDiscount + parseInt(discountCalculation);
                        totalGeneralDiscount = totalGeneralDiscount + parseInt(data[i].discountAmount);
                        totalPaidAmount = totalPaidAmount + parseInt(data[i].paidAmount);
                        dueAmount = dueAmount + parseInt(data[i].dueAmount);

                        let formatedDate = formatDate(data[i].created_at);
                        let row = $('<tr class="rowTrack"><td>' + serial_no + '</td><td>' + formatedDate + '</td><td>' + data[i].iv_no + '</td><td>' + patientName + '</td><td>' + doctorName + '</td><td>' + refName + '</td><td>' + subtotal + '</td><td>' + Math.floor(discountCalculation) + '</td><td>' + data[i].discountAmount + '</td><td>' + data[i].paidAmount + '</td><td>' + data[i].dueAmount + '</td></tr>');
                        $('#myTable').append(row);
                    }

                    let finalRow = $('<tr class="rowTrack" style="font-weight: bold;"><td colspan="6" style="text-align: right;">Total</td><td>' + totalSubtotal + '</td><td>' + totalServiceDiscount + '</td><td>' + totalGeneralDiscount + '</td><td>' + totalPaidAmount + '</td><td>' + dueAmount  + '</td></tr>');
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
