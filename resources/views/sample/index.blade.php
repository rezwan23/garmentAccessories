@extends('layouts.master')
@section('title', 'All Sample Orders')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <h4 class="card-header">All Sample Orders <span class="float-right">
                        <a href="{{route('sample.order.create')}}" class="btn btn-warning btn-sm">Add New</a>
                    </span><span class="float-right" style="margin-right:4px">
                        <a href="{{route('sample.order.index')}}" class="btn btn-warning btn-sm">View All</a>
                    </span></h4>
                <form action="">
                <div class="row" style="margin-left: 10px;">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label">Select Delivery Date</label>
                            <input type="text" class="form-control" autocomplete="off" value="{{request('delivery_date')}}" id="demoDate2" name="delivery_date">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label">Filter Order</label>
                            <select name="status" id="" class="form-control">
                                <option value="processing">Processing</option>
                                <option value="delivered">Delivered</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <button style="margin-top: 40px;" class="btn btn-primary btn-sm" type="submit">Submit</button>
                        </div>
                    </div>
                </div>
                </form>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Recieve Date</th>
                                <th>Item Name</th>
                                <th>Order No</th>
                                <th>Garments Name</th>
                                <th>Buyer Name</th>
                                <th>Merchant Name</th>
                                <th>Status</th>
                                <th>Delivery Date</th>
                                <th>Delivered Date</th>
                                <th>Delivered By</th>
                                <th>Remarks</th>
                                <th colspan="2">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($orders as $order)
                                <tr>
                                    <td>{{$order->id}}</td>
                                    <td>{{$order->receive_date}}</td>
                                    <td>{{$order->item_name}} - {{$order->size}}</td>
                                    <td>{{$order->order_number}}</td>
                                    <td>{{$order->garments_name}}</td>
                                    <td>{{$order->buyer_name}}</td>
                                    <td>{{$order->merchant_name}}</td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-{{$order->getStatusClass()}} btn-sm @if($order->status=='processing') dropdown-toggle @endif" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                {{$order->getStatus()}}
                                            </button>
                                            @if($order->status=='processing')
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    <a class="dropdown-item" href="{{route('order.deliver', $order)}}">Deliver Order</a>
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                    @php
                                    $flag = 0;
                                    $date = new \Carbon\Carbon();
                                    $date->addDay(3);
                                    if($date>$order->delivery_date)
                                    $flag = 1;
                                    @endphp
                                    <td @if($flag && $order->status!='delivered') class="marked" @endif>{{$order->delivery_date}}</td>
                                    <td>{{$order->delivered_date!=null?$order->delivered_date:'N/A'}}</td>
                                    <td>{{$order->delivery_person!=null?$order->delivery_person:'N/A'}}</td>
                                    <td>{{$order->remarks}}</td>
                                    <td>
                                        <a href="{{route('sample.order.edit', $order)}}" class="btn btn-primary btn-sm float-left"><i class="fa fa-pencil"></i></a>
                                        <form class="float-left" onsubmit="return confirm('Are you sure?')" style="margin-left:4px;" action="{{route('sample.order.destroy', $order->id)}}" method="post">
                                            @method('DELETE')
                                            @csrf
                                            <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                                        </form>
                                    </td>
                                    <td>
                                        @if($order->status=='processing')
                                            <a href="{{route('order.remarks.edit', $order)}}" class="btn btn-primary btn-sm">Edit Remarks</a>
                                        @endif
                                        <button class="btn btn-info btn-sm float-left" data-toggle="modal" data-target="#myModal_{{$loop->index}}">remarks</button>
                                    </td>
                                </tr>
                                <div class="modal fade" id="myModal_{{$loop->index}}">
                                    <div class="modal-dialog">
                                        <div class="modal-content">

                                            <!-- Modal Header -->
                                            <div class="modal-header">
                                                <h4 class="modal-title">Remarks</h4>
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            </div>

                                            <!-- Modal body -->
                                            <div class="modal-body">
                                                <textarea name="" id="" cols="30" disabled rows="3" class="form-control">{{$order->remarks}}</textarea>
                                            </div>
                                            <!-- Modal footer -->
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{$orders->links()}}
                </div>
            </div>
        </div>
    </div>
@endsection
@section('footer')
    <script src="{{asset('admin/js/plugins/bootstrap-datepicker.min.js')}}"></script>
    <script>
        $('#demoDate2').datepicker({
            format: "yyyy-mm-dd",
            autoclose: true,
            todayHighlight: true
        });
        $(document).ready(function(){
            $('body').addClass('sidenav-toggled');
        });
    </script>
    @include('layouts.messages')

    @endsection