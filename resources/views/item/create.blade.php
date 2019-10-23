@extends('layouts.master')

@section('title', 'Add New Item')

@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="h4 card-header">Create New Item<span class="float-right">
                        <a href="{{route('item.index')}}" class="btn btn-warning btn-sm">View All</a>
                    </span></div>
                <form action="{{route('item.store')}}" method="post">
                    <div class="card-body">
                        @csrf
                        <div class="form-group">
                            <label class="control-label">Name</label>
                            <input name="name" class="form-control {{$errors->has('name')?'is-invalid':''}}" type="text" required placeholder="Enter Item Name">
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
                                    <option value="{{$unit->id}}">{{$unit->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button class="btn btn-primary float-right"  type="submit">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection