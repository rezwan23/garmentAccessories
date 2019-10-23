@extends('layouts.master')

@section('title', 'Add New Order')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <h4 class="card-header">New Order <span class="float-right"><a href="{{route('order.index')}}" class="btn btn-warning btn-sm">All Order</a></span></h4>
                <div class="card-body">
                    <div class="tile">
                        <form action="{{route('order.showForm')}}", method="post">
                            <div class="tile-body">
                                @csrf
                                <div class="row">
                                    <div class="form-group col-md-3">
                                        <label class="control-label">Garments Name</label>
                                        <input id="garments_name" autocomplete="off" onkeypress="garmentsAutoComplete(this.id)" required class="form-control" type="text" placeholder="Enter Garments Name" name="garments_name">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label class="control-label">Garments Address</label>
                                        <input id="garment_address" autocomplete="off" required class="form-control" type="text" placeholder="Enter Garments Name" name="address">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label class="control-label">Style Number</label>
                                        <input required class="form-control" type="text" placeholder="Enter Style" name="style">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label class="control-label">Merchant Name</label>
                                        <input id="merchant_name" autocomplete="off" onkeypress="merchantAutoComplete(this.id)" required class="form-control" type="text" placeholder="Enter Merchant Name" name="merchant_name">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label class="control-label">Buyer Name</label>
                                        <input id="buyer_name" autocomplete="off" onkeypress="buyerAutoComplete(this.id)" required class="form-control" type="text" placeholder="Enter Buyer Name" name="buyer_name">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label class="control-label">Order Date</label>
                                        <input required class="form-control" id="demoDate" name="order_date" autocomplete="off" type="text" placeholder="Select Order Date">
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
                                                <th>Size</th>
                                                <th>Style/Order No.</th>
                                                <th>Quality</th>
                                                <th>Color</th>
                                                <th>Quantity</th>
                                                <td>Unit</td>
                                                <th width="8%">Action</th>
                                            </tr>
                                            </thead>
                                            <tbody class="container1">
                                            <tr class="r-group">
                                                <td><input required id="item_0" data-pattern-id="item_++" type="text" name="item_name[]" onkeypress="itemsAutoComplete(this.id);" autocomplete="off" placeholder="Enter Item Name" class="form-control"></td>
                                                <td><input required id="size_0" data-pattern-id="size_++" type="text" name="size[]" autocomplete="off" placeholder="Enter Item Size" class="form-control"></td>
                                                <td><input id="style_0" data-pattern-id="style_++" required type="text" name="style_number[]" class="form-control" autocomplete="off" placeholder="Enter Item Style Number"></td>
                                                <td><input id="quality_0" data-pattern-id="quality_++" required type="text" name="quality[]" class="form-control" autocomplete="off" placeholder="Enter Item Quality"></td>
                                                <td><input id="color_0" data-pattern-id="color_++"  required type="text" name="color[]" onkeypress="colorAutoComplete(this.id)" autocomplete="off" placeholder="Enter Item Color" class="form-control"></td>
                                                <td><input required id="quantity_0" data-pattern-id="quantity_++" type="number" min="0" name="quantity[]" autocomplete="off" autocomplete="off" value="0" class="form-control"></td>
                                                <td><input type="text" class="form-control" id="unit_0" data-pattern-id="unit_++" name="unit[]" required placeholder="Enter Unit" disabled="disabled"></td>
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
                                                <td><input required type="text" class="form-control" id="demoDate1" autocomplete="off" name="delivery_date"></td>
                                            </tr>
                                            {{--<tr>--}}
                                                {{--<th>Total Amount</th>--}}
                                                {{--<td><input type="text" id="all_total" readonly class="form-control" value="0" name="total_amount"></td>--}}
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
    <script>
//        $(document).ready(function(){
//            $('body').addClass('sidenav-toggled');
//        })
    </script>
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
        });
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
@endsection