@extends('layouts.master')
@section('head')
    <style>
        @media print{
            .no-print{
                display: none;
            }
        }
    </style>    
@endsection
@section('title', 'Production Report')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <h4 class="card-header">Production Report
                    <span class="float-right no-print"><a href="#" class="btn btn-warning btn-sm" onclick="window.print()">Print</a></span>
                </h4>
                <div class="card-body">
                    <h4 class="no-print">Filter Report

                    </h4>
                    <form action="" class="no-print">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="Status">Start Date</label>
                                    <input type="text" autocomplete="off" value="{{request()->get('start_date')}}" id="date"  name="start_date" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="Status">End Date</label>
                                    <input type="text" autocomplete="off" value="{{request()->get('end_date')}}" id="date1"  name="end_date" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="Status">Job ID</label>
                                    <input type="text" autocomplete="off" value="{{request()->get('job_id')}}"  name="job_id" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label style="display: block" for="Status">Filter</label>
                                    <input type="submit" class="btn btn-primary" value="Filter">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-body">
                    <div class="tile">
                        <div class="tile-body">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Date</th>
                                    <th>Job ID</th>
                                    <th>Item</th>
                                    <th>Unit</th>
                                    <th>Production Quantity</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($allData as $singleData)
                                    @if($singleData->productionQuantity==null)
                                        @continue
                                        @endif
                                    <tr>
                                        <td>{{$loop->index+1}}</td>
                                        <td>{{\Carbon\Carbon::parse($singleData->productionDate)->format('d-m-Y')}}</td>
                                        <td>{{$singleData->jobId}}</td>
                                        <td>{{$singleData->itemName}} - {{$singleData->itemSize}}</td>
                                        <td>{{$singleData->unitName}}</td>
                                        <td>{{$singleData->productionQuantity}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="no-print">
                            {{$allData->appends(request()->query())->links()}}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')
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
    </script>

@endsection