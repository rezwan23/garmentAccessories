@extends('layouts.master')

@section('title', 'Show Salary Record')
@section('head')
    <style>
        .no-show{
            display: none;
        }
        @media print{
            .no-show{
                display:block;
            }
            .no-print{
                display:none;
            }
            .border-top{
                margin-top:300px;
                border-top:1px solid #000;
            }
        }
    </style>
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <h4 class="card-header no-print">Salary Payment Record
                    <span class="btn btn-warning btn-sm float-right" onclick="window.print()">Print</span>
                </h4>
                <div class="card-body">
                    <div class="no-show">
                        <div class="row">
                            <div class="col-md-6">
                                <h3>{{auth()->user()->company->name}}</h3>
                                <p>{{auth()->user()->company->address}}<br>
                                {{auth()->user()->company->emails}}<br>
                                {{auth()->user()->company->phones}}
                                </p>
                            </div>
                            <div class="col-md-6 float-right">
                                <h4>Salary Sheet</h4>
                                <p>Date : {{\Carbon\Carbon::parse($salary->created_at)->format('Y-m-d')}}</p>
                            </div>
                        </div>
                    </div>
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>Employee Id</th>
                            <th>Employee Name</th>
                            <th>Designation</th>
                            <th>Month</th>
                            <th>Total Allowance</th>
                            <th>Total Deduction</th>
                            <th>Total Payment</th>
                            <th>Pay Slip</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($salary->details as $detail)
                            <tr>
                                <td>{{$detail->employee_id}}</td>
                                <td>{{$detail->employee->fName}}</td>
                                <td>{{$detail->employee->designation->name}}</td>
                                <td>{{$detail->month}}, {{$detail->year}}</td>
                                <td>{{$detail->total_allowance}}</td>
                                <td>{{$detail->total_deduction}}</td>
                                <td>{{$detail->payable}}</td>
                                <td>
                                    <a href="{{route('payslip', $detail)}}" class="btn btn-primary btn-sm">View</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="no-show">
                <div class="row">
                    <div class="col-md-3 border-top">
                        <p>Signature of Accountant</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection