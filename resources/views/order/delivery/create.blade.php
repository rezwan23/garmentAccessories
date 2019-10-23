@extends('layouts.master')
@section('title', 'Delivery Order')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <h3 class="card-header">Delivery Order <span class="float-right">
                        <a href="{{route('delivery.index')}}" class="btn btn-warning btn-sm">View All</a>
                    </span></h3>
                <div class="card-body">
                    <div class="tile">
                        <form action="{{route('delivery.store', $order)}}" method="post">
                            @csrf
                            <input type="hidden" name="order_id" value="{{$order->id}}">
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
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <h3 class="card-header">Items</h3>
                                        <table class="table table-bordered">
                                            <thead>
                                            <tr>
                                                <th>Item</th>
                                                <th>Color</th>
                                                <th>Order Quantity</th>
                                                <th>Delivery Due</th>
                                                <th>Stock Quantity</th>
                                                <th width="18%">Today Delivery</th>
                                                <th>Unit</th>
                                                <th>Remarks</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($order->items as $item)
                                                <tr>
                                                    <td><input type="text" disabled="disabled" class="form-control" value="{{$item->item->name}}"></td>
                                                    <td><input type="text" disabled="disabled" class="form-control" value="{{$item->color->name}}"></td>
                                                    <td><input type="number" disabled="disabled" class="form-control" value="{{$item->quantity}}"></td>
                                                    <td><input type="number" disabled value="{{$item->getDeliveryDue()}}" required class="form-control"></td>
                                                    <td><input type="text" class="form-control" disabled="" value="{{$item->stockQuantity()}}"></td>
                                                    <td><input type="number" name="quantity[]" max="{{$item->stockQuantity()}}" min="0" value="0" required class="form-control"></td>
                                                    <input type="hidden" name="ordered_item_id[]" value="{{$item->id}}">
                                                    <input type="hidden" name="item_id[]" value="{{$item->item->id}}">
                                                    <input type="hidden" name="color_id[]" value="{{$item->color->id}}">
                                                    <td><input type="text" disabled="disabled" class="form-control" value="{{$item->item->unit->name}}"></td>
                                                    <td><input type="text" name="remarks[]" class="form-control"></td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                </div>
                            </div>
                                <div class="row">
                                    <div class="col-md-4"></div>
                                    <div class="col-md-4"></div>
                                    <div class="col-md-4">
                                        <h6 class="card-header">Delivery Details</h6>
                                        <table class="table table-bordered float-right">
                                            <tbody>
                                            <tr>
                                                <th>Dilivery Date</th>
                                                <td><input required="required" type="text" class="form-control" id="demoDate1" autocomplete="off" name="delivery_date"></td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                        </div>
                            <div class="tile-footer">
                                <div class="row">
                                    <div class="col-md-12">
                                        <button class="btn btn-primary float-right" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Submit</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')

    <script src="{{asset('admin/js/plugins/bootstrap-datepicker.min.js')}}"></script>
    <script>
        $('#demoDate1').datepicker({
            format: "yyyy-mm-dd",
            autoclose: true,
            todayHighlight: true
        });
    </script>
@endsection