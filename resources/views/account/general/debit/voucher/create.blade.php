@extends('layouts.master')

@section('title', 'Create New Voucher')

@section('head')
    <link rel="stylesheet" href="{{asset('css/jquery-ui.min.css')}}">
@endsection

@section('content')
    <div class="tile">
        <div class="tile-title-w-btn">
            <h3 class="title">Create Debit Voucher</h3>
            <p>
                <a href="{!! route('accounts.debit-vouchers.index') !!}" class="btn btn-primary">View Vouchers</a>
            </p>
        </div>
        <div class="tile-body" id="app-container">
            <form action="{!! route('accounts.debit-vouchers.store') !!}" method="post" id="create-debit-voucher">
                @csrf
                <div class="row">
                    <div class="col-md-4">
                        <label for="paid-to">Paid To</label>
                        <div class="input-group mb-3">
                            <input type="hidden" name="party_id">
                            <input type="text" :class="{'is-invalid': errors.hasOwnProperty('party_id')}" class="form-control" id="paid-to" name="customer" placeholder="Paid to">
                            <div class="input-group-append">
                                <button data-target=".create-party-modal" data-toggle="modal" class="btn btn-primary" type="button">Add New</button>
                            </div>
                            <b v-if="errors.hasOwnProperty('party_id')" class="invalid-feedback" v-text="errors.party_id[0]"></b>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="date">Date</label>
                        <input type="text" class="form-control date" value="{!! date('Y-m-d') !!}" readonly id="date" name="date" placeholder="Date">
                    </div>
                    <div class="col-md-4">
                        <label for="invoice_id">Invoice Id</label>
                        <input type="text" class="form-control" id="invoice_id" name="invoice_id" placeholder="Invoice ID">
                    </div>
                </div>
                
                <div class="row mt-5">
                    <div class="col-md-6 offset-md-3">
                        <div class="form-group">
                            <label for="account_sector">Account Sector</label>
                            <input type="text" id="account_sector" class="form-control" placeholder="Enter account sector">
                        </div>
                    </div>
                </div>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Account Sector</th>
                            <th>Description</th>
                            <th>Amount</th>
                            <th>Options</th>
                        </tr>
                    </thead>
                    <tbody v-show="sectors.length" style="display: none;">
                        <tr v-for="(sector, index) in sectors">
                            <td>
                                @{{ sector.name }}
                                <p v-if="errors.hasOwnProperty(`sectors.${index}.account_sector_id`)" class="text-danger">@{{ errors[`sectors.${index}.account_sector_id`][0] }}</p>
                            </td>
                            <td>
                                <input type="text" v-model="sector.description" class="form-control" :name="`sectors[${index}][description]`">
                            </td>
                            <td>
                                <div>
                                    <input type="hidden" :name="`sectors[${index}][account_sector_id]`" :value="sector.id">
                                    <input type="text" :class="{'is-invalid': errors.hasOwnProperty(`sectors.${index}.amount`)}" v-model.number="sector.amount" class="form-control" :name="`sectors[${index}][amount]`">
                                    <b v-if="errors.hasOwnProperty(`sectors.${index}.amount`)" class="invalid-feedback">@{{ errors[`sectors.${index}.amount`][0] }}</b>
                                </div>
                            </td>
                            <td>
                                <button tabindex="-1" @click="removeSector(index)" type="button" class="btn btn-danger btn-sm">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <div style="display: none;" :style="{display: errors.hasOwnProperty('sectors') ? 'block' : 'none'}" class="alert alert-danger" v-if="errors.hasOwnProperty('sectors')">@{{ errors.sectors[0] }}</div>
                <div class="row">
                    <div class="col-md-4 offset-md-8">
                        <table class="table-bordered table">
                            <tbody>
                                <tr>
                                    <td>Total:</td>
                                    <td>@{{ total }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="text-right">
                    <button class="btn btn-primary">Create Voucher</button>
                </div>
            </form>
        </div>
    </div>
    @include('partials.party-create-modal')
@endsection

@section('footer')
    <script src="/js/jquery-ui.min.js"></script>
    <script src="/js/form.js"></script>
    <script src="/admin/js/plugins/bootstrap-datepicker.min.js"></script>
    <script src="/js/vue.min.js"></script>
    <script>
        var app = new Vue({
            el: '#app-container',
            data: {
                sectors: [],
                errors: {}
            },
            computed: {
                total: function () {
                    return this.sectors.reduce(function (carry, sector) {
                        return (carry + sector.amount);
                    }, 0);
                }
            },
            methods: {
                removeSector: function (index) {
                    this.sectors.splice(index, 1);
                }
            }
        });


        $('.date').datepicker({
            format: "yyyy-mm-dd",
            autoclose: true,
            todayHighlight: true
        });

        $('.create-party').transmitData({
            successCallback: function () {
                $('.create-party-modal').modal('hide');
            }
        });

        $('#paid-to').autocomplete({
            source: function (request, response) {
                $.getJSON('{!! route('accounts.parties.index') !!}', {
                    name: request.term
                }, function (parties) {
                    response($.map(parties, function (party) {
                        return {
                            label: party.name + ' - '+ party.phone,
                            party: party
                        };
                    }));
                });
            },
            select: function (elem, ui) {
                $('[name=party_id]').val(ui.item.party.id);
            }
        });

        $('#account_sector').autocomplete({
            source: function (request, response) {
                $.getJSON('{!! route('accountSector.index') !!}', {
                    name: request.term,
                    sector_type: 0
                }, function (sectors) {
                    response($.map(sectors, function (sector) {
                        return {
                            label: sector.name,
                            sector: sector
                        };
                    }));
                });
            },
            select: function (elem, ui) {
                Object.assign(ui.item.sector, {
                    amount: 0,
                    description: ''
                });

                app.sectors.push(ui.item.sector);

                setTimeout(function () {
                    $(elem.target).val('');
                }, 100);
            }
        });
        $('#create-debit-voucher').transmitData({
            errorCallback: function (error) {
                if(error.status == 422){
                    app.errors = error.responseJSON.errors;
                }
            },
            beforeSubmitCallback: function () {},
            successCallback: function (response) {
                location.href = '/accounts/debit-vouchers/';
                app.sectors = [];
            }
        });
    </script>
@endsection