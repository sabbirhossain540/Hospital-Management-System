@include('admin.__partial.header')

            <!-- Begin Page Content -->
            <div class="container-fluid">
                @if(session()->has('success'))
                    <div class="alert alert-success">
                        {{ session()->get('success') }}
                    </div>
                @endif

                    @if(session()->has('warning'))
                        <div class="alert alert-warning">
                            {{ session()->get('warning') }}
                        </div>
                    @endif
                @yield("content")
            </div>
            <!-- /.container-fluid -->
@include('admin.__partial.footer')
