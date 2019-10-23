@extends('layouts.master')

@section('title', 'Payslip')
@section('head')
    <style>
        @media print{
            .no-show{
                display:none
            }
        }
    </style>
@endsection


@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <h4 class="card-header no-show">Payslip
                    <span class="float-right"><button class="btn btn-warning btn-sm" onclick="window.print()">Print</button></span>
                </h4>
                <div class="card-body">
                    <div class="float-left">
                        <div class="employee_photo">
                            <img style="padding: 15px;border: 1px solid #ededed;" src="{{asset($detail->employee->image)}}" alt="">
                        </div>
                        <div class="employee_details">
                            <h4 style="text-transform: uppercase;">{{$detail->employee->fName}}</h4>
                        </div>
                    </div>
                    <div class="float-right">
                        <h4 style="text-transform:uppercase">{{auth()->user()->company->name}}</h4>
                        <p>
                            {!! auth()->user()->company->address !!}<br>
                            E-mails: {{auth()->user()->company->emails}}<br>
                            Phones: {{auth()->user()->company->phones}}
                        </p>
                    </div>
                    <div class="clearfix"></div>
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-striped">
                                <tr>
                                    <th>Basic Salary</th>
                                    <td>{{$detail->employee->salary}}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-striped">
                                <tr>
                                    <th>Month</th>
                                    <td>{{$detail->month}}</td>
                                </tr>
                                <tr>
                                    <th>Year</th>
                                    <td>{{$detail->year}}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <p class="text-center">Allowances</p>
                            <table class="table table-striped" style="margin-top:15px">
                                <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Allowance</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($detail->prepareSalary->prepareSalaryAllowances->where('type', 1) as $allowance)
                                    <tr>
                                        <td>{{$allowance->salaryExtra->title}}</td>
                                        <td>{{$allowance->allowance}}</td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <th>Total Allowance</th>
                                    <td>{{$detail->total_allowance}}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <p class="text-center">Deductions</p>
                            <table class="table table-striped" style="margin-top:15px">
                                <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Deduction</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($detail->prepareSalary->prepareSalaryAllowances->where('type', 0) as $deduction)
                                    <tr>
                                        <td>{{$deduction->salaryExtra->title}}</td>
                                        <td>{{$deduction->allowance}}</td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <th>Total Deduction</th>
                                    <td>{{$detail->total_deduction}}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-striped" style="margin-top: 15px;">
                                <tr>
                                    <th>Net Payment</th>
                                    <td>{{$detail->payable}}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="row" style="margin-top: 200px;">
                        <div class="col-md-2"></div>
                        <div class="col-md-3">
                            <div class="text-center">
                                <p style="border-top: 1px solid #000;">Accountant</p>
                            </div>
                        </div>
                        <div class="col-md-1"></div>
                        <div class="col-md-3">
                            <div class="text-center">
                                <p style="border-top: 1px solid #000;">Employee</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection