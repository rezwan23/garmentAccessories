@extends('layouts.master')

@section('title', 'View Order')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <h4 class="card-header">View Order <span class="float-right"><a href="{{route('order.index')}}" class="btn btn-warning btn-sm">All Order</a></span></h4>
                <div class="card-body">
                    <div class="tile">
                            <div class="tile-body">
                                @csrf
                                <div class="row">
                                    <div class="form-group col-md-3">
                                        <label class="control-label">Garments Name</label>
                                        <input id="garments_name" value="{{$order->garments->name}}" autocomplete="off" class="form-control" type="text" placeholder="Enter Garments Name" name="garments_name">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label class="control-label">Merchant Name</label>
                                        <input id="merchant_name" value="{{$order->merchant->name}}" autocomplete="off" onkeypress="merchantAutoComplete(this.id)" required class="form-control" type="text" placeholder="Enter Merchant Name" name="merchant_name">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label class="control-label">Buyer Name</label>
                                        <input id="buyer_name" value="{{$order->buyer->name}}" autocomplete="off" onkeypress="buyerAutoComplete(this.id)" required class="form-control" type="text" placeholder="Enter Buyer Name" name="buyer_name">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label class="control-label">Order Date</label>
                                        <input required class="form-control" value="{{$order->order_date}}" id="demoDate" name="order_date" autocomplete="off" type="text" placeholder="Select Order Date">
                                    </div>
                                    {{--<div class="form-group col-md-4 align-self-end">--}}
                                    {{--<button class="btn btn-primary" type="button"><i class="fa fa-fw fa-lg fa-check-circle"></i>Subscribe</button>--}}
                                    {{--</div>--}}
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <h6 class="card-header">Items</h6>
                                        <table class="table table-bordered">
                                            <thead>
                                            <tr>
                                                <th width="22%">Item Name</th>
                                                <th>Size</th>
                                                <th>Style/Order No.</th>
                                                <th>Quality</th>
                                                <th>Color</th>
                                                <th>Quantity</th>
                                                <th>Unit</th>
                                                {{--<th>Unit Price</th>--}}
                                                {{--<th>Quantity</th>--}}
                                                {{--<th>Total</th>--}}
                                                <th width="8%">Action</th>
                                            </tr>
                                            </thead>
                                            <tbody class="container1">
                                            <tr class="r-group">
                                                <td><input readonly required id="item_0" data-pattern-id="item_++" type="text" name="item_name[]" data-pattern-name="item_name[++]" onkeypress="itemsAutoComplete(this.id);" autocomplete="off" placeholder="Enter Item Name" class="form-control"></td>
                                                <td><input readonly required id="size_0" data-pattern-id="size_++" type="text" name="size[]" data-pattern-name="size[++]" autocomplete="off" placeholder="Enter Item Size" class="form-control"></td>
                                                <td><input readonly id="style_0" data-pattern-id="style_++" required type="text" name="style_number[]" data-pattern-name="style_number[++]" class="form-control" autocomplete="off" placeholder="Enter Item Style Number"></td>
                                                <td><input readonly id="quality_0" data-pattern-id="quality_++" required type="text" name="quality[]" data-pattern-name="quality[++]" class="form-control" autocomplete="off" placeholder="Enter Item Quality"></td>
                                                <td><input readonly id="color_0" data-pattern-id="color_++"  required type="text" name="color[]" data-pattern-name="color[++]" onkeypress="colorAutoComplete(this.id)" autocomplete="off" placeholder="Enter Item Color" class="form-control"></td>
                                                <td><input readonly id="quantity_0" data-pattern-id="quantity_++"  required type="number" name="quantity[]" data-pattern-name="quantity[++]" autocomplete="off" placeholder="Enter Item quantity" class="form-control"></td>
                                                <td><input readonly id="unit_0" data-pattern-id="unit_++"  required type="text" readonly name="unit[]" data-pattern-name="unit[++]" autocomplete="off" placeholder="Enter Item unit of measurement" class="form-control"></td>
                                                {{--<td><input required id="unit_0" data-pattern-id="unit_++" onkeyup="getTotal(this.id)" type="number" name="unit_price[]" data-pattern-name="unit_price[++]" value="0" autocomplete="off" class="form-control"></td>--}}
                                                {{--<td><input required id="quantity_0" data-pattern-id="quantity_++" onkeyup="getTotal(this.id)" type="number" min="0" name="quantity[]" data-pattern-name="quantity[++]" autocomplete="off" autocomplete="off" value="0" class="form-control"></td>--}}
                                                {{--<td><input required id="total_0" data-pattern-id="total_++" type="number" min="0" name="total[]" data-pattern-name="total[++]" value="0" readonly autocomplete="off" class="form-control item_total_field"></td>--}}
                                                <td><button type="button" class="btn btn-sm small-btn btn-primary r-btnAdd"><i class="fa fa-plus"></i></button>
                                                    <button type="button" class="btn btn-sm small-btn btn-danger r-btnRemove"><i class="fa fa-trash"></i></button>
                                                </td>
                                            </tr>
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
                                                <th>Dilivery Date</th>
                                                <td><input required type="text" class="form-control" id="demoDate1" autocomplete="off" value="{{$order->delivery_date}}" name="delivery_date"></td>
                                            </tr>
                                            {{--<tr>--}}
                                                {{--<th>Total Amount</th>--}}
                                                {{--<td><input type="text" id="all_total" readonly class="form-control" value="{{$order->total_amount}}" name="total_amount"></td>--}}
                                            {{--</tr>--}}
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
@section('head')
    <link rel="stylesheet" href="{{asset('css/jquery-ui.min.css')}}">
@endsection

@section('footer')
    <script src="{{asset('js/jquery-ui.min.js')}}"></script>
    <script>
        $(document).ready(function(){
            $('body').addClass('sidenav-toggled');
        });
    </script>
    {{--<script>--}}
        {{--$(document).ready(function(){--}}
            {{--$('body').addClass('sidenav-toggled');--}}
        {{--})--}}
    {{--</script>--}}
    <script src="{{asset('admin/js/plugins/bootstrap-datepicker.min.js')}}"></script>
    <script src="{{asset('admin/js/jquery.form-repeater.js')}}"></script>
    <script type="text/javascript">
        $('.container1').repeater({
            btnAddClass: 'r-btnAdd',
            btnRemoveClass: 'r-btnRemove',
            groupClass: 'r-group',
            minItems: 1,
            maxItems: 0,
            startingIndex: 0,
            reindexOnDelete: true,
            repeatMode: 'append',
            animation: null,
            animationSpeed: 400,
            animationEasing: 'swing',
            clearValues: true,
            afterDelete: function(){
                getSubTotal();
            }
        }, [
            @foreach($order->items as $item)
            {
                "item_name[{!! $loop->index !!}]" : "{{$item->item->name}}",
                "size[{!! $loop->index !!}]" : "{{$item->size}}",
                "style_number[{!! $loop->index !!}]" : "{{$item->style_number}}",
                "quality[{!! $loop->index !!}]" : "{{$item->quality}}",
                "color[{!! $loop->index !!}]" : "{{$item->color->name}}",
                "unit_price[{!! $loop->index !!}]" : "{{$item->unit_price}}",
                "unit[{!! $loop->index !!}]": "{{$item->item->unit->name}}",
                "quantity[{!! $loop->index !!}]" : "{{$item->quantity}}",
                "total[{!! $loop->index !!}]" : "{{$item->quantity*$item->unit_price}}"
            },
            @endforeach
        ]);
    </script>
    <script>

        $('#demoDate').datepicker({
            format: "yyyy-mm-dd",
            autoclose: true,
            todayHighlight: true
        });
        $('#demoDate1').datepicker({
            format: "yyyy-mm-dd",
            autoclose: true,
            todayHighlight: true
        });
    </script>

@endsection