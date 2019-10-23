@extends('layouts.master')
@section('head')
    <style>
        @media print{
            .no-show{
                display:none;
            }
        }
    </style>
    <link rel="stylesheet" href="{{asset('css/jquery-ui.min.css')}}">
@endsection
@section('title', 'All Lcs')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="card no-show">
                    <h4 class="card-header">All LC <span class="float-right">
                        <a href="{{route('lc.create')}}" class="btn btn-warning btn-sm">Add New</a>
                    </span><span class="float-right">
                        <button onclick="window.print()" class="btn btn-warning btn-sm">Print</button>
                    </span></h4>
                    <div class="card-body">
                        <h4>Filter Order</h4>
                        <form action="">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="Status">Select Garments</label>
                                        <input type="text" value="{{request()->get('garments')}}"  name="garments" onkeypress="loadGarments(this.id)" class="form-control" id="garments_autocomplete">
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
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>LC Number</th>
                            <th width="10%">Job ID</th>
                            <th>Pi</th>
                            <th>Garments</th>
                            <th>Total Value</th>
                            <th>Seller Bank</th>
                            <th>Buyer Bank</th>
                            <th>Party Date</th>
                            <th>Bank Date</th>
                            <th>Acceptance Date</th>
                            <td>Bank ref Number</td>
                            <td>Adjust Remarks</td>
                            <td>Status</td>
                            <th class="no-show">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($lcs as $lc)
                            <tr>
                                <td>{{ ($lcs ->currentpage()-1) * $lcs ->perpage() + $loop->index + 1 }}</td>
                                <td>{{$lc->lc_number?$lc->lc_number:'N/A'}}</td>
                                <td>
                                    @if(!empty($lc->jobId()))
                                        {{implode(', ', $lc->jobId())}}
                                        @else
                                        N/A
                                        @endif
                                </td>
                                <td>{{$lc->lcDetails->pluck('serial_number')->implode(', ')}}</td>
                                <td>{{$lc->garment?$lc->garment->name:'N/A'}}</td>
                                <td>USD {{$lc->total_value?$lc->total_value:'N/A'}}</td>
                                <td>{{$lc->seller_bank?$lc->seller_bank:''}}</td>
                                <td>{{$lc->buyer_bank?$lc->buyer_bank:''}}</td>
                                <td>{{$lc->party_date?$lc->party_date:''}}</td>
                                <td>{{$lc->bank_date?$lc->bank_date:''}}</td>
                                <td>{{$lc->accept_date?$lc->accept_date:''}}</td>
                                <td>{{$lc->bank_ref_no}}</td>
                                <td>{{$lc->adjust_remarks}}</td>
                                <td>
                                    <button class="btn btn-sm btn-{{$lc->getStatusClass()}} dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{$lc->getStatus()}}</button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        @if($lc->status)
                                            <form action="{{route('lc.mark.as.pending', $lc)}}" method="post">
                                                @csrf
                                                <button style="cursor:pointer" type="submit" class="dropdown-item">Mark as Pending</button>
                                            </form>
                                            @else
                                            <form action="{{route('lc.mark.as.done', $lc)}}" method="post">
                                                @csrf
                                                <button style="cursor:pointer" type="submit" class="dropdown-item">Mark as Done</button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                                <td class="no-show">
                                    <a href="{{route('lc.edit', $lc)}}" class="btn btn-warning btn-sm">Edit</a>
                                    <a href="{{route('lc.view', $lc)}}" class="btn btn-primary btn-sm">View</a>
                                    <a href="{{route('lc.print', $lc)}}" class="btn btn-primary btn-sm">Print</a>
                                    @can('delete-lc')
                                        <form action="{{route('lc.destroy', $lc)}}" onsubmit="return confirm('Are You Sure?')" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-warning btn-sm">Delete</button>
                                        </form>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{$lcs->appends(request()->query())->links()}}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')
    <script src="{{asset('js/jquery-ui.min.js')}}"></script>

    <script>
        function loadGarments(id){
            var garments = [];
            @foreach($garments as $garment)
            garments.push('{{$garment->name}}');
            @endforeach
            $('#'+id).autocomplete({
                source:garments,
            })
        }
    </script>
@endsection

