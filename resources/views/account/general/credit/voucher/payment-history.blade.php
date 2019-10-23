@extends('layouts.master')

@section('title', 'Voucher Payment History')

@section('content')
    <div class="tile">
        <div class="tile-title-w-btn">
            <h3 class="title">Credit Payment History #{{ $voucher->id }}</h3>
            <p>
                <a href="{!! route('accounts.credit-vouchers.index') !!}" class="btn btn-primary">Back</a>
            </p>
        </div>
        <div class="tile-body">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Date</th>
                    <th>Account Name</th>
                    <th>Payment Method</th>
                    <th>Cheque No/REF ID</th>
                    <th>User</th>
                    <th>Options</th>
                </tr>
                </thead>
                <tbody>
                @foreach($payments as $payment)
                    <tr>
                        <td>{{ $payment->id }}</td>
                        <td>{{ $payment->payment_date->format('d F, Y') }}</td>
                        <td>{{ $payment->account->name }}</td>
                        <td>{{ $payment->paymentMethod->name }}</td>
                        <td>{{ $payment->cheque_no ?? 'N/A' }}</td>
                        <td>{{ $payment->user->name }}</td>
                        <td>
                            <a data-toggle='tooltip' title="View More" href="{!! route('accounts.credit-voucher.payments.invoice', $payment) !!}" class="btn btn-primary btn-xs">
                                <i class="fa fa-eye"></i>
                            </a>
                            <a data-toggle='tooltip' title="Delete It!" href="{!! route('accounts.credit-voucher.payments.destroy', $payment) !!}" class="btn delete btn-danger btn-xs">
                                <i class="fa fa-times"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {!! $payments->links() !!}
        </div>
    </div>
@endsection

@section('footer')
    <script src="/js/sweetalert.min.js"></script>
    <script src="/js/form.js"></script>
    <script>
        $('.delete').requestRemoveData({
            formToken: '{!! csrf_token() !!}'
        });
    </script>
@endsection