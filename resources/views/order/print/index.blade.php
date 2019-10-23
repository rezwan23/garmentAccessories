@extends('layouts.master')

@section('title', 'Print orders')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <h4 class="card-header">Print Order Copy</h4>
                <div class="card-body">
                    <div class="tile">
                        <form action="">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="jobId">Job ID</label>
                                        <input type="text" value="{{request()->get('job_id')}}"  name="job_id" class="form-control" id="jobId">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="btn">Filter</label>
                                        <br>
                                        <button type="submit" class="btn btn-primary">Filter</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="tile-body">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>Job ID</th>
                                    <th>Garments</th>
                                    <th>Office Copy</th>
                                    <th>Factory Copy</th>
                                    <th>Dying Copy</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($orders as $order)
                                    <tr>
                                        <td>{{$order->id}}</td>
                                        <td>{{$order->garments->name}}</td>
                                        <td><a target="_blank" href="{{route('order.print.office', $order)}}" class="btn btn-success btn-sm">Print</a></td>
                                        <td><a target="_blank" href="{{route('order.print.factory', $order)}}" class="btn btn-success btn-sm">Print</a></td>
                                        <td><a target="_blank" href="{{route('order.print.dyeing', $order)}}" class="btn btn-success btn-sm">Print</a></td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            {{$orders->links()}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection