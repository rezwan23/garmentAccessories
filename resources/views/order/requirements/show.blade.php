@extends('layouts.master')
@section('title', 'View Requirements')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <h4 class="card-header">View Order requirements </h4>
                <div class="card-body">
                    <div class="tile">
                        <div class="tile-body">
                            <div class="row">
                                <div class="form-group col-md-2">
                                    <label class="control-label">Job ID :<span class="strong">{{$order->id}}</span></label>
                                    {{--<input id="garments_name" value="{{$order->id}}" autocomplete="off" class="form-control" type="text" placeholder="Enter Garments Name" name="garments_name">--}}
                                </div>
                                <div class="form-group col-md-3">
                                    <label class="control-label">Garments Name : <span class="strong">{{$order->garments->name}}</span></label>
                                    {{--<input id="garments_name" value="{{$order->garments->name}}" autocomplete="off" class="form-control" type="text" placeholder="Enter Garments Name" name="garments_name">--}}
                                </div>
                                <div class="form-group col-md-3">
                                    <label class="control-label">Merchant Name : <span class="strong">{{$order->merchant->name}}</span></label>
                                    {{--<input id="merchant_name" value="{{$order->merchant->name}}" autocomplete="off" onkeypress="merchantAutoComplete(this.id)" required="" class="form-control" type="text" placeholder="Enter Merchant Name" name="merchant_name">--}}
                                </div>
                                <div class="form-group col-md-3">
                                    <label class="control-label">Buyer Name : <span class="strong">{{$order->buyer->name}}</span></label>
                                    {{--                                    <input id="buyer_name" value="{{$order->buyer->name}}" autocomplete="off" onkeypress="buyerAutoComplete(this.id)" required="" class="form-control" type="text" placeholder="Enter Buyer Name" name="buyer_name">--}}
                                </div>
                                <div class="form-group col-md-3">
                                    <label class="control-label">Order Date : <span class="strong">{{$order->order_date}}</span></label>
                                    {{--<input required="" class="form-control" value="{{$order->order_date}}" id="demoDate" name="order_date" autocomplete="off" type="text" placeholder="Select Order Date">--}}
                                </div>
                                <div class="form-group col-md-3">
                                    <label class="control-label">Dyeing Company : <span class="strong">{{$order->dyeingCompany?$order->dyeingCompany->name:''}}</span></label>
                                    {{--<input required="" class="form-control" value="{{$order->order_date}}" id="demoDate" name="order_date" autocomplete="off" type="text" placeholder="Select Order Date">--}}
                                </div>
                            </div>
                            @foreach($order->items as $item)
                                <h4 class="card-header">{{$item->item->name}}</h4>
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th width="25%">Accessory Name</th>
                                        <th>Type</th>
                                        <th>Color</th>
                                        <th>Accessory Quantity</th>
                                        <th>Unit</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($item->requirements as $requirement)
                                        <tr>
                                            <td><input type="text" class="form-control" disabled value="{{$requirement->accessory->name}}"></td>
                                            <td>
                                                <input type="text" class="form-control" disabled value="{{$requirement->yarn_type?'Dyeing Yarn':'Raw Materials'}}">
                                            </td>
                                            <td><input type="text" class="form-control" disabled value="{{$requirement->yarn_type?$requirement->color->name:''}}"></td>
                                            <td><input type="text" class="form-control" disabled value="{{$requirement->quantity}}"></td>
                                            <td><input type="text" disabled class="form-control" value="{{$requirement->accessory->unit->name}}"></td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection