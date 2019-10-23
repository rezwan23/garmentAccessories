@extends('layouts.master')

@section('title', 'All Garments')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <h4 class="card-header">All Garments <span class="float-right">
                        <a href="{{route('garments.create')}}" class="btn btn-warning btn-sm">Add New</a>
                    </span></h4>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Address</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($garments as $garment)
                            <tr>
                                <td>{{$loop->index+1}}</td>
                                <td>{{$garment->name}}</td>
                                <td>{{$garment->address}}</td>
                                <td>
                                    @if($garment->status)
                                        <a href="{{route('garment.inactive', $garment)}}" class="btn btn-sm btn-success">Set To Inactive</a>
                                        <span class="badge badge-success"><i class="fa fa-check"></i></span>
                                    @else
                                        <a href="{{route('garment.inactive', $garment)}}" class="btn btn-sm btn-danger">Set To Active</a>
                                        <span class="badge badge-danger"><i class="fa fa-close"></i></span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{route('garments.edit', $garment)}}" class="btn btn-primary btn-sm float-left" style="margin-right: 4px;">Edit</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{$garments->links()}}
                </div>
            </div>
        </div>
    </div>
@endsection
