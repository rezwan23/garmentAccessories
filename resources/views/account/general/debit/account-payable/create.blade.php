@extends('layouts.master')
@section('title', 'Add New Voucher')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <h4 class="card-header">Bill Receive <span class="float-right"><a href="{{route('accountPayable.index')}}" class="btn btn-warning btn-sm">View All</a></span></h4>
                <div class="card-body">
                    <div class="tile">
                        <form action="{{route('accountPayable.store')}}" method="post">
                            @csrf
                            <div class="tile-body">
                                <div class="row">
                                    <div class="form-group col-md-3">
                                        <label class="control-label">Vendor</label>
                                        <input class="form-control" type="text" name="vendor" id="vendor_name" required onkeypress="vendorAutocomplete(this.id)" placeholder="Enter Vendor Name">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label class="control-label">LC Number</label>
                                        <input type="text" name="lc_number" required class="form-control" placeholder="Enter LC No.">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label class="control-label">Order No.</label>
                                        <input type="text" required name="order_number" class="form-control" placeholder="Enter Order No">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label class="control-label">Order Date</label>
                                        <input class="form-control" required id="demoDate" name="order_date" autocomplete="off" value="{{date('Y-m-d')}}" type="text" placeholder="Select Order Date">
                                    </div>
                                    {{--<div class="form-group col-md-4 align-self-end">--}}
                                    {{--<button class="btn btn-primary" type="button"><i class="fa fa-fw fa-lg fa-check-circle"></i>Subscribe</button>--}}
                                    {{--</div>--}}
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <h6 class="card-header">Details</h6>
                                        <table class="table table-bordered">
                                            <thead>
                                            <tr>
                                                <th>Sector</th>
                                                <th>Description</th>
                                                <th>Amount</th>
                                                <th width="12%">Delete</th>
                                            </tr>
                                            </thead>
                                            <tbody class="container1">
                                            <tr class="r-group">
                                                <td><input id="sector_0" required data-pattern-id="sector_++" type="text" name="sector[]" onkeypress="sectorAutoComplete(this.id)" class="form-control"></td>
                                                <td><input type="text" required name="description[]" class="form-control"></td>
                                                <td><input type="number" required value="0" onkeyup="countTotal()" name="amount[]" class="amount_field form-control"></td>
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
                                        <h6 class="card-header">Total Payable</h6>
                                        <table class="table table-bordered float-right">
                                            <tbody>

                                            <tr>
                                                <th>Total Amount</th>
                                                <td><input id="total_amount_field" readonly value="0" type="text" class="form-control" name="total_amount"></td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="tile-footer" style="padding-bottom: 50px;">
                                <button class="btn btn-primary float-right" style="display: block;" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('head')
    <link rel="stylesheet" href="{{asset('css/jquery-ui.min.css')}}">
@endsection
@section('footer')
    <script src="{{asset('js/jquery-ui.min.js')}}"></script>
    <script>
        function countTotal()
        {
            var total = 0;
            $('.amount_field').each(function(){
                total+=parseInt($(this).val());
            })
            $('#total_amount_field').val(total);
        }
        var sectors = [];
        @foreach($sectors as $sector)
        sectors.push('{{$sector->name}}')
        @endforeach
        function sectorAutoComplete(id){
            $( '#'+id ).autocomplete({
                source:sectors,
            });
        }
        function vendorAutocomplete(id){
            var vendors = [];
            @foreach($vendors as $vendor)
            vendors.push('{{$vendor->name}}')
            @endforeach
            $( '#'+id ).autocomplete({
                source:vendors,
            });
        }
    </script>
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
            clearValues: true,
            afterDelete: function(){
                countTotal();
            },
        });
    </script>
    <script>
        $('#demoDate').datepicker({
            format: "yyyy-mm-dd",
            autoclose: true,
            todayHighlight: true
        });
        $('#demoDate1').datepicker({
            format: "yyyy-mm-dd",
            autoclose: true,
            todayHighlight: true
        });
    </script>
@endsection