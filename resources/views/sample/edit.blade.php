@extends('layouts.master')
@section('title', 'Edit Sample Order')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <h4 class="card-header">Edit Sample Order <span class="float-right"><a href="{{route('sample.order.index')}}" class="btn btn-warning btn-sm">View All</a></span></h4>
                <div class="card-body">
                    <div class="tile">
                        <form action="{{route('sample.order.update', $order)}}" method="post">
                            @method('PUT')
                            @csrf
                            <div class="tile-body">
                                <div class="row">
                                    <div class="form-group col-md-3">
                                        <label class="control-label">Garments Name</label>
                                        <input class="form-control" value="{{$order->garments_name}}" type="text" name="garments_name" autocomplete="off" onkeypress="loadGarments(this.id)" id="garments_name" required  placeholder="Enter Garments Name">
                                        <input type="hidden" name="garment_id" value="{{$order->garment_id}}" id="garment_id">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label class="control-label">Merchant Name</label>
                                        <input type="text" name="merchant_name" value="{{$order->merchant_name}}" id="merchant_name" required class="form-control" autocomplete="off" onkeypress="loadMerchants(this.id)" placeholder="Enter Merchant Name">
                                        <input type="hidden" name="merchant_id" id="merchant_id" value="{{$order->merchant_id}}">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label class="control-label">Buyer Name</label>
                                        <input type="text" required name="buyer_name" id="buyer_name" value="{{$order->buyer_name}}" onkeypress="loadBuyers(this.id)" class="form-control" placeholder="Enter Buyer Name">
                                        <input type="hidden" name="buyer_id" value="{{$order->buyer_id}}" id="buyer_id">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label class="control-label">Remarks</label>
                                        <textarea type="text"  name="remarks" rows="2" class="form-control" placeholder="Enter Remarks">{{$order->remarks}}</textarea>
                                    </div>

                                    {{--<div class="form-group col-md-4 align-self-end">--}}
                                    {{--<button class="btn btn-primary" type="button"><i class="fa fa-fw fa-lg fa-check-circle"></i>Subscribe</button>--}}
                                    {{--</div>--}}
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <h4 class="card-header">Item</h4>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label class="control-label">Item Name</label>
                                        <input type="text" value="{{$order->item_name}}" required name="item_name" class="form-control" autocomplete="off" id="item_name" onkeypress="loatItems(this.id);" placeholder="Enter Item Name">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label class="control-label">Size</label>
                                        <input type="text" required name="size" value="{{$order->size}}" class="form-control" autocomplete="off" id="size" placeholder="Enter Item Size">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label class="control-label">Order Number</label>
                                        <input type="text" required value="{{$order->order_number}}" name="order_number" class="form-control" placeholder="Enter Order Number">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label class="control-label">Receive Date</label>
                                        <input class="form-control" required id="demoDate" value="{{$order->receive_date}}" name="receive_date" autocomplete="off" value="{{date('Y-m-d')}}" type="text" placeholder="Select Order Date">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label class="control-label">Delivery Date</label>
                                        <input class="form-control" required id="demoDate1" value="{{$order->delivery_date}}" name="delivery_date" autocomplete="off" value="{{date('Y-m-d')}}" type="text" placeholder="Select Order Date">
                                    </div>

                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="tile-footer" style="padding-bottom: 50px;">
                                <button class="btn btn-primary float-right" style="display: block;" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Submit</button>
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
        function loatItems(id){
            var items = [];
            @foreach($items as $item)
            items.push('{{$item->name}}')
            @endforeach
            $('#'+id).autocomplete({
                source: items
            })
        }
        function loadGarments(id){
            $('#'+id).autocomplete({
                source:function(request, response){
                    $.get('{{route('garments.get')}}', {'name':request.term}, function(data){
                        response($.map(data, function(garment){
                            return {
                                label:garment.name,
                                value:garment.name,
                                id:garment.id,
                            }
                        }));
                    })
                },
                select:function(event, ui){
                    $('#garment_id').val(ui.item.id);
                }
            })
        }
        function loadMerchants(id){
            $('#'+id).autocomplete({
                source:function(request, response){
                    $.get('{{route('merchants.all')}}', {'name':request.term}, function(data){
                        response($.map(data, function(merchant){
                            return {
                                label:merchant.name,
                                value:merchant.name,
                                id:merchant.id,
                            }
                        }));
                    })
                },
                select:function(event, ui){
                    $('#merchant_id').val(ui.item.id);
                }
            })
        }
        function loadBuyers(id){
            $('#'+id).autocomplete({
                source:function(request, response){
                    $.get('{{route('buyers.all')}}', {'name':request.term}, function(data){
                        response($.map(data, function(buyer){
                            return {
                                label:buyer.name,
                                value:buyer.name,
                                id:buyer.id,
                            }
                        }));
                    })
                },
                select:function(event, ui){
                    $('#buyer_id').val(ui.item.id);
                }
            })
        }
    </script>
@endsection