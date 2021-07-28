@extends('admin.layouts')

@section("content")
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

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
                    <input type="text" class="form-control" name="fromDate" id="fromDate" placeholder="From Date">
                </div>
                <div class="order-2 p-2 bd-highlight">
                    <input type="text" class="form-control" name="toDate" id="toDate" placeholder="To Date">
                </div>
                <div class="order-3 p-2 bd-highlight">
                    <button type="submit" class="btn btn-success generate-report">Generate Report</button>
                    <button type="submit" class="btn btn-info">Print Report</button>
                    <button type="submit" class="btn btn-warning">Generate PDF</button>
                </div>
            </div>


            <div class="table-responsive">
                <table class="table table-bordered" id="myTable" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th width="5%">SN</th>
                        <th width="10%">Sales Date</th>
                        <th width="25%">Service Name</th>
                        <th width="15%">Price</th>
                        <th width="10%">Quantity</th>
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
            flatpickr("#fromDate");
            flatpickr("#toDate");
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
                    console.log(data);

                    for (var i=0; i<data.length; i++) {
                        let serviceName = data[i].get_service_name['name'];
                        let formatedDate = formatDate(data[i].created_at);
                        let row = $('<tr class="rowTrack"><td>' + data[i].id + '</td><td>' + formatedDate + '</td><td>' + serviceName + '</td><td>' + data[i].price + '</td><td>' + data[i].quantity + '</td><td>' + data[i].total + '</td></tr>');
                        $('#myTable').append(row);
                    }
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
