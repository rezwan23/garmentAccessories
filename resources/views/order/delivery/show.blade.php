@extends('layouts.master')

@section('title', 'Order Show')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <h3 class="card-header">Show Deliveries</h3>
                <div class="card-body">
                    <div class="tile">
                        <div class="tile-body">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Item</th>
                                    <th>Color</th>
                                    <th>Quantity</th>
                                    <th>Challan</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $i=0;?>
                                @foreach($order->deliveries as $delivery)
                                    @foreach($delivery->items as $item)
                                        @if($item->quantity==null)
                                            @continue
                                            @else
                                    <tr>
                                        <td>{{$i+1}}</td>
                                        <td>{{$item->item->name}}</td>
                                        <td>
                                            {{$item->color->name}}
                                        </td>
                                        <td>
                                            {{$item->quantity}}
                                        </td>
                                        <td>
                                            <a href="{{route('delivery.challan', $delivery)}}" class="badge badge-primary">Challan - {{$delivery->id}}</a>
                                        </td>
                                        <td>
                                            <form action="{{route('delivery.record.delete', $item)}}" onsubmit="return confirm('Are You Sure?')" method="post">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-warning btn-sm">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endif
                                        @endforeach
                                    <?php $i++;?>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection