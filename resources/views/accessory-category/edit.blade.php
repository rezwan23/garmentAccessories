@extends('layouts.master')

@section('title', 'Edit Accessory Category')

@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="h4 card-header">Edit Raw Material Category<span class="float-right">
                        <a href="{{route('accessory_category.index')}}" class="btn btn-warning btn-sm">View All</a>
                    </span></div>
                <form action="{{route('accessory_category.update', $category)}}" method="post">
                    @method('PUT')
                    <div class="card-body">
                        @csrf
                        <div class="form-group">
                            <label class="control-label">Name</label>
                            <input name="name" class="form-control {{$errors->has('name')?'is-invalid':''}}" value="{{$category->name}}" type="text" required placeholder="Enter Category name">
                            @if($errors->has('name'))
                                <span class="invalid-feedback">
                                    <strong>{{$errors->first('name')}}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="card-footer">
                        <button class="btn btn-primary float-right"  type="submit">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection