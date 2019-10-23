@extends('layouts.master')

@section('title', 'Party Bill Report')

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
                <h4>Party Bill Report Of {{ request('party') }}</h4>
                <p class="text-uppercase subtitle">{{ request('type') }}</p>
                <p>{!! $startDate !!} To {!! $endDate !!}</p>
            @endcomponent
        </div>
        <div class="tile-title-w-btn d-print-none">
            <h3 class="title">Party Report</h3>
            <p>
            <form class="form-inline">
                <input type="text" value="{{ request('party') }}" placeholder="Enter party name here" name="party" class="form-control mb-2 mr-2">
                <input type="hidden" value="{{ request('party_id') }}" name="party_id">
                <select name="type" class="form-control mb-2 mr-sm-2">
                    <option value="debit">Debit</option>
                    <option {!! request()->get('type') == 'credit' ? 'selected' : '' !!} value="credit">Credit</option>
                </select>
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
                            <th>Voucher ID</th>
                            <th>Date</th>
                            <th>Purpose</th>
                            <th>Payment Method</th>
                            <th>Bill Amount</th>
                            <th>Payment Amount</th>
                            <th>Balance</th>
                        </tr>
                    </thead>
                    <tbody>
                    @php
                        $billAmount = 0;
                        $paidAmount = 0;
                        $billTotal = 0;
                        $paidTotal = 0;
                    @endphp
                    @if($previous)
                        <?php $billAmount += $previous;?>
                        <tr>
                            <td colspan="6">Opening Balance</td>
                            <td>{{ number_format($previous, 2) }}</td>
                        </tr>
                    @endif
                    @foreach($vouchers as $voucher)
                        <tr>
                            <?php
                                $billAmount += $voucher->total_amount;
                                $billTotal += $voucher->total_amount;
                            ?>
                            <td>V-{{ $voucher->id }}</td>
                            <td>{{ $voucher->created_at->format('d F, Y') }}</td>
                            <td>{{ $voucher->sectors->pluck('sector.name')->implode(', ') }}</td>
                            <td>--</td>
                            <td>{{ $voucher->totalAmount() }}</td>
                            <td>0</td>
                            <td>{{ number_format($billAmount, 2) }}</td>
                        </tr>
                        @foreach($voucher->payments as $payment)
                            <?php $amount = $payment->records->sum('amount');?>

                            <tr>
                                <td>P-{{ $payment->id }}</td>
                                <td>{{ $payment->payment_date->format('d F, Y') }}</td>
                                <td>{{ $payment->records->pluck('sector.name')->implode(', ') }}</td>
                                <td>{{ $payment->paymentMethod->name }}</td>
                                <td>--</td>
                                <td>{{ number_format($amount, 2) }}</td>
                                <?php
                                    $billAmount -= $amount; // r amount
                                    $paidTotal += $amount; // r amount
                                ?>
                                <td>{{ number_format($billAmount, 2) }}</td>
                            </tr>
                        @endforeach
                    @endforeach
                        <tr>
                            <td colspan="4" class="text-right">Total</td>
                            <td>{{ number_format($billTotal, 2) }}</td>
                            <td>{{ number_format($paidTotal, 2) }}</td>
                            <td></td>
                        </tr>
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