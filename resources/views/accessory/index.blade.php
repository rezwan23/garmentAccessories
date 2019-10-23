@extends('layouts.master')

@section('title', 'All Accessories')

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <h4 class="card-header">All Raw Materials <span class="float-right">
                        <a href="{{route('accessory.create')}}" class="btn btn-warning btn-sm">Add New</a>
                    </span></h4>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Unit</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($accessories as $accessory)
                            <tr>
                                <td>{{$loop->index+1}}</td>
                                <td>{{$accessory->name}}</td>
                                <td>{{$accessory->accessoryCategory->name}}</td>
                                <td>{{$accessory->unit->name}}</td>
                                <td>
                                    <a href="{{route('accessory.edit', $accessory)}}" class="btn btn-primary btn-sm float-left" style="margin-right: 4px;">Edit</a>
                                    <form method="post" onsubmit="return confirm('Are you sure?')" id="del-form" action="{{route('accessory.destroy',  $accessory)}}">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm" type="submut">Delete</button>
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
