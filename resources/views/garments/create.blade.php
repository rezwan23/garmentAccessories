@extends('layouts.master')

@section('title', 'Add New Garment')

@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="h4 card-header">Create New Garment<span class="float-right">
                        <a href="{{route('garments.index')}}" class="btn btn-warning btn-sm">View All</a>
                    </span></div>
                <form action="{{route('garments.store')}}" method="post">
                    <div class="card-body">
                        @csrf
                        <div class="form-group">
                            <label class="control-label">Garment Name</label>
                            <input name="name" class="form-control {{$errors->has('name')?'is-invalid':''}}" type="text" required placeholder="Enter Garment Name">
                            @if($errors->has('name'))
                                <span class="invalid-feedback">
                                    <strong>{{$errors->first('name')}}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label class="control-label">Address</label>
                            <textarea name="address" id="" cols="30" rows="4" class="form-control {{$errors->has('address')?'is-invalid':''}}" placeholder="Garment Address"></textarea>
                            @if($errors->has('address'))
                                <span class="invalid-feedback">
                                    <strong>{{$errors->first('address')}}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label class="control-label">Garment Email</label>
                            <input name="email" class="form-control {{$errors->has('email')?'is-invalid':''}}" type="text" required placeholder="Enter Garment Email">
                            @if($errors->has('email'))
                                <span class="invalid-feedback">
                                    <strong>{{$errors->first('email')}}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label class="control-label">Phone Number</label>
                            <input name="phone_number" class="form-control {{$errors->has('phone_number')?'is-invalid':''}}" type="text" required placeholder="Enter Garment Phone Number">
                            @if($errors->has('phone_number'))
                                <span class="invalid-feedback">
                                    <strong>{{$errors->first('phone_number')}}</strong>
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