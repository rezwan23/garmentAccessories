@extends('layouts.master')

@section('title', 'All Accessory Categories')

@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <h4 class="card-header">All Raw Materials Categories <span class="float-right">
                        <a href="{{route('accessory_category.create')}}" class="btn btn-warning btn-sm">Add New</a>
                    </span></h4>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($categories as $category)
                            <tr>
                                <td>{{$loop->index+1}}</td>
                                <td>{{$category->name}}</td>
                                <td>
                                    <a href="{{route('accessory_category.edit', $category)}}" class="btn btn-primary btn-sm float-left" style="margin-right: 4px;">Edit</a>
                                    <form method="post" onsubmit="return confirm('Are you sure?')" id="del-form" action="{{route('accessory_category.destroy',  $category)}}">
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
