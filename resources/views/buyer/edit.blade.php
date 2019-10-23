@extends('layouts.master')

@section('title', 'Edit Buyer')

@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Edit Buyer<span class="float-right">
                        <a href="{{route('buyers.index')}}" class="btn btn-warning btn-sm">View All</a>
                    </span></div>
                <form action="{{route('buyers.update', $buyer)}}" method="post">
                    @method('PUT')
                    <div class="card-body">
                        @csrf
                        <div class="form-group">
                            <label class="control-label">Name</label>
                            <input name="name" class="form-control {{$errors->has('name')?'is-invalid':''}}" value="{{$buyer->name}}" type="text" required placeholder="Enter Buyer name">
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