@extends('layouts.master')

@section('title', 'View Details')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <h4 class="card-header">Payable Account</h4>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>Order No.</th>
                                    <td>{{$account->order_number}}</td>
                                </tr>
                                <tr>
                                    <th>Vendor</th>
                                    <td>{{$account->vendor->name}}</td>
                                </tr>
                                <tr>
                                    <th>Order Date</th>
                                    <td>{{$account->order_date}}</td>
                                </tr>
                                <tr>
                                    <th>Total Amount</th>
                                    <td>{{$account->total_amount}}</td>
                                </tr>
                                <tr>
                                    <th>Due</th>
                                    <td>{{$account->due}}</td>
                                </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <h4 class="card-header">Payable Details</h4>
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Sector</th>
                                    <th>Description</th>
                                    <th>Amount</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($details as $detail)
                                    <tr>
                                        <td>{{$loop->index+1}}</td>
                                        <td>{{$detail->sector->name}}</td>
                                        <td>{{$detail->description}}</td>
                                        <td>{{$detail->amount}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection