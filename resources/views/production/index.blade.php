@extends('layouts.master')

@section('title', 'All Production Histories')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <h4 class="card-header">All Production Histories <span class="float-right">
                        <a href="{{route('production.create')}}" class="btn btn-warning btn-sm">Add New</a>
                    </span></h4>
                <div class="tile">
                    <div class="tile-body">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>JobId</th>
                                <th>Production Status</th>
                                <th>Date</th>
                                <th>View</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($productions as $production)
                                <tr>
                                    <td>{{$loop->index+1}}</td>
                                    <td>{{$production->order->id}}</td>
                                    <td>
                                        @if($production->order->production_status)
                                            <span class="badge badge-success">All Produced</span>
                                        @else
                                            <span class="badge badge-warning">Have Due</span>
                                        @endif
                                    </td>
                                    <td>{{\carbon\Carbon::parse($production->created_at)->format('Y-m-d')}}</td>
                                    <td>
                                        <a href="{{route('production.show', $production)}}" class="btn btn-warning btn-sm">View</a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {{$productions->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection