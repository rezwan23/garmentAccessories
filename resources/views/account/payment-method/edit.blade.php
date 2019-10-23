@extends('layouts.master')

@section('title', 'Edit Payment Method')

@section('content')
    <div class="row justify-content-md-center">
        <div class="col-md-6">
            <div class="card">
                <h4 class="card-header">Edit Payment Method</h4>
                <div class="card-body">
                    <form id="create-form" action="{{route('paymentMethod.update', $method)}}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="tile-body">
                            <div class="form-group">
                                <label class="control-label">Account</label>
                                <select name="account_id" class="form-control" id="">
                                    @foreach($accounts as $account)
                                        <option @if($method->account_id==$account->id) selected @endif value="{{$account->id}}">{{$account->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Method Name</label>
                                <input class="form-control" type="text" name="name" value="{{$method->name}}" placeholder="Enter Method Name">
                            </div>
                            <div class="form-group">
                                <label class="control-label">Status</label>
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input class="form-check-input" value="1" @if($method->status==1) checked @endif type="radio" name="status">Active
                                    </label>
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="radio" value="0" @if($method->status==0) checked @endif name="status">Inactive
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="tile-footer float-right">
                            <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Create</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection