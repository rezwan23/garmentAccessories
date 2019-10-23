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
                    <h4>Filter Order</h4>
                    <form action="">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="Status">Select Status</label>
                                    <select name="delivery_status" id="" class="form-control">
                                        <option value="0" @if(request('delivery_status')==0) selected @endif>Have Due</option>
                                        <option value="1" @if(request('delivery_status')==1) selected @endif>All Delivered</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="Status">Job ID</label>
                                    <input type="text" value="{{request()->get('job_id')}}"  name="job_id" onkeypress="loadorders(this.id)" class="form-control" id="orders_autocomplete">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="Status">Select Pi Serial Number</label>
                                    <input type="text" value="{{request()->get('pi')}}"  name="pi" onkeypress="loadLcs(this.id)" class="form-control" id="lcs_autocomplete">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="Status">Select Style Number</label>
                                    <input type="text" value="{{request()->get('style')}}"  name="style" class="form-control" id="lcs_autocomplete">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="Status">Select Garments</label>
                                    <input type="text" value="{{request()->get('garments')}}"  name="garments" onkeypress="loadGarments(this.id)" class="form-control" id="garments_autocomplete">
                                </div>
                            </div>
                            <div class="col-md-1">
                                <div class="form-group">
                                    <label style="display: block" for="Status">Filter</label>
                                    <input type="submit" class="btn btn-primary" value="Filter">
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <td>Date</td>
                                <th>Job ID</th>
                                <th>Style Number</th>
                                <th>PI</th>
                                <th>Items</th>
                                <th>Garments</th>
                                <th>Merchant</th>
                                <th>Buyer</th>
                                <th>Raw Materials</th>
                                <th>Commercial</th>
                                <th>Delivery Date</th>
                                <th>Delivery Status</th>
                                {{--<th>Raw Materials</th>--}}
                                {{--<th>Total Amount</th>--}}
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($orders as $order)
                                <tr>
                                    <td>{{Carbon\Carbon::parse($order->created_at)->format('Y-m-d')}}</td>
                                    <td>{{$order->id}}</td>
                                    <td>{{$order->style_number}}</td>
                                    <td>{{$order->pis?$order->pis->pluck('serial_number')->implode(','):'N/A'}}</td>
                                    <td>@foreach($order->items as $item){{
                                        $item->item->name.','
                                    }}@endforeach</td>
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
                                        @if($order->is_active)
                                            @can('inactive-order')
                                                <a href="{{route('order.change.status', $order)}}" class="btn-sm btn btn-warning">Inactive</a>
                                            @endcan
                                        @endif
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
    <script>
        function loadGarments(id){
            var garments = [];
            @foreach($garments as $garment)
                garments.push('{{$garment->name}}');
            @endforeach
            $('#'+id).autocomplete({
                source:garments,
            })
        }
        function loadorders(id){
            var orders = [];
            @foreach($allOrders as $order)
            orders.push('{{$order->id}}');
            @endforeach
            $('#'+id).autocomplete({
                source:orders,
            })
        }

        function loadLcs(id){
            var pis = [];
            @foreach($pis as $pi)
            @if($pi->serial_number)
            pis.push('{{$pi->serial_number}}');
            @endif
            @endforeach
            $('#'+id).autocomplete({
                source:pis,
            })
        }
    </script>
@endsection
