@extends('layouts.master')

@section('title', 'Sample Deliver')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <h4 class="card-header">Sample Deliver</h4>
                <div class="tile" style="margin-bottom:0px !important">
                    <form action="{{route('order.deliver', $order)}}" method="post">
                        @csrf
                        <div class="tile-body">
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <label class="control-label">Delivery Person</label>
                                    <input class="form-control" required  name="delivery_person" autocomplete="off" type="text" placeholder="Enter Delivery Person">
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
@endsection

@section('footer')
    <script src="{{asset('admin/js/plugins/bootstrap-datepicker.min.js')}}"></script>
    <script>
        $('#demoDate').datepicker({
            format: "yyyy-mm-dd",
            autoclose: true,
            todayHighlight: true
        });
    </script>
@endsection