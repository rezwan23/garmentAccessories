
@extends('layouts.master')

@section('title', 'View Details')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <h4 class="card-header">Payable Account</h4>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>Order No.</th>
                                    <td>{{$account->order_number}}</td>
                                </tr>
                                <tr>
                                    <th>Vendor</th>
                                    <td>{{$account->vendor->name}}</td>
                                </tr>
                                <tr>
                                    <th>Sector</th>
                                    <td>
                                        @foreach($account->details as $detail)
                                            {{$detail->sector->name}},
                                        @endforeach
                                    </td>
                                </tr>
                                <tr>
                                    <th>Order Date</th>
                                    <td>{{$account->order_date}}</td>
                                </tr>
                                <tr>
                                    <th>Total Amount</th>
                                    <td>{{$account->total_amount}}</td>
                                </tr>
                                <tr>
                                    <th>Due</th>
                                    <td>{{$account->due}}</td>
                                </tr>
                                </thead>
                            </table>
                        </div>
                        <div class="col-md-8">
                            <div class="tile">
                                <form action="{{route('payment.make', $account)}}" method="post">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="tile-body">
                                                <div class="form-group">
                                                    <label class="control-label">Select Account</label>
                                                    <select name="account_id" class="form-control {{$errors->has('account_id')?'is-invalid':''}}" onchange="getAccountMethods($(this))">
                                                        <option value="null">Select Account</option>
                                                        @foreach($accounts as $acc)
                                                            <option value="{{$acc->id}}">{{$acc->name}}</option>
                                                        @endforeach
                                                    </select>
                                                    @if ($errors->has('account_id'))
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $errors->first('account_id') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label">Select Payment Method</label>
                                                    <select class="form-control {{$errors->has('payment_method_id')?'is-invalid':''}}" name="payment_method_id" id="method">
                                                        <option value="null">Seletec Account First</option>
                                                    </select>
                                                    @if ($errors->has('payment_method_id'))
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $errors->first('payment_method_id') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label">Reference</label>
                                                    <input type="text" name="ref_id" class="form-control {{$errors->has('ref_id')?'is-invalid':''}}" placeholder="Enter Reference">
                                                    @if ($errors->has('ref_id'))
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $errors->first('ref_id') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">Payable</label>
                                                <input type="number" min="0" name="total_payable" disabled value="{{$account->due}}" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label">Cheque Number</label>
                                                <input type="text" name="cheque_number" placeholder="Enter Cheque Number if required" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label">Amount to be Paid</label>
                                                <input type="number" min="0" max="{{$account->due}}" name="paid_amount" placeholder="Amount Paid" class="form-control {{$errors->has('paid_amount')?'is-invalid':''}}">
                                                @if ($errors->has('paid_amount'))
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $errors->first('paid_amount') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label">Date</label>
                                                <input type="text" id="demoDate" name="date" value="{{date('Y-m-d')}}" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tile-footer p-b-38">
                                        <button class="btn btn-primary float-right" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')
    <script src="{{asset('admin/js/plugins/bootstrap-datepicker.min.js')}}"></script>
    <script>
        function getAccountMethods(el){
            var account_id = el.val();
            $.get('{{route('account.methods')}}', {'account_id': account_id}, function(data){
                $('#method').empty();
                $.each(data, function(index, method){
                    $('#method').append('<option value="'+method.id+'">'+method.name+'</option>');
                });
            });
        }
        $('#demoDate').datepicker({
            format: "yyyy-mm-dd",
            autoclose: true,
            todayHighlight: true
        });
    </script>

    @endsection