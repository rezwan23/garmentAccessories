@extends('layouts.master')

@section('title', 'All Units')

@section('content')
    <div class="row">
        <div class="col-md-7">
            <div class="card">
                <h4 class="card-header">All Unit <span class="float-right">
                        <a href="{{route('product_unit.create')}}" class="btn btn-warning btn-sm">Add New</a>
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
                        @foreach($units as $unit)
                            <tr>
                                <td>{{$loop->index+1}}</td>
                                <td>{{$unit->name}}</td>
                                <td>
                                    <a href="{{route('product_unit.edit', $unit)}}" class="btn btn-primary btn-sm float-left" style="margin-right: 4px;">Edit</a>
                                    <form method="post" onsubmit="return confirm('Are you sure?')" id="del-form" action="{{route('product_unit.destroy',  $unit)}}">
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
