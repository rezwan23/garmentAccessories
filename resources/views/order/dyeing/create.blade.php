@extends('layouts.master')

@section('title', 'Add Dyeing order')

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <h4 class="card-header"> New Dyeing Assign <span class="float-right">
                        <a href="{{route('dyeing.order.index')}}" class="btn btn-sm btn-warning">View All</a>
                    </span></h4>
                <div class="card-body">
                    <div class="tile">
                        <form action="{{route('dyeing.order.store')}}" method="post">
                        <div class="tile-body">
                            @csrf
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <label class="control-label">Dyeing Company</label>
                                    <input id="dyeing_company" autocomplete="off" onkeypress="getDyeingCompany(this.id)" required class="form-control" type="text" placeholder="Enter Dyeing Company Name" name="dyeing_company">
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="control-label">Address</label>
                                    <input id="address" class="form-control" type="text" placeholder="Enter Dyeing Company Address" autocomplete="off" name="address">
                                </div>
                                <div class="form-group col-md-3">
                                    <label class="control-label">Order Date</label>
                                    <input required class="form-control" id="demoDate" name="order_date" autocomplete="off" type="text" placeholder="Select Order Date">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <h6 class="card-header">Items</h6>
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th>Raw Materials</th>
                                            <th>Quantity</th>
                                            <th>Unit</th>
                                            <th>Remarks</th>
                                            <th width="18%">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody class="container1">
                                        <tr class="r-group">
                                            <td>
                                                <input required id="accessory_0" data-pattern-id="accessory_++" type="text" data-pattern-name="accessory[++]" name="accessory[]" autocomplete="off" onkeypress="getAccessory(this.id)" placeholder="Enter Raw Materials Name" class="form-control">
                                                <input required id="accessory_id_0" data-pattern-id="accessory_id_++" type="hidden" value="-1" data-pattern-name="accessory_id[++]" name="accessory_id[]">
                                            </td>
                                            <td><input id="quantity_0" data-pattern-id="quantity_++" required type="number" data-pattern-name="quantity[++]" name="quantity[]" class="form-control" autocomplete="off" placeholder="Raw Material quantity"></td>
                                            <td><input type="text" class="form-control" name="unit[]" data-pattern-name="unit[++]" id="unit_0" data-pattern-id="unit_++" readonly></td>
                                            <td><input required id="remarks_0" data-pattern-id="remarks_++" type="text" data-pattern-name="remarks[++]" name="remarks[]" autocomplete="off" placeholder="Remarks" class="form-control"></td>
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
                                    {{--<h6 class="card-header">Delivery Details</h6>--}}
                                    <table class="table table-bordered float-right">
                                        <tbody>
                                        {{--<tr>--}}
                                            {{--<th>Dilivery Date</th>--}}
                                            {{--<td><input required type="text" class="form-control" id="demoDate1" autocomplete="off" name="delivery_date"></td>--}}
                                        {{--</tr>--}}
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
        });
    </script>
    <script>

        $('#demoDate').datepicker({
            format: "yyyy-mm-dd",
            autoclose: true,
            todayHighlight: true
        });
        function getAccessory(id){
            $('#'+id).autocomplete({
                source:function(request, response){
                    $.get('{{route('accessories.get')}}', {'name':request.term}, function(data){
                        response($.map(data, function(acc){
                            return {
                                label : acc.name,
                                value : acc.name,
                                id  : acc.id,
                                unit : acc.unit.name
                            }
                        }))
                    })
                },select:function(event, ui){
                    var newId = id.split('_')[1]
                    $('#accessory_id_'+newId).val(ui.item.id);
                    $('#unit_'+newId).val(ui.item.unit);
                }
            })
        }
    </script>

    <script>
        function getDyeingCompany(id){
            $('#'+id).autocomplete({
                source: function(request, response){
                    $.get('{{route('dyeing.company.all')}}', {'name':request.term}, function(data){
                        response($.map(data, function(company){
                            return {
                                label : company.name,
                                value : company.name,
                                address : company.address,
                            }
                        }));
                    })
                },
                select : function(event, ui){
                    $('#address').val(ui.item.address);
                }
            })
        }
    </script>
@endsection