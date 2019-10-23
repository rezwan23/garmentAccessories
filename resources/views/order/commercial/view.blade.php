@extends('layouts.master')

@section('title', 'View Commercial Details')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <h4 class="card-header">Assign Commercial Details <span class="float-right">
                        <a href="{{route('orders.commercial.assigned.get')}}" class="btn btn-sm btn-warning">Back</a>
                    </span></h4>
                <div class="card-body">
                    <div class="tile">
                        <div class="row">
                            <div class="form-group col-md-2">
                                <label class="control-label">Job ID : <span class="strong">{{$order->id}}</span></label>
                                {{--                                <input id="garments_name" disabled="disabled" value="{{$order->id}}" autocomplete="off" required="" class="form-control" type="text" placeholder="Enter Garments Name" name="garments_name">--}}
                            </div>
                            <div class="form-group col-md-3">
                                <label class="control-label">Garments Name : <span class="strong">{{$order->garments->name}}</span></label>
                                {{--                                <input id="garments_name" value="{{$order->garments->name}}" autocomplete="off" required="" class="form-control" type="text" placeholder="Enter Garments Name" name="garments_name">--}}
                            </div>
                            <div class="form-group col-md-3">
                                <label class="control-label">Buyer Name : <span class="strong">{{$order->buyer->name}}</span></label>
                                {{--                                <input id="buyer_name" autocomplete="off" value="{{$order->buyer->name}}" required="" class="form-control" type="text" placeholder="Enter Buyer Name" name="buyer_name">--}}
                            </div>
                            <div class="form-group col-md-3">
                                <label class="control-label">Order Date : <span class="strong">{{$order->order_date}}</span></label>
                                {{--                                <input required="" class="form-control" value="{{$order->order_date}}" id="demoDate" name="order_date" autocomplete="off" type="text" placeholder="Select Order Date">--}}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                    <input type="hidden" value="{{$order->id}}" name="job_id">
                                    <div class="tile-body">
                                        <h4 class="card-header">Items</h4>
                                        <table class="table table-bordered">
                                            <thead>
                                            <tr>
                                                <th>Item</th>
                                                <th>Unit Price</th>
                                                <th>Unit</th>
                                                <th>Quantity</th>
                                                <th>Total</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($order->commercial->commercials as $commercial)
                                                <tr>
                                                    <td>
                                                        <input type="hidden" name="ordered_item_id[{{$commercial->id}}][]" value="{{$commercial->ordered_item_id}}">
                                                        <input disabled="" readonly required type="text" value="{{$commercial->orderedItem->item->name}}" class="form-control">
                                                    </td>
                                                    <td><input required readonly step=".0001" type="number" id="unit_{{$loop->index}}" onkeyup="countTotal(this.id)" min="0" class="form-control" value="{{$commercial->unit_price}}" name="unit_price[{{$commercial->id}}][]"></td>
                                                    <td><input required readonly type="text" min="0" class="form-control" value="{{$commercial->orderedItem->item->unit->name}}" name="quantity[{{$commercial->id}}][]"></td>
                                                    <td><input required readonly type="number" id="quantity_{{$loop->index}}" onkeyup="countTotal(this.id)" min="0" class="form-control" value="{{$commercial->quantity}}" name="quantity[{{$commercial->id}}][]"></td>
                                                    <td><input required readonly type="text" step=".0001" readonly id="total_{{$loop->index}}" class="form-control total_price" value="{{$commercial->unit_price*$commercial->quantity}}"></td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="tile-body">
                                        <div class="row">
                                            <div class="col-md-8"></div>
                                            <div class="col-md-4">
                                                <h6 class="card-header">Sub Total</h6>
                                                <table class="table table-bordered">
                                                    <tr>
                                                        <th>Total Amount</th>
                                                        <td><input readonly step=".0001" required type="text" value="{{$order->commercial->total_amount}}" name="total_amount" class="form-control" id="total_amount"></td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')

    <script>
        function countTotal(id){
            var newID = id.split('_')[1];
            console.log(newID);
            $('#total_'+newID).val(parseFloat($('#unit_'+newID).val())*(parseFloat($('#quantity_'+newID).val())));
            subTotal();
        }
        function subTotal()
        {
            var total = 0;
            $('.total_price').each(function(){
                total+=parseFloat($(this).val());
            });
            $('#total_amount').val(total);
        }
    </script>
@endsection