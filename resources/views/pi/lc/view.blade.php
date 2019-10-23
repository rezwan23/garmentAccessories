@extends('layouts.master')

@section('title', 'Create Lc Document')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <h4 class="card-header">New LC Document <span class="float-right">
                        <a href="{{route('lc.index')}}" class="btn btn-warning btn-sm">View All</a>
                    </span></h4>
                <div class="card-body">
                        <div class="tile">
                            <div class="tile-body">
                                <div class="row">
                                    <div class="form-group col-md-3">
                                        <label class="control-label">Seller Bank</label>
                                        <input disabled value="{{$lc->seller_bank}}" name="seller_bank" autocomplete="off" class="form-control" type="text" placeholder="Enter Seller Bank Name">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label class="control-label">Seller Bank Branch</label>
                                        <input disabled value="{{$lc->seller_bank_branch}}" name="seller_bank_branch" autocomplete="off" class="form-control" type="text" placeholder="Enter Seller Bank Branch">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label class="control-label">Buyer Bank</label>
                                        <input  disabled value="{{$lc->buyer_bank}}" name="buyer_bank" autocomplete="off" class="form-control" type="text" placeholder="Enter Buyer Bank Name">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label class="control-label">Buyer Bank Branch</label>
                                        <input  disabled value="{{$lc->buyer_bank_branch}}" name="buyer_bank_branch" autocomplete="off" class="form-control" type="text" placeholder="Enter Buyer Bank Branch">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label class="control-label">LC Number</label>
                                        <input  disabled value="{{$lc->lc_number}}" name="lc_number" autocomplete="off" class="form-control" type="text" placeholder="Enter LC Number">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label class="control-label">Payment terms</label>
                                        <input disabled value="{{$lc->payment_terms}}" name="payment_terms" autocomplete="off" class="form-control" type="text" placeholder="Enter Payment terms">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label class="control-label">Document Forward Party Date</label>
                                        <input  disabled value="{{$lc->party_date}}" id="date1" name="party_date" autocomplete="off" class="form-control" type="text" placeholder="Enter Doc forward party date">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label class="control-label">Document Forward Bank Date</label>
                                        <input disabled value="{{$lc->bank_date}}" id="date2" name="bank_date" autocomplete="off" class="form-control" type="text" placeholder="Enter Doc forward bank date">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label class="control-label">Acceptance date</label>
                                        <input disabled value="{{$lc->accept_date}}" id="date3" name="accept_date" autocomplete="off" class="form-control" type="text" placeholder="Enter Acceptance date">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label class="control-label">Adjust Remarks</label>
                                        <input disabled value="{{$lc->adjust_remarks}}" id="date4" name="adjust_remarks" autocomplete="off" class="form-control" type="text" placeholder="Enter Adjust Remarks">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label class="control-label">Garments</label>
                                        <input readonly id="garment" value="{{$lc->garment?$lc->garment->name:''}}"  autocomplete="off" class="form-control" type="text" placeholder="Enter Garment">
                                        <input type="hidden" id="garment_id" name="garment_id">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label class="control-label">Bank Ref.</label>
                                        <input id="bank_ref" readonly  autocomplete="off" value="{{$lc->bank_ref_no}}" name="bank_ref_no" class="form-control" type="text" placeholder="Enter Bank Ref No.">
                                    </div>
                                </div>
                            </div>
                            @csrf
                            <div class="tile-body">
                                <h4 class="card-header"> Details</h4>
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th>Serial(PI)</th>
                                        <th>Total</th>
                                    </tr>
                                    </thead>
                                    <tbody class="container_1">
                                    @foreach($lc->lcDetails as $details)
                                    <tr class="group_1">
                                        <td>
                                            <input disabled value="{{$details->serial_number}}" class="form-control" type="text" onkeypress="loadSerialNumber(this.id)" name="serial_number[0]" data-pattern-name="serial_number[++]" id="serial_0" data-pattern-id="serial_++">
                                        </td>
                                        <td>
                                            <input disabled value="{{ number_format($details->total_value, 2) }} USD" class="form-control each_total" type="text" name="total_value[0]" data-pattern-name="total_value[++]" id="total_0" data-pattern-id="total_++">
                                        </td>
                                    </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="col-md-4"></div>
                                <div class="col-md-4"></div>
                                <div class="col-md-4">
                                    <div class="card">
                                        <h4 class="card-header">Total</h4>
                                        <div class="card-body">
                                            <input type="text" id="subtotal" disabled value="{{$lc->total_value}}" name="all_total" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
@endsection