@include('admin.__partial.header')

            <!-- Begin Page Content -->
            <div class="container-fluid">
                @if(session()->has('success'))
                    <div class="alert alert-success">
                        {{ session()->get('success') }}
                    </div>
                @endif
                @yield("content")
            </div>
            <!-- /.container-fluid -->
@include('admin.__partial.footer')
