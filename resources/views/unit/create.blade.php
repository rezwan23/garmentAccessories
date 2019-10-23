@extends('layouts.master')

@section('title', 'Add New Unit')

@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="h4 card-header">Create New Unit<span class="float-right">
                        <a href="{{route('product_unit.index')}}" class="btn btn-warning btn-sm">View All</a>
                    </span></div>
                <form action="{{route('product_unit.store')}}" method="post">
                    <div class="card-body">
                        @csrf
                        <div class="form-group">
                            <label class="control-label">Name</label>
                            <input name="name" class="form-control {{$errors->has('name')?'is-invalid':''}}" type="text" required placeholder="Enter Unit name">
                            @if($errors->has('name'))
                                <span class="invalid-feedback">
                                    <strong>{{$errors->first('name')}}</strong>
                                </span>
                            @endif
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