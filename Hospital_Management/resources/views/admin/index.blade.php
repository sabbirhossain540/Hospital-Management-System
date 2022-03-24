@extends('admin.layouts')

@section("cartScript")
    <script>
        Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
        Chart.defaults.global.defaultFontColor = '#858796';

        // Pie Chart Example
        var ctx = document.getElementById("myPieChart");
        var myPieChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ["Income", "Expense"],
                datasets: [{
                    data: [{{ floor($salesAmount) }}, {{ floor($expenseAmount)  }}],
                    backgroundColor: ['#1CC88A', '#E74A3B'],
                    hoverBackgroundColor: ['#1CC88A', '#E74A3B'],
                    hoverBorderColor: "rgba(234, 236, 244, 1)",
                }],
            },
            options: {
                maintainAspectRatio: false,
                tooltips: {
                    backgroundColor: "rgb(255,255,255)",
                    bodyFontColor: "#858796",
                    borderColor: '#dddfeb',
                    borderWidth: 1,
                    xPadding: 15,
                    yPadding: 15,
                    displayColors: false,
                    caretPadding: 10,
                },
                legend: {
                    display: false
                },
                cutoutPercentage: 0,
            },
        });


        var ctx1 = document.getElementById("myPieChartForLeatest");
        var myPieChartForLeatest = new Chart(ctx1, {
            type: 'doughnut',
            data: {
                labels: ["Income", "Expense"],
                datasets: [{
                    data: [{{ floor($leatestSalesAmount) }}, {{ floor($leatestExpenseAmount)  }}],
                    backgroundColor: ['#1CC88A', '#E74A3B'],
                    hoverBackgroundColor: ['#1CC88A', '#E74A3B'],
                    hoverBorderColor: "rgba(234, 236, 244, 1)",
                }],
            },
            options: {
                maintainAspectRatio: false,
                tooltips: {
                    backgroundColor: "rgb(255,255,255)",
                    bodyFontColor: "#858796",
                    borderColor: '#dddfeb',
                    borderWidth: 1,
                    xPadding: 15,
                    yPadding: 15,
                    displayColors: false,
                    caretPadding: 10,
                },
                legend: {
                    display: false
                },
                cutoutPercentage: 70,
            },
        });


    </script>

@endsection

@section("content")
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
{{--        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i--}}
{{--                class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>--}}
    </div>

    <!-- Content Row -->
    <div class="row">
        @if(Auth::user()->role == "admin")
            <div class="col-xl-2 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Last 30 Days Sales</div>
                                <div class="h7 mb-0 font-weight-bold text-gray-800">${{ floor($leatestSalesAmount) }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-file-invoice-dollar fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-2 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Total Sales</div>
                            <div class="h7 mb-0 font-weight-bold text-gray-800">${{ floor($salesAmount) }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-file-invoice-dollar fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Earnings (Monthly) Card Example -->
            @if(Auth::user()->role == "admin")
                <div class="col-xl-2 col-md-6 mb-4">
            @else
                <div class="col-xl-3 col-md-6 mb-4">
            @endif
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">
                                    Last 30 Days Invoice</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $InvoiceThityDays }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-file-alt fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if(Auth::user()->role == "admin")
                <div class="col-xl-2 col-md-6 mb-4">
            @else
                 <div class="col-xl-3 col-md-6 mb-4">
             @endif
                <div class="card border-left-dark shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">
                                    Total Invoice</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalInvoice }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-file-alt fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        <!-- Earnings (Monthly) Card Example -->
        @if(Auth::user()->role == "admin")
           <div class="col-xl-2 col-md-6 mb-4">
        @else
            <div class="col-xl-3 col-md-6 mb-4">
        @endif
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Total Doctors</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalDoctor }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-md fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Earnings (Monthly) Card Example -->
        @if(Auth::user()->role == "admin")
            <div class="col-xl-2 col-md-6 mb-4">
        @else
             <div class="col-xl-3 col-md-6 mb-4">
        @endif
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                Total Patients</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalPatient }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-procedures fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Earnings (Monthly) Card Example -->
        @if(Auth::user()->role == "admin")
           <div class="col-xl-2 col-md-6 mb-4">
        @else
            <div class="col-xl-3 col-md-6 mb-4">
        @endif
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Total Service</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalService }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-plane-departure fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        @if(Auth::user()->role == "admin")
        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-2 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Total Users</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalUser }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>


            <div class="col-xl-2 col-md-6 mb-4">
                <div class="card border-left-danger shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                    Last 30 Day Expense</div>
                                <div class="h7 mb-0 font-weight-bold text-gray-800">{{ $leatestExpenseAmount }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-donate fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-2 col-md-6 mb-4">
                <div class="card border-left-dark shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">
                                    Total Expense</div>
                                <div class="h7 mb-0 font-weight-bold text-gray-800">{{ $expenseAmount }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-donate fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            @if(Auth::user()->role == "admin")
                <div class="col-xl-2 col-md-6 mb-4">
            @else
                <div class="col-xl-3 col-md-6 mb-4">
            @endif
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                    Last 30 Days Exp. Voucher</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $expenseThityDays }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-file-invoice fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @if(Auth::user()->role == "admin")
               <div class="col-xl-2 col-md-6 mb-4">
            @else
                <div class="col-xl-3 col-md-6 mb-4">
            @endif
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    Expense Voucher</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalExpence }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-file-invoice fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>




    </div>

    <!-- Content Row -->

    <div class="row">

        <!-- Area Chart -->


    @if(Auth::user()->role == "admin")

        <!-- Pie Chart -->
        <div class="col-xl-12 col-lg-5">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div
                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Revenue Sources</h6>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                             aria-labelledby="dropdownMenuLink">
                            <a class="dropdown-item" href="{{ route('invoices.index') }}">Income List</a>
                            <a class="dropdown-item" href="{{ route('expenses.index') }}">Expense List</a>
                        </div>
                    </div>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <div class="d-flex bd-highlight">
                        <div class="col-xl-6 col-lg-6 col-md-6">
                            <div class="chart-pie pt-0 pb-2">
                                <p class="text-center mb-0 font-weight-normal mb-1">Last 30 days revenue statistic</p>
                                <canvas id="myPieChartForLeatest"></canvas>
                            </div>
                            <div class="mt-4 text-center small">
                                        <span class="mr-2">
                                            <i class="fas fa-circle text-success"></i> Income
                                        </span>
                                <span class="mr-2">
                                            <i class="fas fa-circle text-danger"></i> Expense
                                        </span>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6">
                            <div class="chart-pie pt-4 pb-2 mt-2">
                                <p class="text-center mb-0 font-weight-normal mb-1">Total revenue statistic</p>
                                <canvas id="myPieChart"></canvas>
                            </div>
                            <div class="mt-4 text-center small">
                                        <span class="mr-2">
                                            <i class="fas fa-circle text-success"></i> Income
                                        </span>
                                <span class="mr-2">
                                            <i class="fas fa-circle text-danger"></i> Expense
                                        </span>
                            </div>
                        </div>
                    </div>

                </div>
            </div>


        </div>


    </div>

    @endif

    @if(Auth::user()->role != "admin")
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div
                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Sales Overview</h6>

                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                             aria-labelledby="dropdownMenuLink">
                            <a class="dropdown-item" href="{{ route('invoices.index') }}">Invoice List</a>
                        </div>
                    </div>

                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">Date</th>
                            <th scope="col">IV No</th>
                            <th scope="col">Patient Name</th>
                            <th scope="col">Doctor Name</th>
                            <th scope="col">Amount</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($invoiceMaster as $invoice)
                            <tr>
                                <td>{{ $invoice->ic_date }}</td>
                                <td>{{ $invoice->iv_no }}</td>
                                <td>@if(!empty($invoice->getPatient->name)){{ $invoice->getPatient->name }}@endif</td>
                                <td>@if(!empty($invoice->getDoctor->name)){{ $invoice->getDoctor->name }}@endif</td>
                                <td>{{ $invoice->totalAmount }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{--                    <div class="chart-area">--}}
                    {{--                        <canvas id="myAreaChart"></canvas>--}}
                    {{--                    </div>--}}
                </div>
            </div>
        </div>
        <!-- Pie Chart -->
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div
                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Patient Overview</h6>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                             aria-labelledby="dropdownMenuLink">
                            <a class="dropdown-item" href="{{ route('patientList.index') }}">Patient List</a>
                        </div>
                    </div>

                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">Name</th>
                            <th scope="col">Mobile No</th>
                            <th scope="col">view</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($patientList as $patient)
                            <tr>
                                <td>{{ $patient->name }}</td>
                                <td>{{ $patient->mobile_no }}</td>
                                <td><a href="{{route('patientList.show',$patient->id)}}" class="btn btn-outline-dark btn-sm"><i class="fas fa-eye"></i></a></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    @endif



@endsection
