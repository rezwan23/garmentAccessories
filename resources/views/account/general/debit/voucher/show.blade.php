@extends('layouts.master')

@section('title', 'Debit Voucher')

@section('head')
    <link rel="stylesheet" href="{{asset('css/jquery-ui.min.css')}}">
@endsection

@section('content')
    <div class="tile">
        <div class="tile-body">
            <div class="text-right d-print-none">
                <button class="btn btn-primary" onclick="window.print()">Print</button>
            </div>
            @component('partials.print-header', ['company' => auth()->user()->company])
                <p class="text-uppercase subtitle">Debit Voucher</p>
            @endcomponent
            <div class="row">
                <div class="col-md-6">
                    <p><b>#Invoice ID: {!! $debitVoucher->id !!}</b><br> Paid to: {{ $debitVoucher->party->name }}, {{ $debitVoucher->party->phone }}</p>
                </div>
                <div class="col-md-6 text-right">
                    <p>Date: {{ $debitVoucher->date->format('d F, Y') }}</p>
                </div>
            </div>
            <table class="table-bordered table table-narrow">
                <tbody>
                    <tr>
                        <td colspan="3" class="text-center">Particulars</td>
                    </tr>
                    <tr>
                        <th>Purpose</th>
                        <th>Description</th>
                        <th>Amount</th>
                    </tr>
                    @foreach($debitVoucher->sectors as $sector)
                    <tr>
                        <td>{{ $sector->sector->name }}</td>
                        <td>{{ $sector->description }}</td>
                        <td>{{ $sector->amount() }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="2" class="text-right">Total</th>
                        <th>{{ $debitVoucher->totalAmount() }}</th>
                    </tr>
                </tfoot>
            </table>
            <p class="text-capitalize">In Word: {!! $debitVoucher->totalInWord() !!}</p>
            @include('partials.print-footer')
        </div>
    </div>
@endsection

@section('footer')
    <script>
        @if(request()->has('auto-print'))
            window.print();
        @endif
    </script>
@endsection