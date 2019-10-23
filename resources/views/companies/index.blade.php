@extends('layouts.master')

@section('title', 'All Companies')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <h4 class="card-header">All Companies <span class="float-right">
                        <a href="{{route('company.create')}}" class="btn btn-warning btn-sm">Add New</a>
                    </span></h4>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>address</th>
                            <th>Emails</th>
                            <th>Phones</th>
                            <th>Logo</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($companies as $company)
                            <tr>
                                <td>{{$loop->index+1}}</td>
                                <td>{{$company->name}}</td>
                                <td>{{$company->address}}</td>
                                <td>{{$company->emails}}</td>
                                <td>{{$company->phones}}</td>
                                <td>
                                    <img src="{{asset('uploads/'.$company->logo)}}" height="25px" width="25px" alt="">
                                </td>
                                <td>
                                    {{--<a href="{{route('company.edit', $company)}}" style="margin-right: 4px;" class="float-left btn btn-warning btn-sm">Edit</a>--}}
                                    <form action="{{route('company.destroy', $company)}}" class="float-left" onsubmit="return confirm('Are You Sure?')">
                                        <button class="btn btn-danger btn-sm" type="submit">Delete</button>
                                    </form>
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