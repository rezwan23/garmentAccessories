@extends('layouts.master')
@section('head')
    <style>
        @media print{
            .no-print{
                display:none;
            }
        }
    </style>
    <link rel="stylesheet" href="{{asset('css/jquery-ui.min.css')}}">
@endsection
@section('title', 'Dyeing Report')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <h4 class="card-header">Dyeing Report
                    <span class="no-print float-right"><a href="#" onclick="window.print();" class="btn btn-warning btn-sm">Print</a></span>
                </h4>
                <div class="card-body">
                    <div class="tile">
                        <div class="tile-body">
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
                                            <input type="text" autocomplete="off" onkeypress="loadCompany(this.id)" value="{{!empty($dyeingCompany)?$dyeingCompany->name:''}}" class="form-control" id="dyeing">
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
                            @if(count($allData)>0)
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Dyeing Company</th>
                                    <th>Assigned Quantity</th>
                                    <th>Yarn</th>
                                    <th>Color</th>
                                    <th>Receiving Quantity</th>
                                    <th>Total Received</th>
                                    <th>Due</th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach($allData as $singleData)
                                    <tr>
                                        <td>{{\Carbon\Carbon::parse($singleData->created_at)->format('d F, Y')}}</td>
                                        <td>{{$singleData->receiveDyeingYarn->dyeingCompany->name}}</td>
                                        <td>{{$singleData->dyeingAssignedQuantityCount()}}</td>
                                        <td>{{$singleData->accessory->name}}</td>
                                        <td>{{$singleData->color->name}}</td>
                                        <td>{{$singleData->received_quantity}} - (jobId {{$singleData->receiveDyeingYarn->order_id}})</td>
                                        <td>{{$singleData->material?$singleData->material->getReceivedMaterialCount():''}}</td>
                                        <td>{{$singleData->material?$singleData->getDueAccessory():''}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="no-print">
                                {{$allData->appends(request()->query())->links()}}
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
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