@extends('layouts.master')

@section('title', 'Commercial Assigned Orders')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="h4 card-header">Commercial Assigned</div>
                <div class="card-body">
                    <h4>Filter Order</h4>
                    <form action="">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="Status">Job ID</label>
                                    <input type="text" value="{{request()->get('job_id')}}"  name="job_id" onkeypress="loadorders(this.id)" class="form-control" id="orders_autocomplete">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="Status">Select Garments</label>
                                    <input type="text" value="{{request()->get('garments')}}"  name="garments" onkeypress="loadGarments(this.id)" class="form-control" id="garments_autocomplete">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="Status">Select Lc Number</label>
                                    <input type="text" value="{{request()->get('lc')}}"  name="lc" onkeypress="loadLcs(this.id)" class="form-control" id="lcs_autocomplete">
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
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>Commercial ID</th>
                            <th>PI</th>
                            <th>LC Number</th>
                            <th>Job ID</th>
                            <th>Total Amount</th>
                            <th>Garments</th>
                            <th>Merchant</th>
                            <th>Buyer</th>
                            <th>Delivery Date</th>
                            <th>Commercial Details</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($orders as $order)
                        <tr>
                            <td>{{$order->commercial->id}}</td>
                            <td>
                                {{$order->pis?$order->pis->pluck('serial_number')->implode(','):''}}
                            </td>
                            <td>
                                {{
                                    count($order->pis)>0?$order->pis->first()->lcDetails?$order->pis->first()->lcDetails->lc->lc_number
                                    :'N/A':'N/A'
                                }}
                            </td>
                            <td>{{$order->id}}</td>
                            <td>{{number_format($order->commercial->total_amount, 2)}}</td>
                            <td>{{$order->garments->name}}</td>
                            <td>{{$order->merchant->name}}</td>
                            <td>{{$order->buyer->name}}</td>
                            <td>{{$order->delivery_date}}</td>
                            <td>
                                <a href="{{route('commercial.edit', $order)}}" class="btn btn-primary btn-sm float-left" style="margin-right:4px;">Edit</a>
                                <form method="post" class="float-left" onsubmit="return confirm('Are You Sure?')" action="{{route('commercial.destroy', $order)}}">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm" type="submit">Delete</button>
                                </form>
                                <a href="{{route('commercial.view', $order)}}" class="btn btn-success btn-sm">View</a>
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{$orders->appends(request()->query())->links()}}
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
        function loadGarments(id){
            var garments = [];
            @foreach($garments as $garment)
            garments.push('{{$garment->name}}');
            @endforeach
            $('#'+id).autocomplete({
                source:garments,
            })
        }
        function loadorders(id){
            var orders = [];
            @foreach($allOrders as $order)
            orders.push('{{$order->id}}');
            @endforeach
            $('#'+id).autocomplete({
                source:orders,
            })
        }

        function loadLcs(id){
            var lcs = [];
            @foreach($lcs as $lc)
            @if($lc->lc_number)
            lcs.push('{{$lc->lc_number}}');
            @endif
            @endforeach
            $('#'+id).autocomplete({
                source:lcs,
            })
        }
    </script>
@endsection