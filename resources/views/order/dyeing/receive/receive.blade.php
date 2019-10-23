@extends('layouts.master')

@section('title', 'Receive Dyeing Yarn')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <h4 class="card-header">Receive Dyeing Yarn</h4>
                <div class="card-body">
                    <div class="tile">
                        <form action="{{route('dyeing.order.receive')}}" method="post">
                            <div class="tile-body">
                                @csrf
                                <div class="row">
                                    <div class="form-group col-md-3">
                                        <label class="control-label">Dyeing Company</label>
                                        <input id="dyeing_company" autocomplete="off" onkeypress="getDyeingCompany(this.id)" required class="form-control" type="text" placeholder="Enter Dyeing Company Name" name="dyeing_company">
                                        <input type="hidden" id="dyeing_company_id" name="dyeing_company_id">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label class="control-label"> Date</label>
                                        <input required class="form-control" id="demoDate" name="receive_date" autocomplete="off" type="text" value="{{date('Y-m-d')}}" placeholder="Select Order Date">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label class="control-label"> JobID</label>
                                        <select name="order_id[]" id="demoSelect" multiple class="form-control">
                                            @foreach($orders as $order)
                                                <option value="{{$order->id}}">{{$order->id}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <h6 class="card-header">Items</h6>
                                        <table class="table table-bordered">
                                            <thead>
                                            <tr>
                                                <th>Raw Materials</th>
                                                <th>Receiving Quantity</th>
                                                <th>Unit</th>
                                                <th>Color</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody class="container1">
                                            <tr class="r-group">
                                                <td>
                                                    <input required type="text" name="accessory[]" autocomplete="off" id="accessory_0" data-pattern-id="accessory_++" data-pattern-name="accessory[++]" onkeypress="getAccessory(this.id)" placeholder="Enter Raw Materials Name" class="form-control">
                                                    <input type="hidden" id="accessory_id_0" name="accessory_id[]" data-pattern-name="accessory_id[++]" data-pattern-id="accessory_id_++"></td>
                                               <td><input type="number" class="form-control" name="quantity[]"  value="0"></td>
                                                <td><input type="text" id="unit_0" data-pattern-id="unit_++" class="form-control" disabled="disabled" value=""></td>
                                                <td>
                                                    <input type="text" name="color[]" onkeypress="loadColors(this.id)" id="color_0" data-pattern-id="color_++" class="form-control">
                                                    <input type="hidden" data-pattern-name="color_id[++]" data-pattern-id="color_id_++" id="color_id_0" name="color_id[]">
                                                </td>
                                                <td><button type="button" class="btn btn-sm small-btn btn-primary r-btnAdd"><i class="fa fa-plus"></i></button>
                                                    <button type="button" class="btn btn-sm small-btn btn-danger r-btnRemove"><i class="fa fa-trash"></i></button>
                                                </td>
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
    <script type="text/javascript" src="{{asset('admin/js/plugins/select2.min.js')}}"></script>
    <script src="{{asset('js/jquery-ui.min.js')}}"></script>
    <script src="{{asset('admin/js/jquery.form-repeater.js')}}"></script>
    <script src="{{asset('admin/js/plugins/bootstrap-datepicker.min.js')}}"></script>
    <script>
        $('#demoSelect').select2();
        $('#demoDate1').datepicker({
            format: "yyyy-mm-dd",
            autoclose: true,
            todayHighlight: true
        });
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
        function getAccessory(id){
            $('#'+id).autocomplete({
                source: function(request, response){
                    $.get('{{route('accessory.get')}}', {'name':request.term}, function(data){
                        response($.map(data, function(accessory){
                            return {
                                label:accessory.name,
                                value:accessory.name,
                                unit:accessory.unit,
                                id:accessory.id,
                            }
                        }));
                    })
                },
                select:function(event, ui){
                    var newId = id.split('_')[1];
                    $('#unit_'+newId).val(ui.item.unit.name);
                    $('#accessory_id_'+newId).val(ui.item.id);
                }
            })
        }
        function loadColors(id){
            $('#'+id).autocomplete({
                source: function(request, response){
                    $.get('{{route('colors.get')}}', {'name':request.term}, function(data){
                        response($.map(data, function(color){
                            return {
                                label:color.name,
                                value:color.name,
                                id:color.id,
                            }
                        }));
                    })
                },
                select:function(event, ui){
                    var newId = id.split('_')[1];
                    $('#color_id_'+newId).val(ui.item.id);
                }
            })
        }
        function getDyeingCompany(id){
            $('#'+id).autocomplete({
                source: function(request, response){
                    $.get('{{route('dyeing.company.all')}}', {'name':request.term}, function(data){
                        response($.map(data, function(company){
                            return {
                                label : company.name,
                                value : company.name,
                                id:company.id,
                            }
                        }));
                    })
                },
                select:function(event, ui){
                    $('#dyeing_company_id').val(ui.item.id);
                }
            })
        }
    </script>
    @endsection