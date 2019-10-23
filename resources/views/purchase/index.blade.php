@extends('layouts.master')

@section('title', 'All Purchase Records')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <h4 class="card-header">All Purchase Records <span class="float-right">
                        <a href="{{route('purchase.create')}}" class="btn btn-warning btn-sm">Add New</a>
                    </span></h4>
                <div class="tile">
                    <div class="tile-body">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Vendor</th>
                                <th>Total Amount</th>
                                <th>View</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($purchases as $purchase)
                                <tr>
                                    <td>{{$loop->index+1}}</td>
                                    <td>{{$purchase->vendor->name}}</td>
                                    <td>{{$purchase->total_amount}}</td>
                                    <td>
                                        @can('purchase-view')
                                            <a href="{{route('purchase.view', $purchase)}}" class="btn btn-warning btn-sm">Details</a>
                                        @endcan
                                    </td>
                                    <td>
                                        {{--<a href="{{route('purchase.edit', $purchase)}}" class="btn btn-primary btn-sm float-left" style="margin-right: 4px;">Edit</a>--}}
                                        @can('purchase-delete')
                                        <form onsubmit="return confirm('Are You Sure?')" action="{{route('purchase.destroy', $purchase)}}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                        </form>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {{$purchases->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection