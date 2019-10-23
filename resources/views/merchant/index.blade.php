@extends('layouts.master')

@section('title', 'All Merchant')

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <h4 class="card-header">All Merchants <span class="float-right">
                        <a href="{{route('merchants.create')}}" class="btn btn-warning btn-sm">Add New</a>
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
                        @foreach($merchants as $merchant)
                            <tr>
                                <td>{{$loop->index+1}}</td>
                                <td>{{$merchant->name}}</td>
                                <td>
                                    @if($merchant->status)
                                        <a href="{{route('merchant.inactive', $merchant)}}" class="btn btn-sm btn-success">Set To Inactive</a>
                                        <span class="badge badge-success"><i class="fa fa-check"></i></span>
                                    @else
                                        <a href="{{route('merchant.inactive', $merchant)}}" class="btn btn-sm btn-danger">Set To Active</a>
                                        <span class="badge badge-danger"><i class="fa fa-close"></i></span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{route('merchants.edit', $merchant)}}" class="btn btn-primary btn-sm float-left" style="margin-right: 4px;">Edit</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{$merchants->links()}}
                </div>
            </div>
        </div>
    </div>
@endsection
