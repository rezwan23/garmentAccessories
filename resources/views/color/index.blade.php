@extends('layouts.master')

@section('title', 'All Colors')

@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <h4 class="card-header">All Colors
                    <span class="float-right">
                        <a href="{{route('color.create')}}" class="btn btn-warning btn-sm">Add New</a>
                    </span>
                </h4>
                <table class="table table-bordered">
                   <thead>
                   <tr>
                       <th>#</th>
                       <th>Name</th>
                       <th>Delete</th>
                   </tr>
                   </thead>
                    <tbody>
                    @foreach($colors as $color)
                    <tr>
                        <td>{{$loop->index+1}}</td>
                        <td>{{$color->name}}</td>
                        <td>
                            <form action="{{route('color.destroy', $color)}}" method="post">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection