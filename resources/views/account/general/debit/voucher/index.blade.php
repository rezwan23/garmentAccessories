@extends('layouts.master')

@section('title', 'Create New Voucher')

@section('head')
    <link rel="stylesheet" href="{{asset('css/jquery-ui.min.css')}}">
@endsection

@section('content')
    <div class="tile">
        <div class="tile-title-w-btn">
            <h3 class="title">Debit Vouchers</h3>
            @include('account.general.filter')
            <p>
                <a href="{!! route('accounts.debit-vouchers.create') !!}" class="btn btn-primary">Create Voucher</a>
            </p>
        </div>
        <div class="tile-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Voucher ID</th>
                        <th>Paid To</th>
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
                        <td>{{ $voucher->totalAmount() }}</td>
                        <td>
                            <a data-toggle='tooltip' title="View More" href="{!! $voucher->voucherLink() !!}?auto-print" class="btn btn-primary btn-xs">
                                <i class="fa fa-eye"></i>
                            </a>
                            <a data-toggle='tooltip' title="Payment History" href="{!! route('accounts.debit-voucher.payments.history', $voucher) !!}" class="btn btn-secondary btn-xs">
                                <i class="fa fa-retweet"></i>
                            </a>
                            @can('debit-voucher-delete')
                            <form style="display: inline;" onsubmit="return confirm('Are You Sure?')" action="{!! route('accounts.debit-vouchers.destroy', $voucher) !!}" method="post">
                                @csrf
                                @method('DELETE')
                                <button type="submit" data-toggle='tooltip' title="Delete It!" class="btn btn-danger btn-xs">
                                    <i class="fa fa-times"></i>
                                </button>
                            </form>
                                @endcan
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
        $('.delete').requestRemoveData({
            formToken: '{!! csrf_token() !!}'
        });
    </script>
@endsection