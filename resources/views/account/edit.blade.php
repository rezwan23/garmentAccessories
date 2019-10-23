@extends('layouts.master')

@section('title', 'Edit Accounts')

@section('content')
    <div class="row justify-content-md-center">
        <div class="col-md-12">
            <div class="card">
                <h4 class="card-header">Edit Account</h4>
                <div class="card-body">
                    <form action="{{route('account.update', $account)}}" method="POST" id="create-form">
                        @csrf
                        @method('PUT')
                        <div class="tile-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Account Name</label>
                                        <input class="form-control" name="name" value="{{$account->name}}" type="text" placeholder="Enter Account Name">
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">Account No</label>
                                        <input class="form-control" name="no" value="{{$account->no}}" type="text" placeholder="Enter Account No">
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">Opening Balance</label>
                                        <input class="form-control" name="opening_balance" type="number" min="0" value="{{$account->opening_balance}}" placeholder="Enter Opening Balance">
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">Branch Name</label>
                                        <input class="form-control" name="branch_name" type="text" value="{{$account->brance_name}}" placeholder="Enter Brance Name">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Swift Code</label>
                                        <input class="form-control" name="swift_code" value="{{$account->swift_code}}" type="text"  placeholder="Enter Swift Code">
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">Routing Number</label>
                                        <input class="form-control" name="routing_number" value="{{$account->routing_number}}" type="text" placeholder="Enter Routing Number">
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">Status</label>
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input class="form-check-input" type="radio" value="1" @if($account->status==1) checked @endif name="status">Active
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input class="form-check-input" type="radio" value="0" @if($account->status==0) checked @endif  name="status">Inactive
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tile-footer">
                            <button class="btn btn-primary float-right" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection