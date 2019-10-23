@extends('layouts.master')

@section('title', 'All Items')

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <h4 class="card-header">All Items <span class="float-right">
                        <a href="{{route('item.create')}}" class="btn btn-warning btn-sm">Add New</a>
                    </span></h4>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Unit</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($items as $item)
                            <tr>
                                <td>{{$loop->index+1}}</td>
                                <td>{{$item->name}}</td>
                                <td>{{$item->unit->name}}</td>
                                <td>
                                    <a href="{{route('item.edit', $item)}}" class="btn btn-primary btn-sm float-left" style="margin-right: 4px;">Edit</a>
                                    {{--<form method="post" onsubmit="return confirm('Are you sure?')" id="del-form" action="{{route('item.destroy',  $item)}}">--}}
                                        {{--@csrf--}}
                                        {{--@method('DELETE')--}}
                                        {{--<button class="btn btn-danger btn-sm" type="submut">Delete</button>--}}
                                    {{--</form>--}}
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
