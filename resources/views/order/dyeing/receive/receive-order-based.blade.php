@extends('layouts.master')

@section('title', 'Receive Dyeing Yarn')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <h3 class="tile-title">Search JOB ID/Garments Name</h3>
                <div class="tile-body">
                    <div class="row">
                        <div class="col-md-4">
                            <form action="" id="order_form">
                                <div class="form-group">
                                    <input type="text" class="form-control" id="job" autocomplete="off" onkeypress="loadjobs(this.id)">
                                    <input type="hidden" name="order" id="order_id">
                                </div>
                            </form>
                        </div>
                    </div>
                    @if($order->count()>0)
                    <div class="card">
                        <h4 class="card-header">JobID : {{$order->id}} - Materials</h4>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="" class="control-label">Dyeing Company</label>
                                    <input type="text" disabled="disabled" class="form-control" value="{{$order->dyeingCompany?$order->dyeingCompany->name:'N/A'}}">
                                </div>
                                <div class="col-md-3">
                                    <label for="" class="control-label">Address</label>
                                    <input type="text" disabled="disabled" class="form-control" value="{{$order->dyeingCompany?$order->dyeingCompany->address:'N/A'}}">
                                </div>
                            </div>
                        </div>
                        <form action="{{route('yarn.receive.order.based')}}" method="post">

                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="" class="control-label">Receive Date</label>
                                            <input type="text" name="receive_date"  class="form-control" readonly value="{{date('Y-m-d')}}">
                                        </div>
                                    </div>
                                </div>
                                @csrf
                                <input type="hidden" name="order_id" value="{{request()->get('order')}}">
                                <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Accessory</th>
                                    <th>Color</th>
                                    <th>Asigned Quantity</th>
                                    <th>Received Quantity</th>
                                    <th>Receiveng Quantity</th>
                                    <th>Unit</th>
                                    <th>Challan No.</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($order->items as $item)
                                    @foreach($item->requirements as $material)
                                        @if($material->yarn_type)
                                <tr>
                                    <td>{{$loop->index+1}}</td>
                                    <td>
                                        <input type="text" disabled="disabled" class="form-control" value="{{$material->accessory->name}}">
                                        <input type="hidden" name="material_id[]" value="{{$material->id}}">
                                        <input type="hidden" name="accessory_id[]" value="{{$material->accessory->id}}">
                                    </td>
                                    <td>
                                        <input type="text" disabled="disabled" class="form-control" value="{{$material->color->name}}">
                                        <input type="hidden" name="color_id[]" value="{{$material->color_id}}">
                                    </td>
                                    <td><input type="number" disabled="disabled" class="form-control" value="{{$material->quantity}}"></td>
                                    <td><input type="text" disabled="disabled" class="form-control" value="{{$material->getReceivedMaterialCount()}}"></td>
                                    <td><input type="number" class="form-control" max="{{$material->getDueReceiveCount()}}" name="received_quantity[]" required></td>
                                    <td><input type="text" class="form-control" disabled="disabled" value="{{$material->accessory->unit->name}}"></td>
                                    <td><input type="text" class="form-control" name="challan_number[]"></td>
                                </tr>
                                    @endif
                                    @endforeach
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                            <div class="card-footer">
                                <button type="submit" class="float-right btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                    @endif
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
        function loadjobs(id){
            var orders = [];
            @foreach($orders as $order)
                    orders.push('JOB ID {{$order->id}} {{$order->garments->name}}')
            @endforeach
            $('#'+id).autocomplete({
                source: orders,
                select: function(event, ui)
                {
                    var order_id = ui.item.value.split(' ')[2];
                    $('#order_id').val(order_id);
                    $('#order_form').submit();
                }
            })
        }
    </script>
@endsection