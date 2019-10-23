@extends('layouts.master')

@section('title', 'Add Order Requirements')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <h4 class="card-header">Add Raw Materials</h4>
                <div class="card-body">
                    <form action="" method="post">
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

                            </div>
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <label class="control-label">Dyeing Company : </label>
                                    <input class="form-control" @if($order->is_dyeing) required @endif id="dyeing_company" name="dyeing_company" autocomplete="off" type="text" placeholder="Dyeing Company" onkeypress="loadDyeingCompanies(this.id);">
                                </div>
                                <div class="form-group col-md-5">
                                    <label class="control-label">Dyeing Company Address : </label>
                                    <input class="form-control" id="dyeing_company_address" name="address" autocomplete="off" type="text" placeholder="Dyeing Company Address">
                                </div>
                                <div class="form-group col-md-3">
                                    <label class="control-label">Dyeing Delivery Date : </label>
                                    <input class="form-control" id="demoDate" name="dyeing_delivery_date" autocomplete="off" type="text" placeholder="Dyeing Delivery Date">
                                </div>
                            </div>
                        </div>
                            <input type="hidden" name="order_id" value="{{$order->id}}">
                            @csrf
                        @foreach($order->items as $item)
                        <div class="tile-body">
                            <h4 class="card-header">Item Details</h4>
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th width="25%">Item</th>
                                    <th>Style</th>
                                    <th>Quality</th>
                                    <th>Color</th>
                                    <th>Quantity</th>
                                    <th>Unit</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td><input type="text" class="form-control" disabled value="{{$item->item->name}}"></td>
                                    <td><input type="text" class="form-control" disabled value="{{$item->style_number}}"></td>
                                    <td><input type="text" class="form-control" disabled value="{{$item->quality}}"></td>
                                    <td><input type="text" class="form-control" disabled value="{{$item->color->name}}"></td>
                                    <td><input type="text" class="form-control" disabled value="{{$item->quantity}}"></td>
                                    <td><input type="text" class="form-control" disabled value="{{$item->item->unit->name}}"></td>
                                </tr>
                                </tbody>
                            </table>
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>Material type</th>
                                    <th>Raw Materials Name</th>
                                    <th>Color</th>
                                    <th>Quantity</th>
                                    <th>Unit</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody class="container_{{$item->id}}">
                                <tr class="group_{{$item->id}}">
                                    <td>
                                        <select name="yarn_type[{{$item->id}}][0]" onchange="changeYarnType(this.id)" class="form-control" id="yarn_type_{{$item->id}}_0" data-pattern-id="yarn_type_{{$item->id}}_++" data-pattern-name="yarn_type[{{$item->id}}][++]">
                                            <option value="0">Raw Materials</option>
                                            <option value="1">Dyeing Yarn</option>
                                        </select>
                                    </td>
                                    <td><input data-pattern-id="accessory_name_{{$item->id}}_++" id="accessory_name_{{$item->id}}_0" required type="text" data-pattern-name="accessory_name[{{$item->id}}][++]" name="accessory_name[{{$item->id}}][0]" onkeypress="accessoriesAutoComplete(this.id)" autocomplete="off" class="form-control"></td>
                                    <td><select disabled class="form-control" name="color[{{$item->id}}][0]" id="color_{{$item->id}}_0" data-pattern-name="color[{{$item->id}}][++]" data-pattern-id="color_{{$item->id}}_++"></select></td>
                                    <td><input data-pattern-id="accessory_quantity_{{$item->id}}_++" id="accessory_quantity_{{$item->id}}_0" required type="text" data-pattern-name="accessory_quantity[{{$item->id}}][++]" name="accessory_quantity[{{$item->id}}][0]"  autocomplete="off" class="form-control"></td>
                                    <td><input data-pattern-id="accessory_unit_{{$item->id}}_++" disabled id="accessory_unit_{{$item->id}}_0" required type="text" data-pattern-name="accessory_unit[{{$item->id}}][++]" name="accessory_unit[{{$item->id}}][0]"  autocomplete="off" class="form-control"></td>
                                    <td>
                                        <button class="add_{{$item->id}} btn btn-primary btn-sm" style="margin-right:4px;"><i class="fa fa-plus"></i></button>
                                        <button class="del_{{$item->id}} btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        @endforeach
                        <div class="tile-footer">
                                <div class="row">
                                    <div class="col-md-12">
                                        <button class="btn btn-primary float-right" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Submit</button>
                                    </div>
                                </div>
                            </div>
                </div>
                    </form>
            </div>
        </div>
    </div>
    </div>
@endsection
@section('head')
    <link rel="stylesheet" href="{{asset('css/jquery-ui.min.css')}}">
@endsection

@section('footer')
    <script src="{{asset('admin/js/jquery.form-repeater.js')}}"></script>
    <script src="{{asset('admin/js/plugins/bootstrap-datepicker.min.js')}}"></script>
    <script>
        $('#demoDate').datepicker({
            format: "yyyy-mm-dd",
            autoclose: true,
            todayHighlight: true
        });
    </script>
    <script src="{{asset('js/jquery-ui.min.js')}}"></script>
            <script>
                function loadDyeingCompanies(id){
                    $('#'+id).autocomplete({
                        source: function(request, response){
                            $.get('{{route('dyeing.company.all')}}', {name:request.term}, function(data){
                                response($.map(data, function(company){
                                    return{
                                        label:company.name,
                                        value:company.name,
                                        address:company.address,
                                    }
                                }));
                            })
                        },
                        select:function(event, ui){
                            $('#dyeing_company_address').val(ui.item.address);
                        }
                    });
                }
            </script>
    <script>
        function accessoriesAutoComplete(id){
            var accessories = [];
            @foreach($accessories as $accessory)
            accessories.push('{{$accessory->name}}');
            @endforeach
            $('#'+id).autocomplete({
                source: accessories,
                select: function(event, ui){
                    var item_id = id.split('_')[2];
                    var newId = id.split('_')[3];
                    $.get('{{route('raw.unit.get')}}', {'name':ui.item.value}, function(data){
                        $('#accessory_unit_'+item_id+'_'+newId).val(data.name);
                    });
                    var type = $('#yarn_type_'+item_id+'_'+newId+' option:selected').val();
                    if(type=='1'){
                        console.log(ui.item.value);
                        $.get('{{route('raw.colors.get')}}', {'name':ui.item.value}, function(data){
                            $('#color_'+item_id+'_'+newId).empty();
                            $.each(data, function(index, color){
                                $('#color_'+item_id+'_'+newId).append('<option value="'+color.id+'">'+color.name+'</option>');
                            });
                        })
                    }
                }
            })
        }
    </script>
    @foreach($order->items as $item)
    <script type="text/javascript">
        $('.container_{{$item->id}}').repeater({
            btnAddClass: 'add_{{$item->id}}',
            btnRemoveClass: 'del_{{$item->id}}',
            groupClass: 'group_{{$item->id}}',
            minItems: 1,
            maxItems: 0,
            startingIndex: 0,
            reindexOnDelete: true,
            repeatMode: 'append',
            animation: null,
            animationSpeed: 400,
            animationEasing: 'swing',
            clearValues: true,
        });

        function changeYarnType(id){
            var i = $('#'+id+' option:selected').val();
            var item_id = id.split('_')[2];
            var newId = id.split('_')[3];
            switch(i){
                case '0':
                    $('#color_'+item_id+'_'+newId).attr("disabled","disabled");
                    break;
                case '1':
                    $('#color_'+item_id+'_'+newId).removeAttr('disabled');
                    break;
            }
        }
    </script>
    @endforeach
@endsection