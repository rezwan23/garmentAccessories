@extends('layouts.master')

@section('title', 'Yarn Order')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <h4 class="card-header">Yarn Order <span class="float-right"><a href="#" class="btn btn-warning btn-sm">View All</a></span></h4>
            <div class="card-body">
                <div class="tile">
                    <div class="tile-body">
                        <form>
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <label class="control-label">Company Name</label>
                                    <input class="form-control" type="text" placeholder="Enter Company Name">
                                </div>
                                <div class="form-group col-md-3">
                                    <label class="control-label">Order Date</label>
                                    <input class="form-control" id="demoDate" name="order_date" autocomplete="off" type="text" placeholder="Select Order Date">
                                </div>
                                <div class="form-group col-md-3">
                                    <label class="control-label">PI No.</label>
                                    <input type="text" name="pi_no" class="form-control" placeholder="Enter PI No.">
                                </div>
                                <div class="form-group col-md-3">
                                    <label class="control-label">LC.</label>
                                    <input type="text" name="lc_no" class="form-control" placeholder="Enter LC No.">
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="control-label">Shipping Address</label>
                                    <textarea name="shipping_address" class="form-control" cols="30" rows="2"></textarea>
                                </div>
                                {{--<div class="form-group col-md-4 align-self-end">--}}
                                    {{--<button class="btn btn-primary" type="button"><i class="fa fa-fw fa-lg fa-check-circle"></i>Subscribe</button>--}}
                                {{--</div>--}}
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <h6 class="card-header">Yarn</h6>
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th width="20%">Yarn</th>
                                            <th>Brand</th>
                                            <th width="14%">Available Quantity</th>
                                            <th width="14%">Purchase Quantity</th>
                                            <th>Unit Price</th>
                                            <th>Total Price</th>
                                            <th width="12%">Delete</th>
                                        </tr>
                                        </thead>
                                        <tbody class="container1">
                                            <tr class="r-group">
                                                <td><input type="text" name="yarn" class="form-control"></td>
                                                <td><input type="text" name="brand" class="form-control"></td>
                                                <td><input type="text" name="available_quantity" class="form-control" disabled="disabled"></td>
                                                <td><input type="text" name="purchase_quantity" class="form-control"></td>
                                                <td><input type="text" name="unit_price" class="form-control"></td>
                                                <td><input type="text" name="total_price" class="form-control"></td>
                                                <td><button type="button" class="btn btn-sm btn-primary r-btnAdd"><i class="fa fa-plus"></i></button>
                                                    <button type="button" class="btn btn-sm btn-danger r-btnRemove"><i class="fa fa-trash"></i></button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-md-4"></div>
                                <div class="col-md-4"></div>
                                <div class="col-md-4">
                                    <h6 class="card-header">Delivery Details</h6>
                                    <table class="table table-bordered float-right">
                                        <tbody>
                                        <tr>
                                            <th>Dilivery Date</th>
                                            <td><input type="text" class="form-control" id="demoDate1" autocomplete="off" name="delivery_date"></td>
                                        </tr>
                                        <tr>
                                            <th>Total Amount</th>
                                            <td><input type="text" class="form-control" name="total_amount"></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('footer')
    <script src="{{asset('admin/js/plugins/bootstrap-datepicker.min.js')}}"></script>
    <script src="{{asset('admin/js/jquery.form-repeater.js')}}"></script>
    <script type="text/javascript">
        $('.container1').repeater({
            btnAddClass: 'r-btnAdd',
            btnRemoveClass: 'r-btnRemove',
            groupClass: 'r-group',
            minItems: 1,
            maxItems: 0,
            startingIndex: 0,
            reindexOnDelete: true,
            repeatMode: 'append',
            animation: null,
            animationSpeed: 400,
            animationEasing: 'swing',
            clearValues: true
        });
    </script>
    <script>
        $('#demoDate').datepicker({
            format: "dd/mm/yyyy",
            autoclose: true,
            todayHighlight: true
        });
        $('#demoDate1').datepicker({
            format: "dd/mm/yyyy",
            autoclose: true,
            todayHighlight: true
        });
    </script>
@endsection