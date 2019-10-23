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
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <td>Date</td>
                                <th>Job ID</th>
                                <th>Style Number</th>
                                <th>Garments</th>
                                <th>Merchant</th>
                                <th>Buyer</th>
                                <th>Raw Materials</th>
                                <th>Commercial</th>
                                <th>Delivery Date</th>
                                <th>Delivery Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($orders as $order)
                                <tr>
                                    <td>{{Carbon\Carbon::parse($order->created_at)->format('Y-m-d')}}</td>
                                    <td>{{$order->id}}</td>
                                    <td>{{$order->style_number}}</td>
                                    <td>{{$order->garments->name}}</td>
                                    <td>{{$order->merchant->name}}</td>
                                    <td>{{$order->buyer->name}}</td>
                                    <td>
                                        @if($order->is_assigned)
                                            <a href="{{route('order.requirements.view', $order)}}" class="btn btn-success btn-sm">Show</a>
                                            @can('raw-materials-edit')
                                                <a href="{{route('requirement.edit', $order->id)}}" class="btn btn-primary btn-sm float-left" style="margin-right: 4px;">Edit</a>
                                            @endcan
                                        @else
                                            <a href="{{route('order.assign.requirements.show.form', $order)}}" class="btn btn-info btn-sm">Assign</a>
                                        @endif
                                    </td>
                                    <td>
                                        @if($order->commercial_assigned)
                                            <button class="btn btn-sm btn-success">Assigned</button>
                                        @else
                                            <button class="btn btn-sm btn-warning">Not Assigned</button>
                                        @endif
                                    </td>
                                    @php
                                        $flag = 0;
                                        $date = new \Carbon\Carbon();
                                        $date->addDay(7);
                                        if($date>$order->delivery_date)
                                        $flag = 1;
                                    @endphp
                                    <td @if($flag && !$order->delivery_status) class="marked" @endif>{{$order->delivery_date}}</td>
                                    <td>
                                        <span class="badge badge-{{$order->getDeliveryStatusClass()}}">{{$order->getDeliveryStatus()}}</span>
                                    </td>
                                    {{--<td>--}}
                                    {{--@if($order->is_assigned)--}}
                                    {{--<a target="_blank" href="{{route('order.print.dyeing', [$order, 'print'=>'true'])}}" class="btn btn-success btn-sm">Print</a></td>--}}
                                    {{--@endif--}}
                                    <td>
                                        <a href="{{route('order.show', $order)}}" class="btn btn-warning btn-sm float-left" style="margin-right: 4px;">View</a>
                                        @can('order-edit')
                                            <a href="{{route('order.edit', $order)}}" class="btn btn-primary btn-sm float-left" style="margin-right: 4px;">Edit</a>
                                        @endcan
                                        @can('order-delete')
                                            <form onsubmit="return confirm('Are You Sure?')" method="post" action="{{route('order.destroy', $order->id)}}" class="float-left">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-danger btn-sm" type="submit">Delete</button>
                                            </form>
                                        @endcan
                                            <a href="{{route('order.change.status', $order)}}" class="btn-sm btn btn-warning">Set To Active</a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{$orders->appends(request()->query())->links()}}
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
        $(document).ready(function(){
            $('body').addClass('sidenav-toggled');
        });
    </script>
@endsection
