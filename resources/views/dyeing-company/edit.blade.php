@extends('layouts.master')

@section('title', 'Edit Dyeing Company')

@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Edit Dyeing Company<span class="float-right">
                        <a href="{{route('dyeing_companies.index')}}" class="btn btn-warning btn-sm">View All</a>
                    </span></div>
                <form action="{{route('dyeing_companies.update', $company)}}" method="post">
                    @method('PUT')
                    <div class="card-body">
                        @csrf
                        <div class="form-group">
                            <label class="control-label">Name</label>
                            <input name="name" class="form-control {{$errors->has('name')?'is-invalid':''}}" value="{{$company->name}}" type="text" required placeholder="Enter Dyeing Company name">
                            @if($errors->has('name'))
                                <span class="invalid-feedback">
                                    <strong>{{$errors->first('name')}}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label class="control-label">Address</label>
                            <textarea name="address" id="" cols="30" rows="4" class="form-control {{$errors->has('address')?'is-invalid':''}}">{{$company->address}}</textarea>
                            @if($errors->has('address'))
                                <span class="invalid-feedback">
                                    <strong>{{$errors->first('address')}}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label class="control-label">Email</label>
                            <input name="emails" class="form-control {{$errors->has('emails')?'is-invalid':''}}" value="{{$company->emails}}" type="text" required placeholder="Enter Dyeing Company emails">
                            @if($errors->has('email'))
                                <span class="invalid-feedback">
                                    <strong>{{$errors->first('email')}}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label class="control-label">Phone Number</label>
                            <input name="phones" class="form-control {{$errors->has('phones')?'is-invalid':''}}" value="{{$company->phones}}" type="text" required placeholder="Enter Garment Phone Number">
                            @if($errors->has('phones'))
                                <span class="invalid-feedback">
                                    <strong>{{$errors->first('phones')}}</strong>
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