@extends('layouts.master')

@section('title', 'Purchase Accessories')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <h4 class="card-header">Purchase Accessories <span class="float-right"><a href="{{route('purchase.index')}}" class="btn btn-warning btn-sm">Back</a></span></h4>
                <div class="card-body">
                    <div class="tile">
                            <div class="tile-body">
                                <div class="row">
                                    <div class="form-group col-md-3">
                                        <label class="control-label">Vendor</label>
                                        <input id="vendor_id" name="vendor" required class="form-control" onkeypress="vendorAutoComplete(this.id)" type="text" autocomplete="off" value="{{$purchase->vendor->name}}" placeholder="Enter Vendor Name">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label class="control-label">Order Date</label>
                                        <input class="form-control" required id="demoDate" name="order_date" autocomplete="off" type="text" value="{{$purchase->order_date}}" placeholder="Select Order Date">
                                    </div>
                                    {{--<div class="form-group col-md-4 align-self-end">--}}
                                    {{--<button class="btn btn-primary" type="button"><i class="fa fa-fw fa-lg fa-check-circle"></i>Subscribe</button>--}}
                                    {{--</div>--}}
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <h6 class="card-header">Accessories</h6>
                                        <table class="table table-bordered">
                                            <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Unit Price</th>
                                                <th>Purchase Quantity</th>
                                                <th>Total Price</th>
                                            </tr>
                                            </thead>
                                            <tbody class="container1">
                                            @foreach($purchase->accessories as $accessory)
                                            <tr class="r-group">
                                                <td><input type="text" disabled autocomplete="off" value="{{$accessory->accessory->name}}" class="form-control"></td>
                                                <td><input type="number" disabled name="unit_price[]" value="{{$accessory->unit_price}}" min="0" class="form-control"></td>
                                                <td><input style="width:84%" disabled value="{{$accessory->quantity}}"  type="number" value="0" min="0" name="quantity[]" class="form-control float-left"><span style="margin-top:8px;margin-left:4px;" class="unit badge badge-dark float-left">{{$accessory->accessory->unit->name}}</span></td>
                                                <td><input  type="text" disabled value="{{$accessory->unit_price*$accessory->quantity}}" class="form-control total_price"></td>
                                            </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="col-md-4"></div>
                                    <div class="col-md-4"></div>
                                    <div class="col-md-4">
                                        <h6 class="card-header">Delivery Details</h6>
                                        <table class="table table-bordered float-right">
                                            <tbody>
                                            <tr>
                                                <th>Total Amount</th>
                                                <td><input type="text" id="total_amount" class="form-control" value="{{$purchase->total_amount}}" name="total_amount"></td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
