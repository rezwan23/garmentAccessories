@extends('layouts.master')

@section('title', 'Add New Dyeing Company')

@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="h4 card-header">Create New Dyeing Company<span class="float-right">
                        <a href="{{route('dyeing_companies.index')}}" class="btn btn-warning btn-sm">View All</a>
                    </span></div>
                <form action="{{route('dyeing_companies.store')}}" method="post">
                    <div class="card-body">
                        @csrf
                        <div class="form-group">
                            <label class="control-label">Dyeing Company Name</label>
                            <input name="name" class="form-control {{$errors->has('name')?'is-invalid':''}}" type="text" required placeholder="Enter Dyeing Company Name">
                            @if($errors->has('name'))
                                <span class="invalid-feedback">
                                    <strong>{{$errors->first('name')}}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label class="control-label">Address</label>
                            <textarea name="address" id="" cols="30" rows="4" class="form-control {{$errors->has('address')?'is-invalid':''}}" placeholder="Dyeing Company Address"></textarea>
                            @if($errors->has('address'))
                                <span class="invalid-feedback">
                                    <strong>{{$errors->first('address')}}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label class="control-label">Dyeing Company Emails</label>
                            <input name="emails" class="form-control {{$errors->has('emails')?'is-invalid':''}}" type="text" required placeholder="Enter Dyeing Company Emails">
                            @if($errors->has('emails'))
                                <span class="invalid-feedback">
                                    <strong>{{$errors->first('emails')}}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label class="control-label">Phone Number</label>
                            <input name="phones" class="form-control {{$errors->has('phones')?'is-invalid':''}}" type="text" required placeholder="Enter Dyeing Company Phone Numbers">
                            @if($errors->has('phones'))
                                <span class="invalid-feedback">
                                    <strong>{{$errors->first('phones')}}</strong>
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