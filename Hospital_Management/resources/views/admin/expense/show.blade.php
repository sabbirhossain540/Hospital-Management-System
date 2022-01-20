@extends('admin.layouts')

@section("content")
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="d-flex flex-row">
                <div class="col-md-10">
                    <h6 class="m-0 font-weight-bold text-primary">Expense Details</h6>
                </div>
                <div class="col-md-2" style="margin-left: 65px;">
                    <a target="_blank" class="btn btn-warning btn-sm" href="{{route('printInvoice', $expanseList->id)}}">Print</a>
                    <a href="{{route('expenses.index')}}" class="btn btn-primary btn-sm">Back</a>
                </div>
            </div>
        </div>

        <div class="card-body" class="printScrent">
            <table class="table table-bordered table-sm text-dark">
                <tr>
                    <td width="20%" class="text-right"><strong>Exp. Voucher No</strong></td>
                    <td width="30%">{{ $expanseList->exp_no }}</td>
                    <td width="20%" class="text-right"><strong>Expanse Date</strong></td>
                    <td width="30%">{{ date_format($expanseList->formated_exp_date,'jS M, Y') }}</td>
                </tr>
                <tr>

                    <td width="20%" class="text-right"><strong>Comments</strong></td>
                    <td width="30%">{{ $expanseList->comments }}</td>
                    <td width="20%" class="text-right"><strong>Create User</strong></td>
                    <td width="30%">{{ $expanseList->getCreatedUser['name'] }}</td>
                </tr>
            </table>

            <div class="table-responsive">
                <table class="table table-bordered table-sm text-dark" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th width="5%">SN</th>
                        <th width="30%">Exp. Title</th>
                        <th width="20%">Exp. Category</th>
                        <th width="30%">Comments</th>
                        <th width="15%">Amount</th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach($expanseList->expenseDetails as $key=>$expanse)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>{{ $expanse->exp_title }}</td>
                            <td>@if(!empty($expanse->getExpCategoryName->name)){{ $expanse->getExpCategoryName->name }}@endif</td>

                            <td>{{ $expanse->comments }}</td>
                            <td>{{ $expanse->amount }}</td>
                        </tr>
                    @endforeach
                        <tr>
                            <td colspan="4" align="right">Total</td>
                            <td>{{ $expanseList->amount }}</td>
                        </tr>

                    </tbody>
                </table>

        </div>
    </div>


{{--        <script>--}}
{{--            function printDiv()--}}
{{--            {--}}
{{--                var printContents = document.getElementById('#printScrent').innerHTML;--}}
{{--                var originalContents = document.body.innerHTML;--}}

{{--                document.body.innerHTML = printContents;--}}

{{--                window.print();--}}

{{--                document.body.innerHTML = originalContents;--}}

{{--                // var divToPrint=document.getElementById('#printScrent');--}}
{{--                //--}}
{{--                // var newWin=window.open('','Print-Window');--}}
{{--                //--}}
{{--                // newWin.document.open();--}}
{{--                //--}}
{{--                // newWin.document.write('<html><body onload="window.print()">'+divToPrint.innerHTML+'</body></html>');--}}
{{--                //--}}
{{--                // newWin.document.close();--}}
{{--                //--}}
{{--                // setTimeout(function(){newWin.close();},10);--}}

{{--            }--}}
{{--        </script>--}}


@endsection
