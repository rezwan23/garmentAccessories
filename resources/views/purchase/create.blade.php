@extends('layouts.master')

@section('title', 'Yarn Order')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <h4 class="card-header">Purchase Raw Materials <span class="float-right"><a href="{{route('purchase.index')}}" class="btn btn-warning btn-sm">View All</a></span></h4>
                <div class="card-body">
                    <div class="tile">
                        <form action="{{route('purchase.store')}}" method="post">
                            @csrf
                            <div class="tile-body">
                                <div class="row">
                                    <div class="form-group col-md-3">
                                        <label class="control-label">Vendor</label>
                                        <input id="vendor_id" name="vendor" required class="form-control" onkeypress="vendorAutoComplete(this.id)" type="text" autocomplete="off" placeholder="Enter Vendor Name">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label class="control-label">Order Date</label>
                                        <input class="form-control" required id="demoDate" name="order_date" autocomplete="off" type="text" placeholder="Select Order Date">
                                    </div>
                                    {{--<div class="form-group col-md-4 align-self-end">--}}
                                    {{--<button class="btn btn-primary" type="button"><i class="fa fa-fw fa-lg fa-check-circle"></i>Subscribe</button>--}}
                                    {{--</div>--}}
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <h6 class="card-header">Raw Materials</h6>
                                        <table class="table table-bordered">
                                            <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Unit Price</th>
                                                <th>Purchase Quantity</th>
                                                <th>Total Price</th>
                                                <th width="12%">Action</th>
                                            </tr>
                                            </thead>
                                            <tbody class="container1">
                                            <tr class="r-group">
                                                <td><input id="accessory_0" required data-pattern-id="accessory_++" type="text" name="accessory[]" autocomplete="off" onkeypress="autoCompleteAccs(this.id)" class="form-control"></td>
                                                <td><input id="unitprice_0" required data-pattern-id="unitprice_++" type="number" name="unit_price[]" onkeyup="countTotal(this.id)" value="0" min="0" class="form-control"></td>
                                                <td><input style="width:50%" id="quantity_0" required data-pattern-id="quantity_++" type="number" value="0" min="0" name="quantity[]" onkeyup="countTotal(this.id)" class="form-control float-left"><input class="form-control" type="text" style="width:50px;" data-pattern-id="unit_++" id="unit_0"></td>
                                                <td><input id="total_price_0" required data-pattern-id="total_price_++" type="text" name="total_price[]" class="form-control total_price"></td>
                                                <td><button type="button" class="btn btn-sm btn-primary r-btnAdd"><i class="fa fa-plus"></i></button>
                                                    <button type="button" class="btn btn-sm btn-danger r-btnRemove"><i class="fa fa-trash"></i></button>
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
                                                <th>Total Amount</th>
                                                <td><input type="text" id="total_amount" class="form-control" name="total_amount"></td>
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
@section('head')
    <link rel="stylesheet" href="{{asset('css/jquery-ui.min.css')}}">
@endsection

@section('footer')
    <script src="{{asset('js/jquery-ui.min.js')}}"></script>
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
                alTotal();
            }
        });
    </script>
    <script>
        $('#demoDate').datepicker({
            format: "yyyy-mm-dd",
            autoclose: true,
            todayHighlight: true
        });
    </script>
    <script>
        function autoCompleteAccs(id){
            var accessories = [];
            @foreach($accessories as $accessory)
            accessories.push('{{$accessory->name}}');
            @endforeach
            $('#'+id).autocomplete({
                source: accessories,
                select:function(event, ui){
                    var inputNo = id.split('_')[1];
                    loadUnit(inputNo, ui.item.value);
                }
            })
        }
        function loadUnit(id, accessory){
            $.get('{{route('purchase.get.unit')}}', {'accessory_name':accessory}, function(data){
                console.log(data.name);
                $('#unit_'+id).val(data.name);
            });
        }
        function vendorAutoComplete(id){
            var vendors = [];
            @foreach($vendors as $vendor)
            vendors.push('{{$vendor->name}}');
            @endforeach
            $('#'+id).autocomplete({
                source: vendors,
            })
        }
        function countTotal(id){
            var index = id.split('_')[1];
            var total_price = parseFloat($('#unitprice_'+index).val())*parseFloat($('#quantity_'+index).val());
            $('#total_price_'+index).val(total_price);
            alTotal();
        }
        function alTotal(){
            var total = 0;
            $('.total_price').each(function(){
                total += parseFloat($(this).val());
            });
            $('#total_amount').val(total);
        }
    </script>
@endsection