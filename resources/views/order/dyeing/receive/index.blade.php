@extends('layouts.master')

@section('title', 'Receive Records')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <h4 class="card-header">All Receive Record</h4>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>JobID</th>
                            <th>Receive Status</th>
                            <th>Show Materials</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($orders as $order)
                            <tr>
                                <td>{{$loop->index+1}}</td>
                                <td>{{$order->id}}</td>
                                <td>
                                    @if($order->received_raw) <span class="badge badge-success">All received</span>
                                    @else
                                        <span class="badge badge-warning">have due</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{route('receive.material.show', $order)}}" class="btn btn-primary btn-sm">Show</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
