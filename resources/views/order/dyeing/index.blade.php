@extends('layouts.master')

@section('title', 'All Dyeing Orders')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <h4 class="card-header">All Dyeing Order
                    <span class="float-right">
                        <a href="{{route('dyeing.order.create')}}" class="btn btn-sm btn-warning">Add New</a>
                    </span>
                </h4>
                <div class="card-body">
                    <div class="tile">
                        <div class="tile-body">
                            <table class="table table-bordered">
                                <thead>
                                <th>Challan ID</th>
                                <th>Dyeing Company</th>
                                <th>Date</th>
                                <th>Delete</th>
                                </thead>
                                <tbody>
                                @foreach($orders as $order)
                                    <tr>
                                        <td><a href="{{route('dyeing.order.challan', $order)}}" class="btn btn-primary btn-sm">{{$order->getChallanId()}}</a></td>
                                        <td>{{$order->dyeingCompany->name}}</td>
                                        <td>{{$order->order_date}}</td>
                                        <td>
                                            <form onsubmit="return confirm('Are You Sure!')" action="{{route('dyeing.order.delete', $order)}}" method="post">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-warning">Delete</button>
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
        </div>
    </div>
@endsection