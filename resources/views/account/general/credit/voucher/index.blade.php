@extends('layouts.master')

@section('title', 'Create New Voucher')

@section('content')
    <div class="tile">
        <div class="tile-title-w-btn">
            <h3 class="title">Credit Vouchers</h3>
            @include('account.general.filter')
            <p>
                <a href="{!! route('accounts.credit-vouchers.create') !!}" class="btn btn-primary">Create Voucher</a>
            </p>
        </div>
        <div class="tile-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Voucher ID</th>
                        <th>Receive From</th>
                        <th>Date</th>
                        <th>Total Amount</th>
                        <th>Options</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($vouchers as $voucher)
                    <tr>
                        <td>{{ $voucher->id }}</td>
                        <td>{{ $voucher->party->name }}</td>
                        <td>{{ $voucher->date->format('d F, Y') }}</td>
                        <td>{{ $voucher->total_amount }}</td>
                        <td>
                            <a title="View Details" data-toggle="tooltip" href="{!! $voucher->voucherLink() !!}" class="btn btn-primary btn-xs">
                                <i class="fa fa-eye"></i>
                            </a>
                            <a title="Payment History" data-toggle="tooltip" href="{!! route('accounts.credit-voucher.payments.history', $voucher) !!}" class="btn btn-secondary btn-xs">
                                <i class="fa fa-retweet"></i>
                            </a>
                            <a title="Delete" data-toggle="tooltip" href="{!! route('accounts.credit-vouchers.destroy', $voucher) !!}" class="btn delete-voucher btn-danger btn-xs">
                                <i class="fa fa-times"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {!! $vouchers->links() !!}
        </div>
    </div>
@endsection

@section('footer')
    <script src="/js/sweetalert.min.js"></script>
    <script src="/js/form.js"></script>
    <script>
        $('.delete-voucher').requestRemoveData({
            formToken: '{!! csrf_token() !!}'
        });
    </script>
@endsection