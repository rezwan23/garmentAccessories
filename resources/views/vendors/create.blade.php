@extends('layouts.master')

@section('title', 'Add New Vendor')

@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="h4 card-header">Create New Vendor<span class="float-right">
                        <a href="{{route('vendors.index')}}" class="btn btn-warning btn-sm">View All</a>
                    </span></div>
                <form action="{{route('vendors.store')}}" method="post">
                    <div class="card-body">
                        @csrf
                        <div class="form-group">
                            <label class="control-label">Vendor Name</label>
                            <input name="name" class="form-control {{$errors->has('name')?'is-invalid':''}}" type="text" required placeholder="Enter Vendor Name">
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