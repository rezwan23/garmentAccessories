@extends('layouts.master')

@section('title', 'Add Color')

@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <h4 class="card-header">Add new Color
                    <span class="float-right">
                        <a href="{{route('color.index')}}" class="btn btn-warning btn-sm">View all</a>
                    </span>
                </h4>
                <div class="card-body">
                    <form action="{{route('color.store')}}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="" class="control-label">Name</label>
                            <input type="text" class="form-control" name="name">
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection