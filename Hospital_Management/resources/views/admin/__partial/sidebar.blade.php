<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center mb-4 mt-4" href="{{ route('home') }}">
        <img src="{{ asset('img/logo.webp') }}" class="img-fluid rounded-circle" alt="logo" width="90" height="90">
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="{{ route('home') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Interface
    </div>

    <!-- Nav Item - Pages Collapse Menu -->
    @if(Auth::user()->role == "admin")
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
           aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-cog"></i>
            <span>Basic Configuration</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{ route('medicalCollege.index') }}">Medical College Name</a>
                <a class="collapse-item" href="{{ route('educationalQualification.index') }}">Educational Qualification</a>
                <a class="collapse-item" href="{{ route('specialistArea.index') }}">Specialist Area</a>
                <a class="collapse-item" href="{{ route('expenseCategory.index') }}">Expense Category</a>
            </div>
        </div>
    </li>

    <li class="nav-item {{ request()->is('userList*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('userList') }}">
            <i class="fas fa-users"></i>
            <span>User List</span></a>
    </li>
    <li class="nav-item {{ request()->is('doctorList*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('doctorList.index') }}">
            <i class="fas fa-users"></i>
            <span>Doctor List</span></a>
    </li>

    @endif

    <li class="nav-item {{ request()->is('patientList*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('patientList.index') }}">
            <i class="fas fa-users"></i>
            <span>Patient List</span></a>
    </li>

    @if(Auth::user()->role == "admin")
    <li class="nav-item {{ request()->is('services*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('services.index') }}">
            <i class="fab fa-servicestack"></i>
            <span>Service List</span></a>
    </li>
    @endif

    @if(Auth::user()->role == "admin")
    <li class="nav-item {{ request()->is('references*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('references.index') }}">
            <i class="fas fa-hands-helping"></i>
            <span>Reference List</span></a>
    </li>

    @endif
    <li class="nav-item {{ request()->is('expenses*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('expenses.index') }}">
            <i class="fas fa-file-invoice"></i>
            <span>Expense List</span></a>
    </li>

    <li class="nav-item {{ request()->is('invoices*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('invoices.index') }}">
            <i class="fas fa-file-invoice-dollar"></i>
            <span>Sales Invoice</span></a>
    </li>

    <!-- Nav Item - Utilities Collapse Menu -->
    @if(Auth::user()->role == "admin")
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
           aria-expanded="true" aria-controls="collapseUtilities">
            <i class="fas fa-fw fa-wrench"></i>
            <span>Report</span>
        </a>
        <div id="collapseUtilities" class="collapse {{ request()->is('getSalesReport') ? 'active' : '' }}" aria-labelledby="headingUtilities"
             data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{ route('getSalesReport') }}">Sales report</a>
                <a class="collapse-item" href="{{ route('getServiceWiseSalesReport') }}">Service wise sales report</a>
                <a class="collapse-item" href="{{ route('getReferenceWiseReport') }}">Reference wise report</a>
                <a class="collapse-item" href="{{ route('getDoctorWiseReport') }}">Doctor Wise report</a>
                <a class="collapse-item" href="{{ route('getExpenseReport') }}">Expense report</a>
                <a class="collapse-item" href="{{ route('getCategoryWiseExpenseReport') }}">Category wise Exp. report</a>
{{--                <a class="collapse-item" href="{{ route('invoices.index') }}">Patient Wise report</a>--}}
            </div>
        </div>
    </li>
    @endif




{{--    <!-- Divider -->--}}
{{--    <hr class="sidebar-divider">--}}

{{--    <!-- Heading -->--}}
{{--    <div class="sidebar-heading">--}}
{{--        Addons--}}
{{--    </div>--}}

{{--    <!-- Nav Item - Pages Collapse Menu -->--}}
{{--    <li class="nav-item">--}}
{{--        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages"--}}
{{--           aria-expanded="true" aria-controls="collapsePages">--}}
{{--            <i class="fas fa-fw fa-folder"></i>--}}
{{--            <span>Pages</span>--}}
{{--        </a>--}}
{{--        <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">--}}
{{--            <div class="bg-white py-2 collapse-inner rounded">--}}
{{--                <h6 class="collapse-header">Login Screens:</h6>--}}
{{--                <a class="collapse-item" href="login.html">Login</a>--}}
{{--                <a class="collapse-item" href="register.html">Register</a>--}}
{{--                <a class="collapse-item" href="forgot-password.html">Forgot Password</a>--}}
{{--                <div class="collapse-divider"></div>--}}
{{--                <h6 class="collapse-header">Other Pages:</h6>--}}
{{--                <a class="collapse-item" href="404.html">404 Page</a>--}}
{{--                <a class="collapse-item" href="blank.html">Blank Page</a>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </li>--}}

{{--    <!-- Nav Item - Charts -->--}}
{{--    <li class="nav-item">--}}
{{--        <a class="nav-link" href="charts.html">--}}
{{--            <i class="fas fa-fw fa-chart-area"></i>--}}
{{--            <span>Charts</span></a>--}}
{{--    </li>--}}

{{--    <!-- Nav Item - Tables -->--}}
{{--    <li class="nav-item">--}}
{{--        <a class="nav-link" href="tables.html">--}}
{{--            <i class="fas fa-fw fa-table"></i>--}}
{{--            <span>Tables</span></a>--}}
{{--    </li>--}}

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
