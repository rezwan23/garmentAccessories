@extends('layouts.master')

@section('title', 'Payment')


@section('content')
    <div class="tile">
        <div class="tile-title-w-btn">
            <h3 class="title">Payment</h3>
            <p>
                <a href="{!! route('accounts.credit-vouchers.index') !!}" class="btn btn-primary">View Payment</a>
            </p>
        </div>
        <div class="tile-body" id="app-container">
            @csrf
            <div class="row">
                <div class="col-md-4 offset-md-4">
                    <label for="paid-to">Receive From</label>
                    <select class="form-control" id="paid-to">
                        <option value="">Select a party</option>
                        @foreach($parties as $party)
                            <option value="{!! $party->id !!}">{{ $party->name . ' - '. $party->phone }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div v-show="!isEmpty(data)" style="display: none">

                <form v-if="!isEmpty(data)" :action="`/accounts/credit-vouchers/${id}/paid`" method="post" id="payment">
                    @csrf
                    <hr>
                    <table class="table table-bordered table-narrow">
                        <tbody>
                            <tr>
                                <td>Invoice ID</td>
                                <td>Particular</td>
                                <td>Date</td>
                                <td>Total Amount</td>
                                <td>Paid</td>
                                <td>Due</td>
                            </tr>
                            <tr v-for="(voucher, index) in data.vouchers">
                                <td>
                                    <div class="custom-control custom-radio">
                                        <input v-model="selectedIndex" type="radio" :value="index" :id="`invoice-${voucher.id}`" name="invoice" class="custom-control-input">
                                        <label class="custom-control-label" :for="`invoice-${voucher.id}`">@{{ voucher.id }}</label>
                                    </div>
                                </td>
                                <td v-text="voucher.sectors"></td>
                                <td v-text="voucher.date"></td>
                                <td v-text="voucher.total_amount"></td>
                                <td v-text="voucher.paid"></td>
                                <td v-text="voucher.due"></td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="account_id" class="col-md-4 text-right">Select Account</label>
                                <div class="col-md-8">
                                    <select name="account_id" id="account_id" class="form-control">
                                        <option value="">Select account</option>
                                        @foreach($accounts as $account)
                                            <option value="{!! $account->id !!}">{{ $account->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="payment_method_id" class="col-md-4 text-right">Select Payment Method</label>
                                <div class="col-md-8">
                                    <select name="payment_method_id" id="payment_method_id" class="form-control">
                                        <option value="">Select payment method</option>
                                        @foreach($payment_methods as $method)
                                            <option value="{!! $method->id !!}">{{ $method->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="cheque_no" class="col-md-4 text-right">Ref ID/Cheque No</label>
                                <div class="col-md-8">
                                    <input type="text" name="cheque_no" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="total" class="col-md-4 text-right">Total</label>
                                <div class="col-md-8">
                                    <input type="text" :value="voucher.total_amount" readonly class="form-control">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="paid" class="col-md-4 text-right">Paid</label>
                                <div class="col-md-8">
                                    <input type="text" @focus="paidAmount" name="amount" v-model.number="paid" class="form-control">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="due" class="col-md-4 text-right">Due</label>
                                <div class="col-md-8">
                                    <input type="text" readonly :value="(voucher.total_amount - (paid + voucher.paid))" name="due" class="form-control">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="payment-date" class="col-md-4 text-right">Payment Date</label>
                                <div class="col-md-8">
                                    <input type="text" readonly value="{!! date('Y-m-d') !!}" id="payment-date" name="payment_date" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="text-right">
                        <button class="btn btn-primary">Paid</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('footer')
    <script src="/js/select2.min.js"></script>
    <script src="/js/form.js"></script>
    <script src="/admin/js/plugins/bootstrap-datepicker.min.js"></script>
    <script src="/js/vue.min.js"></script>
    <script>
        var app = new Vue({
            el: '#app-container',
            data: {
                data: {},
                selectedIndex: null,
                isOpen: false,
                paid: 0,
                voucher: {
                    total_amount: 0,
                    paid: 0,
                    due: 0
                }
            },
            computed: {
                id: function () {
                    if(this.selectedIndex != null){
                        return this.data.vouchers[this.selectedIndex].id;
                    }
                    return null;
                }
            },
            methods: {
                isEmpty: function (obj) {
                    return Object.keys(obj).length == 0;
                },
                paidAmount: function () {
                    this.paid = (this.voucher.total_amount - this.voucher.paid);
                }
            },
            watch: {
                selectedIndex: function (value) {
                    Object.assign(this.voucher, this.data.vouchers[value]);
                }
            }
        });

        var $select = $('#paid-to');


        $select.select2().on('change', function () {
            var select = $(this);

            if(select.val()){
                $.getJSON('/accounts/credit-vouchers/payment/'+select.val(), function (data) {
                    app.data = data.data;
                    if(!app.isOpen){
                        app.isOpen = true;
                        setTimeout(function () {
                            $('#payment').transmitData({
                                successCallback: function (response) {
                                    app.data = {};
                                    app.paid = 0;
                                    setTimeout(function () {
                                        location.href = '/accounts/credit-voucher-payments/'+response.payment.id+'/voucher?auto-print';
                                    }, 500);
                                }
                            });

                            $('#payment-date').datepicker({
                                format: 'yyyy-mm-dd',
                                todayHighlight: true,
                                autoHide: true
                            });
                        }, 500);
                    }
                });
            }
        });

    </script>
@endsection