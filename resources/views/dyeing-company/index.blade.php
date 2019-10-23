@extends('layouts.master')

@section('title', 'All Dyeing Companies')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <h4 class="card-header">All Dyeing Companies <span class="float-right">
                        <a href="{{route('dyeing_companies.create')}}" class="btn btn-warning btn-sm">Add New</a>
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
                        @foreach($companies as $company)
                            <tr>
                                <td>{{$loop->index+1}}</td>
                                <td>{{$company->name}}</td>
                                <td>{{$company->address}}</td>
                                <td>
                                    @if($company->status)
                                        <a href="{{route('dyeing.inactive', $company)}}" class="btn btn-sm btn-success">Set To Inactive</a>
                                        <span class="badge badge-success"><i class="fa fa-check"></i></span>
                                    @else
                                        <a href="{{route('dyeing.inactive', $company)}}" class="btn btn-sm btn-danger">Set To Active</a>
                                        <span class="badge badge-danger"><i class="fa fa-close"></i></span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{route('dyeing_companies.edit', $company)}}" class="btn btn-primary btn-sm float-left" style="margin-right: 4px;">Edit</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{$companies->links()}}
                </div>
            </div>
        </div>
    </div>
@endsection
