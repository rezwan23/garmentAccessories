@extends('layouts.master')

@section('title', 'Party Report')

@section('head')
    <link rel="stylesheet" href="{{ asset('css/jquery-ui.min.css') }}">
@endsection

@section('content')
    @php
        $startDate = request('start-date', date('Y-m-d'));
        $endDate = request('end-date', date('Y-m-d'));
    @endphp
    <div class="tile">
        <div class="d-none d-print-block">
            @component('partials.print-header', ['company' => auth()->user()->company])
                <h4>Party Report Of {{ request('party') }}</h4>
                <p>{!! $startDate !!} To {!! $endDate !!}</p>
            @endcomponent
        </div>
        <div class="tile-title-w-btn d-print-none">
            <h3 class="title">Party Report</h3>
            <p>
            <form class="form-inline">
                <input type="text" value="{{ request('party') }}" placeholder="Enter party name here" name="party" class="form-control mb-2 mr-2">
                <input type="hidden" value="{{ request('party_id') }}" name="party_id">
                <input type="text" value="{!! $startDate !!}" name="start-date" class="form-control date mb-2 mr-sm-2" placeholder="Start Date">

                <input type="text" value="{!! $endDate !!}" name="end-date" class="form-control date mb-2 mr-sm-2" placeholder="End Date">

                <button type="submit" class="btn btn-primary mb-2">Filter</button>
                <button type="button" class="btn btn-secondary mb-2 ml-2" onclick="print()">Print</button>
            </form>
            </p>
        </div>
        @if($party)
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
                @foreach($transactions as $transaction)
                    <tr>
                        <td>{{ $transaction->transactionable->id }}</td>
                        <td>{{ $transaction->payment_date->format('d F, Y') }}</td>
                        <td>{{ $transaction->isDebit() ? $transaction->transactionable->amount() : '---' }}</td>
                        <td>{{ $transaction->isCredit() ? $transaction->transactionable->amount() : '---' }}</td>
                        <td>
                            @php
                                $data[$loop->index] += $transaction->amount();
                                if($loop->first){
                                    echo number_format($data[$loop->index], 2);
                                }else{
                                    echo number_format($data[$loop->index] + $data[$loop->index - 1], 2);
                                }
                                $data[$loop->index + 1] = 0;
                            @endphp
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        @endif
        @include('partials.print-footer')
    </div>
@endsection

@section('footer')
    <script src="/js/jquery-ui.min.js"></script>
    <script src="/admin/js/plugins/bootstrap-datepicker.min.js"></script>
    <script>
        $('.date').datepicker({
            format: 'yyyy-mm-dd',
            autoHide: true
        });
        $('[name=party]').autocomplete({
            source: function (request, response) {
                $.getJSON('{!! route('accounts.parties.index') !!}', {
                    name: request.term
                }, function (parties) {
                    response($.map(parties, function (party) {
                        return {
                            label: party.name + ' - ' + party.phone,
                            party: party
                        };
                    }));
                });
            },
            select: function (elem, ui) {
                $('[name=party_id]').val(ui.item.party.id);
            }
        });
    </script>
@endsection