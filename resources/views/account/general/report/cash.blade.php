@extends('layouts.master')

@section('title', 'Cash Report')

@section('content')
    @php
        $startDate = request('start-date', date('Y-m-d'));
        $endDate = request('end-date', date('Y-m-d'));
    @endphp
    <div class="tile">
        <div class="d-none d-print-block">
            @component('partials.print-header', ['company' => auth()->user()->company])
                <h4>Cash Report</h4>
                <p>{!! $startDate !!} To {!! $endDate !!}</p>
            @endcomponent
        </div>
        <div class="tile-title-w-btn d-print-none">
            <h3 class="title">Cash Report</h3>
            <p>
            <form class="form-inline">
                <select name="account_id" class="form-control mb-2 mr-sm-2">
                    <option value="">All Accounts</option>
                    @foreach($accounts as $account)
                        <option value="{!! $account->id !!}">{{ $account->name }}</option>
                    @endforeach
                </select>
                <input type="text" value="{!! $startDate !!}" name="start-date" class="form-control date mb-2 mr-sm-2" placeholder="Start Date">

                <input type="text" value="{!! $endDate !!}" name="end-date" class="form-control date mb-2 mr-sm-2" placeholder="End Date">

                <button type="submit" class="btn btn-primary mb-2">Filter</button>
                <button type="button" class="btn btn-secondary mb-2 ml-2" onclick="print()">Print</button>
            </form>
            </p>
        </div>
        <div class="tile-body">
            <table class="table-bordered table table-narrow">
                <thead>
                    <tr>
                        <th>Money Receipt ID</th>
                        <th>Date</th>
                        <th>Debit</th>
                        <th>Credit</th>
                        <th>Balance</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th colspan="4">Previous Balance</th>
                        <th>{{ $data->get(0) }}</th>
                    </tr>
                    @foreach($transactions as $transaction)
                    <tr>
                        <td>{{ $transaction->transactionable->id }}</td>
                        <td>{{ $transaction->payment_date->format('d F, Y') }}</td>
                        <td>{{ $transaction->isDebit() ? $transaction->transactionable->amount() : '---' }}</td>
                        <td>{{ $transaction->isCredit() ? $transaction->transactionable->amount() : '---' }}</td>
                        <td>
                            @php
                                $data[$loop->index + 1] = ($data[$loop->index] + $transaction->amount());
                                echo number_format($data[$loop->index + 1], 2);
                            @endphp
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @include('partials.print-footer')
    </div>
@endsection

@section('footer')
    <script src="/admin/js/plugins/bootstrap-datepicker.min.js"></script>
    <script>
        $('.date').datepicker({
            format: 'yyyy-mm-dd',
            autoHide: true
        });
        $('[name=account_id]').val('{{ request('account_id') }}');
    </script>
@endsection