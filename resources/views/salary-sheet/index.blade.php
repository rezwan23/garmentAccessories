@extends('layouts.master')

@section('title', 'Salary Sheets All')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <h4 class="card-header">All Salary Sheet</h4>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Total Payment</th>
                            <th>Created At</th>
                            <th>Created By</th>
                            <th>View</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($salaries as $salary)
                            <tr>
                                <td>{{$salary->id}}</td>
                                <td>{{$salary->total_payable}}</td>
                                <td>{{\Illuminate\Support\Carbon::parse($salary->created_at)->format('Y-m-d')}}</td>
                                <td>{{$salary->createdBy->name}}</td>
                                <td>
                                    <a href="{{route('salary.record.view', $salary)}}" class="btn btn-primary btn-sm">View</a>
                                </td>
                                <td>
                                    <form action="{{route('salary.sheet.destroy', $salary)}}" onsubmit="return confirm('Are you sure?')" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                    </form>
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