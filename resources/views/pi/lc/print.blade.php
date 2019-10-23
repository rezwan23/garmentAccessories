@extends('layouts.master')

@section('title', 'Print LC')
@section('head')
    <style>
        @media print{
            #print{
                display: none;
            }
        }
    </style>
@endsection
@section('content')
    <button id="print" class="btn btn-warning btn-sm float-right" onclick="window.print();">Print</button>
    <div class="row">
        <div class="col-md-6">
            <h4 style="text-transform: uppercase;">{{auth()->user()->company->name}}</h4>
            <p>
                {!! auth()->user()->company->address !!}<br>
                Phone: {{auth()->user()->company->phones}}<br>
                E-Mail: {{auth()->user()->company->emails}}<br>
                Website: {{auth()->user()->company->website}}
            </p>

        </div>
        <div class="col-md-6">
            <h4 style="text-transform: uppercase;color:#000">LC Copy</h4>
            <p>
                Date: {{date('Y-m-d')}}
                <br>
                Lc Number: {{$lc->lc_number}}
                <br>
                Garments: {{$lc->garment_id?$lc->garment->name:'N/A'}}
            </p>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <p><strong>Seller Bank: </strong>{{$lc->seller_bank}}</p>
            <p><strong>Seller Bank Branch: </strong>{{$lc->seller_bank_branch}}</p>
            <p><strong>Buyer Bank: </strong>{{$lc->buyer_bank}}</p>
            <p><strong>Buyer Bank Branch: </strong>{{$lc->buyer_bank_branch}}</p>
            <p><strong>Bank Reference Number: </strong>{{$lc->bank_ref_no}}</p>
        </div>
        <div class="col-md-6">
            <p><strong>Payment Terms : </strong>{{$lc->payment_terms}}</p>
            <p><strong>Document Forward Party Date : </strong>{{$lc->party_date}}</p>
            <p><strong>Document Forward Bank Date : </strong>{{$lc->bank_date}}</p>
            <p><strong>Acceptance Date : </strong>{{$lc->accept_date}}</p>
            <p><strong>Adjust Remarks : </strong>{{$lc->adjust_remarks}}</p>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>SL</th>
                    <th>Proforma Invoice</th>
                    <th>Amount</th>
                </tr>
                </thead>
                <tbody>
                @foreach($lc->lcDetails as $singleData)
                    <tr>
                        <td>{{$loop->index+1}}</td>
                        <td>{{$singleData->serial_number}}</td>
                        <td>{{$singleData->total_value}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <table style="width: 400px;" class="table table-bordered float-right">
                <tr>
                    <th>TOTAL</th>
                    <td>{{$lc->total_value}}</td>
                </tr>
                <tr>
                    <th>CURRENCY</th>
                    <td>USD</td>
                </tr>
            </table>
        </div>
        <div class="col-md-12">
            <h6 style="margin-top:20px;background:#ededed;text-transform: uppercase;">additional details</h6>
            <p>{{auth()->user()->company->additional_details}}</p>
        </div>
        <div class="col-md-4" style="margin-top:80px;">
            <div style="width:100%;height:1px;background:#000"></div>
            <p style="text-transform: uppercase;">authorized signature <br> {{auth()->user()->company->authorize_name}}</p>
        </div>
    </div>
@endsection