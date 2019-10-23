@extends('layouts.master')
@section('title','Debit Payment')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <h4 class="card-header">Accounts Payables <span class="float-right">
                        <a href="{{route('accountPayable.index')}}" class="btn btn-sm btn-warning">View All</a>
                    </span></h4>
                <div class="card-body">
                    <form action="" id="vendor_select_form">
                        <div class="form-group col-md-3">
                            <label class="control-label">Select Vendor</label>
                            <select name="vendor_id" id="" class="form-control" onchange="getElementById('vendor_select_form').submit();">
                            @foreach($vendors as $vendor)
                                <option @if(request('vendor_id')==$vendor->id) selected @endif value="{{$vendor->id}}">{{$vendor->name}}</option>
                            @endforeach
                            </select>
                        </div>
                    </form>
                    @if($accountsPayable->count()>0)
                    <div class="tile">
                        <h4 class="card-header">Accounts</h4>
                        <div class="tile-body">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>
                                        <input type="checkbox" id="all_check">
                                    </th>
                                    <th>Vendor</th>
                                    <th>Order Number</th>
                                    <th>Total Amount</th>
                                    <th>Due</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($accountsPayable as $account)
                                    <tr>
                                        <td>
                                            <input type="checkbox"  id="check_{{$loop->index}}">
                                        </td>
                                        <td>{{$account->vendor->name}}</td>
                                        <td>{{$account->order_number}}</td>
                                        <td>{{$account->total_amount}}</td>
                                        <td>{{$account->due}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                        @endif
                </div>
            </div>
        </div>
    </div>
@endsection
