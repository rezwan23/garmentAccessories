@extends('layouts.master')

@section('title', 'Debit Payment Voucher')

@section('content')
    <div class="tile">
        <div class="tile-body">
            <div class="text-right d-print-none">
                <button class="btn btn-primary" onclick="window.print()">Print</button>
            </div>
            @component('partials.print-header', ['company' => auth()->user()->company])
                <p class="text-uppercase subtitle">Credit Voucher</p>
            @endcomponent
            <div class="row">
                <div class="col-md-6">
                    <p><b>#Voucher ID: {!! $payment->voucher->id !!}</b><br><b>#Invoice ID: {!! $payment->id !!}</b><br> Receive From: {{ $payment->voucher->party->name }}, {{ $payment->voucher->party->phone }}</p>
                </div>
                <div class="col-md-6 text-right">
                    <p>Date: {{ $payment->payment_date->format('d F, Y') }}</p>
                </div>
            </div>
            <table class="table-bordered table table-narrow">
                <tbody>
                    <tr>
                        <th>Purpose</th>
                        <th>Description</th>
                        <th>Amount</th>
                    </tr>
                    @foreach($payment->records as $record)
                        <tr>
                            <td>{{ $record->sector->name }}</td>
                            <td>{{ $record->voucherSector->description }}</td>
                            <td>{{ $record->amount() }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                <tr>
                    <td colspan="2" class="text-right">Total</td>
                    <td>{{ $payment->amount() }}</td>
                </tr>
                </tfoot>
            </table>
            <p class="text-capitalize">In Word: {!! $payment->amountInWord() !!}</p>
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