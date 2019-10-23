@extends('layouts.master')

@section('title', 'All Order')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <h4 class="card-header">All Order <span class="float-right">
                        <a href="{{route('order.showForm')}}" class="btn btn-warning btn-sm">Add New</a>
                    </span></h4>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>Job ID</th>
                            <th>Garments</th>
                            <th>Merchant</th>
                            <th>Buyer</th>
                            <th>Delivery Date</th>
                            <th>Raw Materials</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($orders as $order)
                            <tr>
                                <td>{{$order->id}}</td>
                                <td>{{$order->garments->name}}</td>
                                <td>{{$order->merchant->name}}</td>
                                <td>{{$order->buyer->name}}</td>
                                <td>{{$order->delivery_date}}</td>
                                <td>
                                    @if($order->is_assigned)
                                        <a href="{{route('order.requirements.view', $order)}}" class="btn btn-success btn-sm">Show Raw Materials</a>
                                    @else
                                        <a href="{{route('order.assign.requirements.show.form', $order)}}" class="btn btn-info btn-sm">Assign Raw Materials</a>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{route('order.show', $order)}}" class="btn btn-warning btn-sm float-left" style="margin-right: 4px;">View</a>
                                    <form onsubmit="return confirm('Are You Sure?')" method="post" action="{{route('order.destroy', $order->id)}}" class="float-left">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm" type="submit">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{$orders->appends(request()->query())->links()}}
                </div>
            </div>
        </div>
    </div>
@endsection
