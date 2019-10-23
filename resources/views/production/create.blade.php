@extends('layouts.master')
@section('title', 'Create Production')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <h4 class="card-header">Create Production
                    <span class="float-right">
                        <a href="{{route('production.index')}}" class="btn btn-warning btn-sm">View All</a>
                    </span>
                </h4>
                <div class="card-body">
                    <div class="tile">
                        <div class="tile-body">
                            <form id="job_id_form" action="">
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label class="control-label">Search Job ID</label>
                                            <input type="hidden" name="order_id" id="order_id">
                                            <input id="order" class="form-control" onkeypress="loadJobs(this.id)" autocomplete="off" type="text" placeholder="Type Job Id/Garments">
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                @if($job->count()>0)
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-md-2">
                                <label class="control-label">Job ID : <span class="strong">{{$job->id}}</span></label>
                                {{--<input id="garments_name" disabled="disabled" value="{{$orderDetails->id}}" autocomplete="off" required="" class="form-control" type="text" placeholder="Enter Garments Name" name="garments_name">--}}
                            </div>
                            <div class="form-group col-md-3">
                                <label class="control-label">Garments Name : <span class="strong">{{$job->garments->name}}</span></label>
                                {{--<input id="garments_name" value="{{$orderDetails->garments->name}}" autocomplete="off" required="" class="form-control" type="text" placeholder="Enter Garments Name" name="garments_name">--}}
                            </div>
                            <div class="form-group col-md-3">
                                <label class="control-label">Buyer Name : <span class="strong">{{$job->buyer->name}}</span></label>
                                {{--<input id="buyer_name" autocomplete="off" value="{{$orderDetails->buyer->name}}" required="" class="form-control" type="text" placeholder="Enter Buyer Name" name="buyer_name">--}}
                            </div>
                            <div class="form-group col-md-3">
                                <label class="control-label">Order Date : <span class="strong">{{$job->order_date}}</span></label>
                                {{--<input required="" class="form-control" value="{{$orderDetails->order_date}}" id="demoDate" name="order_date" autocomplete="off" type="text" placeholder="Select Order Date">--}}
                            </div>
                        </div>
                    </div>
                <div class="card-body">
                    <form action="{{route('production.store')}}" method="post">
                        <input type="hidden" name="order_id" value="{{$job->id}}">
                        @csrf
                        <div class="tile">
                            <div class="tile-body">
                                <input type="hidden" name="job_id" value="{{$job->id}}">
                                <h3 class="card-header">Item</h3>
                                @foreach($job->items as $item)
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th width="22%">Item</th>
                                            <th>Size</th>
                                            <th>Color</th>
                                            <th>Order Quantity</th>
                                            <th>Produced Quantity</th>
                                            <th>Due Quantity</th>
                                            <th width="15%">Today Quantity</th>
                                            <th>Unit</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td><input type="text" value="{{$item->item->name}}" class="form-control" disabled="disabled">
                                                <input type="hidden" name="item_id[{{$item->id}}]" value="{{$item->item->id}}"></td>
                                            <td>
                                                <input type="text" value="{{$item->size}}" class="form-control" disabled="disabled">
                                            </td>

                                            <td>
                                                <input type="text" disabled="disabled" class="form-control" value="{{$item->color->name}}">
                                                <input type="hidden" name="item_color_id[{{$item->id}}]" value="{{$item->color->id}}">
                                            </td>
                                            <td><input type="text" value="{{$item->quantity}}" class="form-control" disabled="disabled"></td>
                                            <td><input type="text" disabled="disabled" class="form-control" value="{{$item->getProducedQuantity()}}"></td>
                                            <td><input type="text" disabled class="form-control" value="{{$item->dueQuantity()}}"></td>
                                            <td><input class="form-control" type="number" max="{{$item->dueQuantity()}}" name="item_quantity[{{$item->id}}]" min="0" value="0"></td>
                                            <td><input class="form-control" type="text" disabled="disabled" value="{{$item->item->unit->name}}"></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <h3 class="card-header">Raw Materials</h3>
                                    <div class="card-body">
                                        <table class="table table-bordered">
                                            <thead>
                                            <tr>
                                                <th>Raw Materials</th>
                                                <th>Type</th>
                                                <th>Assinged Quantity</th>
                                                <th>Unit</th>
                                                <th>Color</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($item->requirements as $material)
                                                <tr>
                                                    <td><input type="text" class="form-control" readonly value="{{$material->accessory->name}}">
                                                        <input type="hidden" name="accessory_id[{{$item->id}}][{{$loop->index}}]" value="{{$material->accessory->id}}">
                                                        <input type="hidden" name="material_id[{{$item->id}}][{{$loop->index}}]" value="{{$material->id}}">
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control" disabled="disabled" value="{{$material->yarn_type?'Dyeing Yarn':'Raw Materials'}}">
                                                    </td>
                                                    <td>
                                                        <input type="number" class="form-control" disabled="disabled" value="{{$material->quantity}}">
                                                    </td>
                                                    <td>
                                                        <input type="text" disabled class="form-control" value="{{$material->accessory->unit->name}}">
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control" disabled="disabled" value="{{$material->yarn_type?$material->color->name:''}}">
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @endforeach
                            </div>
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
                @endif
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
        function loadJobs(id){
            var jobs = [];
            @foreach($jobs as $job)
            jobs.push('Job ID-'+'{{$job->id}}'+'-'+'{{$job->garments->name}}');
            @endforeach
            $('#'+id).autocomplete({
                'source'   :    jobs,
                select: function(event, ui){
                    $('#order_id').val(ui.item.value.split('-')[1]);
                    $('#job_id_form').submit();
                }
            })
        }
        function typeToggle(name){
            var id = name.split('_')[1];
            var value = $('.'+name+':checked').val();
            switch(value){
                case '1':
                    $('#yarn_color_id_'+id).removeAttr('disabled', 'disabled');
                    break;
                default:
                    $('#yarn_color_id_'+id).attr('disabled', 'disabled');
                    break;
            }
        }
        </script>
@endsection