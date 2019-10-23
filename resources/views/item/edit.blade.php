@extends('layouts.master')

@section('title', 'Edit Item')

@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="h4 card-header">Edit Item<span class="float-right">
                        <a href="{{route('item.index')}}" class="btn btn-warning btn-sm">View All</a>
                    </span></div>
                <form action="{{route('item.update', $item)}}" method="post">
                    @method('PUT')
                    <div class="card-body">
                        @csrf
                        <div class="form-group">
                            <label class="control-label">Name</label>
                            <input name="name" class="form-control {{$errors->has('name')?'is-invalid':''}}" value="{{$item->name}}" type="text" required placeholder="Enter Item name">
                            @if($errors->has('name'))
                                <span class="invalid-feedback">
                                    <strong>{{$errors->first('name')}}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label class="control-label">Item Unit</label>
                            <select name="unit_id" id="" class="form-control">
                                @foreach($units as $unit)
                                    <option @if($unit->id==$item->unit_id) selected @endif value="{{$unit->id}}">{{$unit->name}}</option>
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