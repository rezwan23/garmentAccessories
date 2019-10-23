@extends('layouts.master')

@section('title', 'Edit Accessory')

@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="h4 card-header">Edit Raw Material<span class="float-right">
                        <a href="{{route('accessory.index')}}" class="btn btn-warning btn-sm">View All</a>
                    </span></div>
                <form action="{{route('accessory.update', $accessory)}}" method="post">
                    @method('PUT')
                    <div class="card-body">
                        @csrf
                        <div class="form-group">
                            <label class="control-label">Name</label>
                            <input name="name" class="form-control {{$errors->has('name')?'is-invalid':''}}" value="{{$accessory->name}}" type="text" required placeholder="Enter Accessory name">
                            @if($errors->has('name'))
                                <span class="invalid-feedback">
                                    <strong>{{$errors->first('name')}}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label class="control-label">Accessory Category</label>
                            <select name="accessory_category_id" id="" class="form-control">
                                @foreach($categories as $category)
                                    <option @if($category->id==$accessory->accessory_category_id) selected="selected" @endif value="{{$category->id}}">{{$category->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Accessory Unit</label>
                            <select name="unit_id" id="" class="form-control">
                                @foreach($units as $unit)
                                    <option @if($unit->id==$accessory->unit_id) selected @endif value="{{$unit->id}}">{{$unit->name}}</option>
                                @endforeach
                            </select>
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