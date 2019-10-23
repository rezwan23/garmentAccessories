@extends('layouts.master')
@section('title', 'Add New Supplier')
@section('head')
    <style>
        .card-footer{
            min-height:65px;
        }
    </style>
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <h4 class="card-header">Add New Supplier <span class="float-right">
                        <a href="{{route('yearn_supplier.index')}}" class="btn btn-sm btn-warning">All Supplier</a>
                    </span></h4>
                <form action="{{route('yearn_supplier.store')}}" method="post" style="margin:0">
                    @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Name</label>
                                <input name="name" class="form-control {{$errors->has('name')?'is-invalid':''}}" type="text" placeholder="Enter Supplier name">
                                @if($errors->has('name'))
                                    <span class="invalid-feedback">
                                        <strong>{{$errors->first('name')}}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label class="control-label">Representative</label>
                                <input class="form-control {{$errors->has('representative')?'is-invalid':''}}" type="text" name="representative" placeholder="Enter Supplier Representative"></input>
                                @if($errors->has('representative'))
                                    <span class="invalid-feedback">
                                        <strong>{{$errors->first('representative')}}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label class="control-label">Phone</label>
                                <input class="form-control {{$errors->has('phone')?'is-invalid':''}}" type="text" name="phone" placeholder="Enter Supplier Phone Number">
                                @if($errors->has('phone'))
                                    <span class="invalid-feedback">
                                        <strong>{{$errors->first('phone')}}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label class="control-label">Website Address</label>
                                <input type="text" class="form-control {{$errors->has('website_address')?'is-invalid':''}}" name="website_address" placeholder="Enter Company Website Address">
                                @if($errors->has('website_address'))
                                    <span class="invalid-feedback">
                                        <strong>{{$errors->first('website_address')}}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Address</label>
                                <textarea name="address" id="" cols="30" rows="4" class="form-control {{$errors->has('address')?'is-invalid':''}}" placeholder="Enter Supplier Address"></textarea>
                                @if($errors->has('address'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{$errors->first('address')}}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label class="control-label">Email</label>
                                <input class="form-control {{$errors->has('email')?'is-invalid':''}}" type="email" name="email" placeholder="Enter Supplier Email">
                                @if($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{$errors->first('email')}}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button class="btn btn-primary float-right" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Submit</button>
                </div>
                </form>
            </div>
        </div>
    </div>
@endsection