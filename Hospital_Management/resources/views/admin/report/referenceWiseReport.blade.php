@extends('admin.layouts')

@section("content")

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="d-flex flex-row">
                <div class="col-md-10">
                    <h6 class="m-0 font-weight-bold text-primary">Reference Wise Report</h6>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="d-flex flex-nowrap bd-highlight mb-3">
                <div class="order-1 p-2 bd-highlight">
                    <select name="reference_id" id="reference_id" class="form-control">
                        <option value="">Select a Reference</option>
                        @foreach($referenceList as $reference)
                            <option value="{{ $reference->id }}">{{ $reference->name }} ({{ $reference->code }})</option>
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
                        <th width="10%">Date</th>
                        <th width="10%">IV No</th>
                        <th width="15%">Patient Name</th>
                        <th width="15%">Doctor Name</th>
                        <th width="5%">Sub Total</th>
                        <th width="10%">Discount</th>
                        <th width="10%">Total</th>
                        <th width="10%">Comission(%)</th>
                        <th width="10%">Referal Amount</th>
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
            let reference_id = $("#reference_id").val();

            if(fromDate <= toDate && reference_id != null){
                $(".generate-report").prop('disabled', false);
                $(".generate-pdf-report").prop('disabled', false);
            }else{
                $(".generate-report").prop('disabled', true);
                $(".generate-pdf-report").prop('disabled', true);
            }
        });

        $(".generate-pdf-report").click(function(event){
            let reference_id = $("#reference_id").val();
            let fromDate   = $("#fromDate").val();
            let toDate   = $("#toDate").val();
            window.location.href = "{{ url('generatePdfReferenceWiseReport')}}/"+fromDate+"/"+toDate+"/"+reference_id;
        });

        $(".generate-report").click(function(event){
            $('.rowTrack').remove();
            let service_id = $("#reference_id").val();
            let fromDate   = $("#fromDate").val();
            let toDate   = $("#toDate").val();
            $( "#myTable" ).show();

            $.ajax({
                type:"GET",
                url:"{{url('generateReferenceWiseReport')}}/"+fromDate+"/"+toDate+"/"+service_id,
                success: function(data) {
                    console.log(data);
                    let totalAmount = 0;
                    let totalDiscount = 0;
                    let totalRefaralAmount = 0
                    let totalSubtotal = 0;
                    let referelCommission = 0;

                    for (var i=0; i<data.length; i++) {
                        let doctorName = data[i].get_doctor['name'];
                        let patientName = data[i].get_patient['name'];
                        let IVNO = data[i].iv_no;
                        let serial_no = i+1;

                        totalAmount = totalAmount + parseInt(data[i].total);
                        totalDiscount = totalDiscount + parseInt(data[i].discount);
                        totalRefaralAmount = totalRefaralAmount + parseInt(data[i].referalAmount);
                        totalSubtotal = totalSubtotal + parseInt(data[i].subtotal);
                        referelCommission = data[i].referalParcentage;

                        let formatedDate = formatDate(data[i].created_at);
                        let row = $('<tr class="rowTrack"><td>' + serial_no + '</td><td>' + formatedDate + '</td><td>' + IVNO + '</td><td>' + patientName + '</td><td>' + doctorName + '</td><td>' + data[i].subtotal + '</td><td>' + data[i].discount + '</td><td>' + data[i].total + '</td><td>' + data[i].referalParcentage + '</td><td>' + data[i].referalAmount + '</td></tr>');
                        $('#myTable').append(row);
                    }

                    let finalRow = $('<tr class="rowTrack" style="font-weight: bold;"><td colspan="4"></td><td style="text-align: right;">Total</td><td>' + totalSubtotal + '</td><td>' + totalDiscount + '</td><td>' + totalAmount + '</td><td>' + referelCommission + '</td><td>' + totalRefaralAmount + '</td></tr>');
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
