@extends('layouts.master')

@section('title', 'Income Expense Report')

@section('content')
    @php
        $startDate = request('start-date', date('Y-m-d'));
        $endDate = request('end-date', date('Y-m-d'));
    @endphp
    <div class="tile">
        <div class="d-none d-print-block">
            @component('partials.print-header', ['company' => auth()->user()->company])
                <h4>Income Expense Report</h4>
                <p>{!! $startDate !!} To {!! $endDate !!}</p>
            @endcomponent
        </div>
        <div class="tile-title-w-btn d-print-none">
            <h3 class="title">Income Expense Report</h3>
            <p>
                <form class="form-inline">
                    <input type="text" value="{!! $startDate !!}" name="start-date" class="form-control date mb-2 mr-sm-2" placeholder="Start Date">

                    <input type="text" value="{!! $endDate !!}" name="end-date" class="form-control date mb-2 mr-sm-2" placeholder="End Date">

                    <button type="submit" class="btn btn-primary mb-2">Filter</button>
                    <button type="button" class="btn btn-secondary mb-2 ml-2" onclick="print()">Print</button>
                </form>
            </p>
        </div>
        <div class="tile-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-narrow table-bordered">
                        <thead>
                            <tr>
                                <th colspan="2" class="text-center">Income</th>
                            </tr>
                            <tr>
                                <th>Sector Name</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($incomeSectors as $sector)
                                <tr>
                                    <td>{{ $sector->name }}</td>
                                    <td>{{ $sector->creditAmount->amount() }}</td>
                                </tr>
                             @endforeach
                            <tfoot>
                                <tr>
                                    <th>Total</th>
                                    <th>{!! number_format($incomeSectors->sum('creditAmount.amount'), 2) !!}</th>
                                </tr>
                            </tfoot>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table table-narrow table-bordered">
                        <thead>
                            <tr>
                                <th colspan="2" class="text-center">Expense</th>
                            </tr>
                            <tr>
                                <th>Sector Name</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($expenseSectors as $sector)
                            <tr>
                                <td>{{ $sector->name }}</td>
                                <td>{{ $sector->debitAmount->amount() }}</td>
                            </tr>
                         @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Total</th>
                                <th>{!! number_format($expenseSectors->sum('debitAmount.amount'), 2) !!}</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
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
    </script>
@endsection