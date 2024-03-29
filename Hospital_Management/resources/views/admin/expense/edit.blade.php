@extends('admin.layouts')

@section("content")

    <div class="row justify-content-md-center">
        <div class="col-md-10">
            <div class="card shadow mb-4">

                <div class="card-header py-3">
                    <div class="d-flex flex-row">
                        <div class="col-md-10">
                            <h6 class="m-0 font-weight-bold text-primary">Edit Expense</h6>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col">
                            <label for="date">Expense Date</label>
                            <input type="hidden" name="exp_id" id="exp_id" value="{{ $expenseList->id  }}">
                            <input type="text" name="exp_date" id="exp_date" class="form-control flatPickerCustom" value="@if($expenseList->exp_date){{ $expenseList->exp_date }} @else {{ date("Y-m-d") }}  @endif" placeholder="Invoice Date">
                            @error('exp_date')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col">
                            <label for="remark">Comments</label>
                            <input type="text" name="comments" id="comments" class="form-control" value="{{ $expenseList->comments }}">
                            @error('comments')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>






                    <div class=" py-3">
                        <div class="d-flex flex-row">
                            <div class="col-md-10">

                            </div>
                            <div class="col-md-2" style="margin-left: 10px;">
                                <a class="btn btn-success btn-sm " onclick="handleItem()"><i class="fas fa-plus"></i> Add Expense</a>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered" id="myTable" width="100%" cellspacing="0">
                            <thead>
                            <tr>
                                <th width="30%">Exp. Title</th>
                                <th width="25%">Exp. Category</th>
                                <th width="25%">Exp. Amount</th>
                                <th width="20">Action</th>
                            </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex flex-row mb-3">
                        <div class="col-10 p-2"></div>
                        <div class="col-2 p-2">
                            <a href="{{route('expenses.index')}}" class="btn btn-danger btn-sm">Cancel</a>
                            <button type="submit" class="btn btn-success btn-sm main-form-submit">Save</button>
                        </div>
                    </div>
                    </form>



                    <!-- Modal -->
                    <form action="" method="POST" id="deleteForm">
                        @csrf
                        <div class="modal fade" id="expDetailsModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                            <div class="modal-dialog" style="margin-top: 90px;">
                                <div class="modal-content" style="width: 500px;">
                                    <div class="modal-body">
                                        <div class="row mb-2">
                                            <div class="col">
                                                <input type="hidden" name="csrf-token" id="csrf-token" value="{{ csrf_token() }}">
                                                <input type="hidden" name="id" id="id">
                                                <label for="pn">Expense Details</label>
                                                <input type="hidden" name="expCategory_name" id="expCategory_name" class="form-control" readonly>
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col">
                                                <label for="exp_title">Title<span style="color: red;">*</span></label>
                                                <input type="text" name="exp_title" id="exp_title" class="form-control" placeholder="Expense Title">
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col">
                                                <label for="quantity">Exp. Category<span style="color: red;">*</span></label>
                                                <select name="expense_id" id="expense_id" class="form-control" onchange="getExpenseDetails()" required>
                                                    <option value="">Select Expense Category</option>
                                                    @foreach($expenseCategoryList as $expense)
                                                        <option value="{{ $expense->id }}">{{ $expense->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col">
                                                <label for="exp_title">Amount<span style="color: red;">*</span></label>
                                                <input type="number" name="exp_amount" id="exp_amount" class="form-control" placeholder="Expense Amount">
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col">
                                                <label for="total">Comments <sub>(Optional)</sub></label>
                                                <textarea name="exp_comment" id="exp_comment" cols="30" rows="3" class="form-control" placeholder="Any Comment"></textarea>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger btn-sm cancel-button" data-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-success btn-sm save-data">Save</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>




                </div>
            </div>
        </div>
    </div>

    <script>
        $(".search-option").select2({
            tags: true
        });

        let totalAmount = 0;
        let arr = []


        $( document ).ready(function() {
            flatpickr("#exp_date");

            @foreach($expenseList->expenseDetails as $ed)
                arr.push({
                        "id": "{{ $ed->getExpCategoryName->id  }}",
                        "exp_title": "{{ $ed->exp_title }}",
                        "expense_id": "{{ $ed->id }}",
                        "expCategory_name": "{{ $ed->getExpCategoryName->name  }}",
                        "exp_amount": "{{ $ed->amount }}",
                        "exp_comment": "{{ $ed->comments }}",
                    });
            @endforeach
            showDataOnGrid()

        });

        $(".main-form-submit").click(function(event){
            event.preventDefault();
            let _token   = $("#csrf-token").val();
            let exp_date   = $("#exp_date").val();
            let comments   = $("#comments").val();
            let id = $("#exp_id").val();

            $.ajax({
                url: "{{route('expenses.store')}}",
                type:"POST",
                data:{
                    id:id,
                    exp_date:exp_date,
                    comments:comments,
                    totalAmount:totalAmount,
                    expense_details: arr,
                    _token: _token
                },
                success:function(response){
                    Swal.fire({
                        title: 'Expense Created Successfully',
                        confirmButtonText: `OK`,
                    }).then((result) => {
                        window.location.href = "{{ route('expenses.index')}}";
                    });
                },
            });
        });

        function showDataOnGrid(){

            let totalPayble = 0;
            for (var i=0; i<arr.length; i++) {
                totalPayble = totalPayble + parseInt(arr[i].exp_amount);
                var row = $('<tr class="rowTrack"><td>' + arr[i].exp_title+ '</td><td>' + arr[i].expCategory_name + '</td><td>' + arr[i].exp_amount  + '</td><td><button class="btn btn-outline-danger btn-sm" onclick="handleDelete(' + arr[i].id + ')"><i class="fas fa-trash-alt"></i></button></td></tr>');
                $('#myTable').append(row);
            }

            let rose = $('<tr class="rowTrack"><td class="text-right" colspan="2">Total Amount</td>' +
                '<td class="text-left">'+totalPayble+'</td></tr>');
            totalAmount = totalPayble;
            $('#myTable').append(rose);
            $('#paidAmount').val(0);
            $('#dueAmount').val(totalPayble);
        }




        function handleDelete(id){
            $('.rowTrack').remove();
            arr = arr.filter(item => item.id != id);
            showDataOnGrid();
        }


        function handleItem(){
            $('#expDetailsModal').modal('show')
        }


        function getExpenseDetails(){
            var expense_id = $("#expense_id").val();
            $.ajax({
                type:"GET",
                url:"{{url('getExpenseCategoryInfo')}}/"+expense_id,
                success: function(data) {
                    //console.log(data);
                    $('#id').val(data.id);
                    $('#expCategory_name').val(data.name);
                }
            });
        }

        function formReset(){
            $('#exp_title').val('');
            $('#expense_id').val('');
            $('#exp_amount').val(0);
            $('#exp_comment').val('');
            $('#expCategory_name').val('');
            $('#id').val();
        }

        $(".save-data").click(function(event){
            event.preventDefault();
            $('.rowTrack').remove();
            let exp_title   = $("#exp_title").val();
            let expense_id   = $("#expense_id").val();
            let exp_amount   = $("#exp_amount").val();
            let exp_comment   = $("#exp_comment").val();
            let expCategory_name   = $("#expCategory_name").val();

            let id   = $("#id").val();
            let expenseData = {
                "id": id,
                "exp_title": exp_title,
                "expense_id": expense_id,
                "expCategory_name": expCategory_name,
                "exp_amount": exp_amount,
                "exp_comment": exp_comment
            }

            arr.push(expenseData);
            showDataOnGrid();
            formReset();
            $('.cancel-button').click();
        });

    </script>


@endsection
