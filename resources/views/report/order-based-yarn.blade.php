@extends('layouts.master')

@section('title', 'Order Based Yarn')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <h3 class="card-header">Search Order</h3>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <form action="" id="order_form">
                            <div class="form-group">
                                <label for="" class="control-label">Search Job ID</label>
                                <input type="hidden" id="order_id" name="order_id">
                                <input class="form-control" id="order_name" type="text" onkeypress="loadOrders(this.id)">
                            </div>
                            </form>
                        </div>
                    </div>
                    @if($orderDetails->count()>0)
                        <div class="row">
                            <div class="col-md-12">
                                <h6 class="card-header">Job ID: {{$orderDetails->id}}</h6>
                                <div class="card-body">
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th>Yarn</th>
                                            <th>Today In</th>
                                            <th>Today Out</th>
                                            <th>Available Quantity</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($orderDetails->receiveYarns as $receive)
                                            @foreach($receive->materials as $material)
                                                <tr>
                                                    <td>{{$material->accessory->name}}</td>
                                                    <td>{{$material->todayIn()}}</td>
                                                    <td>{{$material->todayOut()}}</td>
                                                    <td>{{$material->availableYarn()}}</td>
                                                </tr>
                                            @endforeach
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
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
        function loadOrders(id){
            var orders = [];
            @foreach($orders as $order)
                    orders.push('{{$order->id}}');
            @endforeach
            $('#'+id).autocomplete({
                source: orders,
                select: function(event, ui){
                    $('#order_id').val(ui.item.value);
                    $('#order_form').submit();
                }
            })
        }
    </script>


@endsection