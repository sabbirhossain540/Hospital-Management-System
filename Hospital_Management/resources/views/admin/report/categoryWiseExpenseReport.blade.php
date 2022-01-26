@extends('admin.layouts')

@section("content")

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="d-flex flex-row">
                <div class="col-md-10">
                    <h6 class="m-0 font-weight-bold text-primary">Category Wise Expense Report</h6>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="d-flex flex-nowrap bd-highlight mb-3">
                <div class="order-1 p-2 bd-highlight">
                    <select name="cat_id" id="cat_id" class="form-control">
                        <option value="">Select Exp. Category</option>
                        @foreach($expCategoryList as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
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
                        <th width="10%">Exp. Date</th>
                        <th width="15%">Exp. No</th>
                        <th width="10%">Exp. Title</th>
                        <th width="10%">Comments</th>
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
            let cat_id = $("#cat_id").val();

            if(fromDate <= toDate && cat_id != null){
                $(".generate-report").prop('disabled', false);
                $(".generate-pdf-report").prop('disabled', false);
            }else{
                $(".generate-report").prop('disabled', true);
                $(".generate-pdf-report").prop('disabled', true);
            }
        });

        $(".generate-pdf-report").click(function(event){
            let cat_id = $("#cat_id").val();
            let fromDate   = $("#fromDate").val();
            let toDate   = $("#toDate").val();
            window.location.href = "{{ url('generatePdfCategoryWiseExpenseReport')}}/"+fromDate+"/"+toDate+"/"+cat_id;
        });

        $(".generate-report").click(function(event){
            $('.rowTrack').remove();
            let cat_id = $("#cat_id").val();
            let fromDate   = $("#fromDate").val();
            let toDate   = $("#toDate").val();
            $( "#myTable" ).show();

            $.ajax({
                type:"GET",
                url:"{{url('generateCategoryWiseExpenseReport')}}/"+fromDate+"/"+toDate+"/"+cat_id,
                success: function(data) {
                   // console.log(data);
                    let totalAmount = 0;

                    for (var i=0; i<data.length; i++) {
                        let expNo = data[i].get_expense_no['exp_no'];
                        let serial_no = i+1;
                        totalAmount = totalAmount + parseInt(data[i].amount);
                        let formatedDate = formatDate(data[i].created_at);
                        let row = $('<tr class="rowTrack"><td>' + serial_no + '</td><td>' + formatedDate + '</td><td>' + expNo + '</td><td>' + data[i].exp_title + '</td><td>' + data[i].comments + '</td><td>' + data[i].amount + '</td></tr>');
                        $('#myTable').append(row);
                    }

                    let finalRow = $('<tr class="rowTrack" style="font-weight: bold;"><td colspan="5" style="text-align: right;">Total</td><td>'  + totalAmount + '</td></tr>');
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
