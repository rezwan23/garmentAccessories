@extends('layouts.master')
@section('title', 'Order Report')
@section('head')

    <style>
        @media print{
            .no-print{
                display:none;
            }
        }
    </style>

@endsection
@section('content')
    <div class="row">

        <div class="col-md-12">
            <div class="tile">
                <h4 class="no-print">Filter Report</h4>
                <form action="" class="no-print">
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="Status">Start Date</label>
                                <input type="text" autocomplete="off" value="{{request()->get('start_date')}}" id="date"  name="start_date" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="Status">End Date</label>
                                <input type="text" autocomplete="off" value="{{request()->get('end_date')}}" id="date1"  name="end_date" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="Status">Job ID</label>
                                <input type="text" autocomplete="off" value="{{request()->get('job_id')}}"  name="job_id" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label style="display: block" for="Status">Dyeing Company</label>
                                <input type="text" autocomplete="off" onkeypress="loadCompany(this.id)" value="{{!empty($dyeing)?$dyeing->name:''}}" class="form-control" id="dyeing">
                                <input type="hidden" name="dyeing_id" id="dyeing_id">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label style="display: block" for="Status">Filter</label>
                                <input type="submit" class="btn btn-primary" value="Filter">
                            </div>
                        </div>
                    </div>
                </form>
                <div class="card">
                    <h4 class="card-header">Order Report
                        <span class="float-right no-print"><a href="#" onclick="window.print()" class="btn btn-warning btn-sm">Print</a></span>
                    </h4>
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>Job Id</th>
                            <th>PI Status</th>
                            <th>Ordered Yarn</th>
                            <th>Received Yarn</th>
                            <th>Due Yarn</th>
                            <th>Order Item Quantity</th>
                            <th>Production Quantity</th>
                            <th>Production Due</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($orders as $order)
                            <tr>
                                <td>{{$order->id}}</td>
                                <td>
                                    @if($order->is_pi)
                                        <span class="badge badge-success">Yes</span>
                                        @else
                                    <span class="badge badge-danger">No</span>
                                        @endif
                                </td>
                                <td>{{$order->getTotalOrderedYarn()}}</td>
                                <td>{{$order->getTotalReceivedYarn()}}</td>
                                <td>{{$order->getTotalOrderedYarn()-$order->getTotalReceivedYarn()}}</td>
                                <td>{{$order->getTotalProduction()}}</td>
                                <td>{{$order->getTotalProducedQuantity()}}</td>
                                <td>{{$order->getTotalProduction()-$order->getTotalProducedQuantity()}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="no-print">
                        {{$orders->appends(request()->query())->links()}}
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
    <script src="{{asset('admin/js/plugins/bootstrap-datepicker.min.js')}}"></script>
    <script>
        $('#date').datepicker({
            format: "yyyy-mm-dd",
            autoclose: true,
            todayHighlight: true
        });
        $('#date1').datepicker({
            format: "yyyy-mm-dd",
            autoclose: true,
            todayHighlight: true
        });

        function loadCompany(id)
        {
            $('#'+id).autocomplete({
                source: function(request, response){
                    $.get('{{route('dyeing.company.all')}}', {'name':request.term}, function(data){
                        response($.map(data, function(company){
                            return {
                                label:company.name,
                                value:company.name,
                                id:company.id
                            }
                        }))
                    })
                },
                select:function(event, ui){
                    $('#dyeing_id').val(ui.item.id);
                }
            })
        }
    </script>
@endsection