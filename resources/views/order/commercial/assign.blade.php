@extends('layouts.master')
@section('title', 'Assign Commercial')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <h4 class="card-header">Select JobID
                    <span class="float-right"><a class="btn btn-sm btn-warning" href="{{route('orders.commercial.assigned.get')}}">View All</a></span>
                </h4>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <form action="" id="job_id_form">
                                <div class="form-group">
                                    <label class="control-label">Job ID</label>
                                    <input type="hidden" name="order_id" id="order_id">
                                    <input @if($orderDetails->count()>0) readonly @endif value type="text" autocomplete="off" class="form-control" id="autoCompleteJobId" onkeypress="jobSearch(this.id)">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @if($orderDetails->count()>0)
            <div class="card">
                <h4 class="card-header">Assign Commercial Details</h4>
                <div class="card-body">
                    <div class="tile">
                        <div class="row">
                            <div class="form-group col-md-2">
                                <label class="control-label">Job ID : <span class="strong">{{$orderDetails->id}}</span></label>
                                {{--<input id="garments_name" disabled="disabled" value="{{$orderDetails->id}}" autocomplete="off" required="" class="form-control" type="text" placeholder="Enter Garments Name" name="garments_name">--}}
                            </div>
                            <div class="form-group col-md-3">
                                <label class="control-label">Garments Name : <span class="strong">{{$orderDetails->garments->name}}</span></label>
                                {{--<input id="garments_name" value="{{$orderDetails->garments->name}}" autocomplete="off" required="" class="form-control" type="text" placeholder="Enter Garments Name" name="garments_name">--}}
                            </div>
                            <div class="form-group col-md-3">
                                <label class="control-label">Buyer Name : <span class="strong">{{$orderDetails->buyer->name}}</span></label>
                                {{--<input id="buyer_name" autocomplete="off" value="{{$orderDetails->buyer->name}}" required="" class="form-control" type="text" placeholder="Enter Buyer Name" name="buyer_name">--}}
                            </div>
                            <div class="form-group col-md-3">
                                <label class="control-label">Order Date : <span class="strong">{{$orderDetails->order_date}}</span></label>
                                {{--<input required="" class="form-control" value="{{$orderDetails->order_date}}" id="demoDate" name="order_date" autocomplete="off" type="text" placeholder="Select Order Date">--}}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <form action="{{route('assign.commercial.store')}}" method="post">
                                    @csrf
                                    <input type="hidden" value="{{$orderDetails->id}}" name="job_id">
                                    <div class="tile-body">
                                        <h4 class="card-header">Items</h4>
                                        <table class="table table-bordered">
                                            <thead>
                                            <tr>
                                                <th width="25%">Item</th>
                                                <th width="15%">Size</th>
                                                <th>Style</th>
                                                <th>Quantity</th>
                                                <th>Unit</th>
                                                <th>Unit Price ($)</th>
                                                <th>Total ($)</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($orderDetails->items as $item)
                                                    <tr>
                                                        <td>
                                                            <input type="hidden" name="ordered_item_id[]" value="{{$item->id}}">
                                                            <input required type="text" value="{{$item->item->name}}" disabled class="form-control">
                                                        </td>
                                                        <td><input type="text" disabled class="form-control" value="{{$item->size}}"></td>
                                                        <td><input type="text" name="style_number[]" readonly class="form-control" value="{{$item->style_number}}"></td>
                                                        <td><input required type="number" value="{{$item->quantity}}" readonly id="quantity_{{$loop->index}}" onkeyup="countTotal(this.id)" min="0" class="form-control" name="quantity[]"></td>
                                                        <td><input type="text" class="form-control" disabled value="{{$item->item->unit->name}}"></td>
                                                        <td><input required type="number" value="0" id="unit_{{$loop->index}}" onkeyup="countTotal(this.id)" min="0" class="form-control"step="0.0001" name="unit_price[]"></td>
                                                        <td><input required type="text" value="0" readonly id="total_{{$loop->index}}" class="form-control total_price"></td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="tile-body">
                                        <div class="row">
                                            <div class="col-md-8"></div>
                                            <div class="col-md-4">
                                                <h6 class="card-header">Sub Total </h6>
                                                <table class="table table-bordered">
                                                    <tr>
                                                        <th>Total Amount ($)</th>
                                                        <td><input readonly required type="text" name="total_amount" class="form-control" id="total_amount"></td>
                                                    </tr>
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
            </div>
            @endif
        </div>
    </div>
@endsection
@section('head')
    <link rel="stylesheet" href="{{asset('css/jquery-ui.min.css')}}">
@endsection
@section('footer')
    <script src="{{asset('js/jquery-ui.min.js')}}"></script>
    <script>

        function jobSearch(id){
            var jobIds = [];
            @foreach($orders as $order)
            jobIds.push('Job Id-'+'{{$order->id}}-'+'{{$order->garments->name}}')
            @endforeach
            $('#'+id).autocomplete({
                source: jobIds,
                select:function(event, ui){
                    var newID = ui.item.value.split('-')[1];
                    $('#order_id').val(newID);
                    $('#job_id_form').submit();
                }
            })
        }

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