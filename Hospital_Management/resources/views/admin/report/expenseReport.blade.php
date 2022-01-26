@extends('admin.layouts')

@section("content")

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="d-flex flex-row">
                <div class="col-md-10">
                    <h6 class="m-0 font-weight-bold text-primary">Expense Report</h6>
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
                        <th width="15%">Expense Date</th>
                        <th width="20%">Exp. No</th>
                        <th width="20%">Exp. Title</th>
                        <th width="15%">Exp. Category</th>
                        <th width="15%">Comments</th>
                        <th width="10%">Amount</th>
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
            window.location.href = "{{ url('generatePdfExpenseReport')}}/"+fromDate+"/"+toDate;
        });

        $(".generate-report").click(function(event){
            $('.rowTrack').remove();
            let fromDate   = $("#fromDate").val();
            let toDate   = $("#toDate").val();
            $( "#myTable" ).show();

            $.ajax({
                type:"GET",
                url:"{{url('generateExpenseReport')}}/"+fromDate+"/"+toDate,
                success: function(data) {
                    console.log(data);
                    let totalAmount = 0;
                    let totalItem = 0;
                    for (var i=0; i<data.length; i++) {
                        let expTitle = data[i].exp_title;
                        let expCategory = data[i].get_exp_category_name['name'];
                        let expNo = data[i].get_expense_no['exp_no'];
                        console.log(expNo);
                        let serial_no = i+1;
                        totalAmount = totalAmount + parseInt(data[i].amount);
                        let formatedDate = formatDate(data[i].created_at);
                        let row = $('<tr class="rowTrack"><td>' + serial_no + '</td><td>' + formatedDate + '</td><td>' + expNo + '</td><td>' + expTitle + '</td><td>' + expCategory + '</td><td>' + data[i].comments + '</td><td>' + data[i].amount + '</td></tr>');
                        $('#myTable').append(row);
                        totalItem++;
                    }

                    let finalRow = $('<tr class="rowTrack" style="font-weight: bold;"><td colspan="3"></td><td style="text-align: center;">Total Item</td><td>'+ totalItem +'</td><td style="text-align: right;">Total Amount</td><td>' + totalAmount + '</td></tr>');
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
