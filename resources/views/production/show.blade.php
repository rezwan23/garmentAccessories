@extends('layouts.master')

@section('title', 'Show Production')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <h3 class="card-header">Job ID: {{$production->order_id}}</h3>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>Date</th>
                            <th>Item</th>
                            <th>Color</th>
                            <th>Production Quantity</th>
                            <th>Order Quantity</th>
                            <th>Delete</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($production->productionItems as $item)
                            <tr>
                                <td>{{Carbon\Carbon::parse($item->created_at)->format('d F, Y')}}</td>
                                <td>{{$item->item->item->name}}</td>
                                <td>{{$item->item->color->name}}</td>
                                <td>{{number_format($item->quantity, 0)}} {{$item->item->item->unit->name}}</td>
                                <td>{{$item->item->quantity}} {{$item->item->item->unit->name}}</td>
                                <td>
                                    @can('production-record-delete')
                                    <form onsubmit="return confirm('Are You Sure?')" action="{{route('production.destroy', $item)}}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-warning">Delete</button>
                                    </form>
                                        @endcan
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection