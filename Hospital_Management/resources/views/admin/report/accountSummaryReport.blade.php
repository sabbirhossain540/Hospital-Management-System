@extends('admin.layouts')

@section("content")

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="d-flex flex-row">
                <div class="col-md-10">
                    <h6 class="m-0 font-weight-bold text-primary">Account Summary Report</h6>
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
                        <th width="10%">SN</th>
                        <th width="30%">Total Income</th>
                        <th width="30%">Total Expense</th>
                        <th width="30%">Profit</th>
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
            window.location.href = "{{ url('generatePdfAccountSummaryReport')}}/"+fromDate+"/"+toDate;
        });

        $(".generate-report").click(function(event){
            $('.rowTrack').remove();
            let fromDate   = $("#fromDate").val();
            let toDate   = $("#toDate").val();
            $( "#myTable" ).show();

            $.ajax({
                type:"GET",
                url:"{{url('generateAccountSummaryReport')}}/"+fromDate+"/"+toDate,
                success: function(data) {
                    console.log(data[0]);
                    let profit = parseInt(data[0]) - parseInt(data[1]);
                    let row = $('<tr class="rowTrack"><td>1</td><td>' + data[0] + '</td><td>' + data[1] + '</td><td>' + profit + '</td></tr>');
                    $('#myTable').append(row);

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
