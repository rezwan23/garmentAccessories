@extends('layouts.master')

@section('title', 'All Vendors')

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <h4 class="card-header">All Vendors <span class="float-right">
                        <a href="{{route('vendors.create')}}" class="btn btn-warning btn-sm">Add New</a>
                    </span></h4>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($vendors as $vendor)
                            <tr>
                                <td>{{$loop->index+1}}</td>
                                <td>{{$vendor->name}}</td>
                                <td>
                                    @if($vendor->status)
                                        <a href="{{route('vendor.change.status', $vendor)}}" class="btn btn-sm btn-success">Set To Inactive</a>
                                        <span class="badge badge-success"><i class="fa fa-check"></i></span>
                                    @else
                                        <a href="{{route('vendor.change.status', $vendor)}}" class="btn btn-sm btn-danger">Set To Active</a>
                                        <span class="badge badge-danger"><i class="fa fa-close"></i></span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{route('vendors.edit', $vendor)}}" class="btn btn-primary btn-sm float-left" style="margin-right: 4px;">Edit</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{$vendors->links()}}
                </div>
            </div>
        </div>
    </div>
@endsection
