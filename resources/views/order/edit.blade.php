@extends('layouts.master')

@section('title', 'Edit Order')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <h4 class="card-header">Edit Order <span class="float-right"><a href="{{route('order.index')}}" class="btn btn-warning btn-sm">All Order</a></span></h4>
                <div class="card-body">
                    <div class="tile">
                        <form action="{{route('order.update', $order)}}" method="post">
                            @csrf
                            @method('PUT')
                            <div class="tile-body">
                                @csrf
                                <div class="row">
                                    <div class="form-group col-md-3">
                                        <label class="control-label">Garments Name</label>
                                        <input id="garments_name" value="{{$order->garments->name}}" onkeypress="garmentsAutoComplete(this.id)" autocomplete="off" class="form-control" type="text" placeholder="Enter Garments Name" name="garments_name">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label class="control-label">Garments Address</label>
                                        <input id="garment_address" value="{{$order->garments->address}}" autocomplete="off" required class="form-control" type="text" placeholder="Enter Garments Name" name="address">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label class="control-label">Merchant Name</label>
                                        <input id="merchant_name" value="{{$order->merchant->name}}" onkeypress="merchantAutoComplete(this.id)" autocomplete="off" onkeypress="merchantAutoComplete(this.id)" required class="form-control" type="text" placeholder="Enter Merchant Name" name="merchant_name">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label class="control-label">Buyer Name</label>
                                        <input id="buyer_name" value="{{$order->buyer->name}}" onkeypress="buyerAutoComplete(this.id)" autocomplete="off" onkeypress="buyerAutoComplete(this.id)" required class="form-control" type="text" placeholder="Enter Buyer Name" name="buyer_name">
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
                                                <th>Item Name</th>
                                                <th>Style/Order No.</th>
                                                <th>Size</th>
                                                <th>Quality</th>
                                                <th width="15%">Color</th>
                                                {{--<th>Unit Price</th>--}}
                                                <th>Quantity</th>
                                                <th>Unit</th>
                                                {{--<th>Total</th>--}}
                                            </tr>
                                            </thead>
                                            <tbody class="container1">
                                            @foreach($order->items as $item)
                                            <tr>
                                                <input type="hidden" value="{{$item->id}}" name="item_id[]">
                                                <td><input required id="item_0" data-pattern-id="item_++" type="text" readonly name="item_name[]" value="{{$item->item->name}}" data-pattern-name="item_name[++]" onkeypress="itemsAutoComplete(this.id);" autocomplete="off" placeholder="Enter Item Name" class="form-control"></td>
                                                <td><input id="style_0" data-pattern-id="style_++" required type="text" readonly name="style_number[]" value="{{$item->style_number}}" data-pattern-name="style_number[++]" class="form-control" autocomplete="off" placeholder="Enter Item Style Number"></td>
                                                <td><input id="size_0" data-pattern-id="size_++" required type="text" name="size[]" value="{{$item->size}}" data-pattern-name="style_number[++]" class="form-control" autocomplete="off" placeholder="Enter Item SIze"></td>
                                                <td><input id="quality_0" data-pattern-id="quality_++" required type="text" readonly name="quality[]" value="{{$item->quality}}" data-pattern-name="quality[++]" class="form-control" autocomplete="off" placeholder="Enter Item Quality"></td>
                                                <td>
                                                    <select name="color_id[]" class="form-control select" id="{{$loop->index}}" onfocus="select(this.id);">
                                                        @foreach($colors as $color)
                                                            <option @if($item->color_id == $color->id) selected @endif value="{{$color->id}}">{{$color->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td><input required id="quantity_0" data-pattern-id="quantity_++" type="number" min="0" name="quantity[]" value="{{$item->quantity}}" data-pattern-name="quantity[++]" autocomplete="off" autocomplete="off" value="0" class="form-control"></td>
                                                <td><input required id="unit_0" data-pattern-id="unit_++" type="text" readonly disabled="disabled" name="unit[]" value="{{$item->item->unit->name}}" data-pattern-name="unit[++]" value="0" autocomplete="off" class="form-control"></td>
                                                {{--<td><input required id="total_0" data-pattern-id="total_++" type="number" min="0" name="total[]" data-pattern-name="total[++]" value="0" readonly autocomplete="off" class="form-control item_total_field"></td>--}}
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
@section('head')
    <link rel="stylesheet" href="{{asset('css/jquery-ui.min.css')}}">
@endsection

@section('footer')
    <script src="{{asset('js/jquery-ui.min.js')}}"></script>
    {{--<script>--}}
        {{--$(document).ready(function(){--}}
            {{--$('body').addClass('sidenav-toggled');--}}
        {{--})--}}
    {{--</script>--}}
    <script src="{{asset('admin/js/plugins/bootstrap-datepicker.min.js')}}"></script>
    <script src="{{asset('admin/js/jquery.form-repeater.js')}}"></script>
    {{--<script type="text/javascript">--}}
        {{--$('.container1').repeater({--}}
            {{--btnAddClass: 'r-btnAdd',--}}
            {{--btnRemoveClass: 'r-btnRemove',--}}
            {{--groupClass: 'r-group',--}}
            {{--minItems: 1,--}}
            {{--maxItems: 0,--}}
            {{--startingIndex: 0,--}}
            {{--reindexOnDelete: true,--}}
            {{--repeatMode: 'append',--}}
            {{--animation: null,--}}
            {{--animationSpeed: 400,--}}
            {{--animationEasing: 'swing',--}}
            {{--clearValues: true,--}}
            {{--afterDelete: function(){--}}
                {{--getSubTotal();--}}
            {{--}--}}
        {{--}, [--}}
            {{--@foreach($order->items as $item)--}}
            {{--{--}}
                {{--"item_name[{!! $loop->index !!}]" : "{{$item->item->name}}",--}}
                {{--"style_number[{!! $loop->index !!}]" : "{{$item->style_number}}",--}}
                {{--"quality[{!! $loop->index !!}]" : "{{$item->quality}}",--}}
                {{--"color[{!! $loop->index !!}]" : "{{$item->color->name}}",--}}
                {{--"unit_price[{!! $loop->index !!}]" : "{{$item->unit_price}}",--}}
                {{--"unit[{!! $loop->index !!}]": "{{$item->item->unit->name}}",--}}
                {{--"quantity[{!! $loop->index !!}]" : "{{$item->quantity}}",--}}
                {{--"total[{!! $loop->index !!}]" : "{{$item->quantity*$item->unit_price}}"--}}
            {{--},--}}
            {{--@endforeach--}}
        {{--]);--}}
    {{--</script>--}}
    <script>
        function getTotal(id){
            console.log(id);
            var elId = id.split('_')[1];
            var total = parseFloat($('#unit_'+elId).val())*parseFloat($('#quantity_'+elId).val());
            $('#total_'+elId).val(total);
            getSubTotal();
        }
        function getSubTotal(){
            var subTotal = 0;
            $('.item_total_field').each(function(){
                subTotal+=parseFloat($(this).val());
            })
            $('#all_total').val(subTotal);
        }
    </script>

    <script>
        function garmentsAutoComplete(id){
            var garments = [];
            @foreach($garments as $garment)
            garments.push('{{$garment->name}}');
            @endforeach
            $('#'+id).autocomplete({
                source: garments,
                select:function(event, ui){
                    $.get('{{route('garments.get')}}', {'name' : ui.item.value}, function(data){
                        $('#garment_address').val(data[0].address);
                    })
                }
            })
        }

        function merchantAutoComplete(id){
            var merchants = [];
            @foreach($merchants as $merchant)
            merchants.push('{{$merchant->name}}');
            @endforeach
            $('#'+id).autocomplete({
                source: merchants,
            })
        }

        function buyerAutoComplete(id){
            var buyers = [];
            @foreach($buyers as $buyer)
            buyers.push('{{$buyer->name}}');
            @endforeach
            $('#'+id).autocomplete({
                source: buyers,
            })
        }

        function itemsAutoComplete(id){
            var items = [];
            @foreach($items as $item)
            items.push('{{$item->name}}');
            @endforeach
            $('#'+id).autocomplete({
                source: items,
                select : function(event, ui){
                    $.get('{{route('item.details')}}', {'name':ui.item.value}, function(data){
                        var newId = id.split('_')[1];
                        $('#unit_'+newId).val(data.name)
                    })
                }
            })
        }

        function colorAutoComplete(id){
            var colors = [];
            @foreach($colors as $color)
            colors.push('{{$color->name}}');
            @endforeach
            $('#'+id).autocomplete({
                source: colors,
            })
        }
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
    <script src="/js/select2.min.js"></script>
    <script>
        $(document).ready(function(){
            $('.select').each(function(index, item){
                $(this).select2();
            })
        })
    </script>
@endsection