@extends('layouts.master')
@section('head')
    <style>
        @media print{
            .no-print{
                display:none;
            }
        }
    </style>
@endsection
@section('title', 'Dyeing Report')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <h4 class="card-header">Dyeing Report
                    <span class="float-right no-print"><a href="#" class="btn btn-sm btn-warning" onclick="window.print();">Print</a></span>
                </h4>
                <div class="card-body">
                    <div class="tile">
                        <div class="tile-body">
                            <h4 class="no-print">Filter Report</h4>
                            <form action="" class="no-print">
                                <div class="row">
                                    {{--<div class="col-md-2">--}}
                                        {{--<div class="form-group">--}}
                                            {{--<label for="Status">Start Date</label>--}}
                                            {{--<input type="text" autocomplete="off" value="{{request()->get('start_date')}}" id="date"  name="start_date" class="form-control">--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                    {{--<div class="col-md-2">--}}
                                        {{--<div class="form-group">--}}
                                            {{--<label for="Status">End Date</label>--}}
                                            {{--<input type="text" autocomplete="off" value="{{request()->get('end_date')}}" id="date1"  name="end_date" class="form-control">--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
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
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Accessory</th>
                                    <th>Job ID</th>
                                    <th>Dyeing Company</th>
                                    <th>Unit</th>
                                    <th>Assigned Quantity</th>
                                    <th>Order Quantity</th>
                                    <th>Received Quantity</th>
                                    <th>Due</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($allData as $singleData)
                                    <tr>
                                        <td>{{$loop->index+1}}</td>
                                        <td>{{$singleData->accessory->name}}</td>
                                        <td>{{$singleData->itemRequirement->getJobId($singleData->accessory_id, $singleData->dyeingCompany->id)->implode(', ')}}</td>
                                        <td>{{$singleData->dyeingCompany->name}}</td>
                                        <td>{{$singleData->accessory->unit->name}}</td>
                                        <td>{{$singleData->assignedQty}} {{$singleData->accessory->unit->name}}</td>
                                        <td>{{$singleData->getOrderQuantityCount($singleData->accessory_id, $singleData->dyeingCompany->id)}}</td>
                                        @php
                                        $receivedQty = $singleData->recieveQtyCount($singleData->dyeingCompany->id,$singleData->accessory->id)
                                        @endphp
                                        <td>{{$receivedQty}}</td>
                                        {{--<td>{{$singleData->itemRequirement->getReceivedYarnCount()}} {{$singleData->accessory->unit->name}}</td>--}}
                                        <td>{{$singleData->assignedQty-$receivedQty}} {{$singleData->accessory->unit->name}}</td>
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
@section('head')
    <link rel="stylesheet" href="{{asset('css/jquery-ui.min.css')}}">
@endsection

@section('footer')
    <script src="{{asset('js/jquery-ui.min.js')}}"></script>
    <script>
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