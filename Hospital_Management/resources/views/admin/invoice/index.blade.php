@extends('admin.layouts')

@section("content")
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="d-flex flex-row">
                <div class="col-md-10">
                    <h6 class="m-0 font-weight-bold text-primary">Invoice List</h6>
                </div>
                <div class="col-md-2" style="margin-left: 40px;">
                    <a href="{{route('invoices.create')}}" class="btn btn-primary btn-sm pl-10"><i class="fas fa-plus"></i> Create Invoice</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th width="5%">SN</th>
                        <th width="10%" class="sorting_desc">Invoice No</th>
                        <th width="10%">Invoice Date</th>
                        <th width="10%">Patient Name</th>
                        <th width="10%">Doctor Name</th>
                        <th width="5%">Paid Amount</th>
                        <th width="10%">Dues</th>
                        @if(Auth::user()->role == "admin")
                        <th width="5%">Created By</th>
                        @endif
                        <th width="25%">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($invoiceList as $key=>$invoice)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>{{ $invoice->iv_no }}</td>
                            <td>{{ date_format($invoice->formated_ic_date,'d-m-y') }}</td>
                            <td>@if(!empty($invoice->getPatient->name)){{ $invoice->getPatient->name }}@endif</td>
                            <td>@if(!empty($invoice->getDoctor->name)){{ $invoice->getDoctor->name }}@endif</td>
                            <td>{{ $invoice->paidAmount }}</td>
                            <td>{{ $invoice->dueAmount }}</td>
                            @if(Auth::user()->role == "admin")
                            <td>@if(!empty($invoice->getCreatedUser['name'])){{ $invoice->getCreatedUser['name'] }}@endif</td>
                            @endif
                            <td>
                                @if($invoice->dueAmount > 0)
                                <button class="btn btn-success btn-sm" onclick="handlePayment({{ $invoice->id }})"><i class="far fa-money-bill-alt"></i></button>
                                @endif
                                <a href="{{route('invoices.show',$invoice->id)}}" class="btn btn-info btn-sm"><i class="fas fa-eye"></i></a>
                                <a target="_blank" class="btn btn-warning btn-sm" href="{{route('printInvoice', $invoice->id)}}"><i class="fas fa-print"></i></a>
                                <a href="{{route('invoices.edit',$invoice->id)}}" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>
                                <button class="btn btn-danger btn-sm" onclick="handleDelete({{ $invoice->id }})"><i class="fas fa-trash-alt"></i></button>
                            </td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <form action="" method="POST" id="deleteForm">
        @csrf
        <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4>Are you sure want to delete this Invoice?</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success btn-sm" data-dismiss="modal">No. Go back</button>
                        <button type="submit" class="btn btn-danger btn-sm">Yes. Delete</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <-- Payment Modal -->
    <!-- Modal -->
{{--    <form action="" method="POST" id="paymentForm">--}}
{{--        @csrf--}}
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Due Collection</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>

                            <div class="form-group">
                                <label for="price">Due Amount</label>
                                <input type="hidden" name="ivId" id="ivId">
                                <input type="number" class="form-control" name="dueAmount" id="dueAmount" readonly>
                            </div>
                            <div class="form-group">
                                <label for="price">Paid Amount</label>
                                <input type="number" class="form-control" name="duePaidAmount" id="duePaidAmount" onkeyup="calculateAmount()">
                            </div>
                            {{--                        <div class="form-group">--}}
                            {{--                            <label for="price">Discount</label>--}}
                            {{--                            <input type="number" class="form-control" name="dueDiscount" id="dueDiscount" onkeyup="calculateAmount()">--}}
                            {{--                        </div>--}}
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-sm btn-primary save-data">Save</button>
                        </div>
                        </form>

                </div>
            </div>
        </div>
{{--    </form>--}}

    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable({
                "order": [[ 0, "desc" ]]
            });
        });

        function handlePayment(id){
            $('#exampleModal').modal('show');

            $.ajax({
                type:"GET",
                url:"{{url('getInvoiceInfo')}}/"+id,
                success: function(data) {
                    $('#dueAmount').val(data.dueAmount);
                    $('#ivId').val(data.id);
                }
            });
        }

        $(".save-data").click(function(event){
            event.preventDefault();
            let ivId   = $("#ivId").val();
            let duePaidAmount   = $("#duePaidAmount").val();

            $.ajax({
                url: "{{url('saveDuePayment')}}",
                type:"POST",
                data:{
                    ivId:ivId,
                    duePaidAmount: duePaidAmount,
                    _token:"{{ csrf_token() }}"
                },
                success:function(response){
                    Swal.fire({
                        title: 'Payment Successfully Completed',
                        confirmButtonText: `OK`,
                    }).then((result) => {
                        window.location.href = "{{ route('invoices.index')}}";
                    });
                },
            });
        });



        function calculateAmount(){
            let dueAmount = $("#dueAmount").val();
            let paidAmount = $("#duePaidAmount").val();

            if(parseInt(paidAmount) > parseInt(dueAmount)){
                Swal.fire({
                    title: 'You can not enter paid amount greater than due amount',
                    confirmButtonText: `OK`,
                })
                $("#dueAmount").val($("#dueAmount").val());
                $("#duePaidAmount").val(0);
            }
        }

        function handleDelete(id){
            var form = document.getElementById('deleteForm')
            form.action = '/deleteInvoice/'+id
            $('#deleteModal').modal('show')
        }
    </script>
@endsection
