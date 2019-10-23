@extends('layouts.master')
@section('head')
    <style>
        @media print{
            .no-show{
                display: none;
            }
        }
    </style>
@endsection
@section('title', 'All PIs')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="h4 card-header">All PI <span class="float-right">
                        <a href="{{route('pi.create')}}" class="btn btn-warning btn-sm">Add New</a>
                    </span></div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <form action="" id="search-form">
                                <label for="search">Search By Garments</label>
                                <input type="text" value="{{request('garments')}}" placeholder="search by garments" class="form-control" onkeyup="filterPis()" name="garments">
                            </form>
                        </div>
                    </div>
                    <table class="table table-bordered" style="margin-top: 20px;">
                        <thead>
                        <tr>
                            <th>PI Number</th>
                            <th>LC Number</th>
                            <th>Job ID</th>
                            <th>Garment</th>
                            <th>Total</th>
                            <th>Print</th>
                            <th>Delete</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($pis as $pi)
                            <tr>
                                <td>{{$pi->serial_number}}</td>
                                <td>{{$pi->lcDetails?$pi->lcDetails->lc->lc_number:'N/A'}}</td>
                                <td>
                                    {{$pi->orders->pluck('id')->implode(',')}}
                                </td>
                                <td>{{$pi->garment->name}}</td>
                                <td>{{$pi->total}}</td>
                                <td>
                                    <a href="{{route('pi.print',$pi)}}" class="btn btn-primary btn-sm">Print</a>
                                </td>
                                <td>
                                    @can('delete-pi')
                                    <form action="{{route('pi.destroy', $pi)}}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-warning btn-sm" type="submit">Delete</button>
                                    </form>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{$pis->appends(request()->query())->links()}}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')
    <script>
        function filterPis(){
            $('#search-form').submit()
        }
        function filterPis1(){
            $('#search-form1').submit()
        }
    </script>
@endsection