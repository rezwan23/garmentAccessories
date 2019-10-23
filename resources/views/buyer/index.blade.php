@extends('layouts.master')

@section('title', 'All Buyers')

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <h4 class="card-header">All Buyers <span class="float-right">
                        <a href="{{route('buyers.create')}}" class="btn btn-warning btn-sm">Add New</a>
                    </span></h4>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <td>Status</td>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($buyers as $buyer)
                            <tr>
                                <td>{{$loop->index+1}}</td>
                                <td>{{$buyer->name}}</td>
                                <td>
                                    @if($buyer->status)
                                        <a href="{{route('buyer.inactive', $buyer)}}" class="btn btn-sm btn-success">Set To Inactive</a>
                                        <span class="badge badge-success"><i class="fa fa-check"></i></span>
                                    @else
                                        <a href="{{route('buyer.inactive', $buyer)}}" class="btn btn-sm btn-danger">Set To Active</a>
                                        <span class="badge badge-danger"><i class="fa fa-close"></i></span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{route('buyers.edit', $buyer)}}" class="btn btn-primary btn-sm float-left" style="margin-right: 4px;">Edit</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{$buyers->links()}}
                </div>
            </div>
        </div>
    </div>
@endsection
