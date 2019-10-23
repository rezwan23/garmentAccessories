@extends('layouts.master')

@section('title', 'Edit Sector')
@section('content')
    <div class="row justify-content-md-center">
        <div class="col-md-6">
            <div class="card">
                <h4 class="card-header">Edit Sector</h4>
                <div class="card-body">
                    <form action="{{route('accountSector.update', $sector)}}" method="POST" id="create-form">
                        @method('PUT')
                        @csrf
                        <div class="tile-body">
                            <div class="form-group">
                                <label class="control-label">Sector Name</label>
                                <input class="form-control" name="name" value="{{$sector->name}}" type="text" placeholder="Enter Sector name">
                            </div>
                            <div class="form-group">
                                <label class="control-label">Sector Type</label>
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="radio" value="1" @if($sector->sector_type==1) checked @endif name="sector_type">Income
                                    </label>
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="radio" @if($sector->sector_type==0) checked @endif  value="0" name="sector_type">Expense
                                    </label>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label">Status</label>
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="radio" value="1" @if($sector->status==1) checked @endif name="status">Active
                                    </label>
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="radio" value="0" @if($sector->status==0) checked @endif name="status">Inactive
                                    </label>
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