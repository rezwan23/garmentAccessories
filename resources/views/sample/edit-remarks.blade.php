@extends('layouts.master')
@section('title', 'Edit Remarks')

@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="h4 card-header">Edit Remarks</div>
                <form action="{{route('order.remarks.edit', $order)}}" method="post">
                    @csrf
                    <div class="card-body">
                        @csrf
                        <div class="form-group">
                            <label class="control-label">Remarks</label>
                            <textarea name="remarks" id="" cols="30" rows="3" class="form-control" placeholder="Enter Remarks">{{$order->remarks}}</textarea>
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