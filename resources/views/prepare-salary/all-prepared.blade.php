@extends('layouts.master')

@section('title', 'Salary Sheet')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <h4 class="card-header">Salary Sheet</h4>
                <div class="card-body">
                    <form action="{{route('salary.payment')}}" method="post">
                        @csrf
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>
                                    <input type="checkbox" id="all_check" value="1">
                                </th>
                                <th>Employee Id</th>
                                <th>Employee</th>
                                <th>Designation</th>
                                <th>Basic Salary</th>
                                <th>Total Allowance</th>
                                <th>Total Deduction</th>
                                <th>Payable</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($salaries as $salary)
                            <tr>
                                <td>
                                    <input class="pay_check" onchange="addToPayable()"  type="checkbox" name="prepare_salary_id[]" value="{{$salary->id}}">
                                    <input type="hidden" class="net_payable" value="{{$salary->total_payable-$salary->paid}}">
                                </td>
                                <td>{{$salary->employee->id}}</td>
                                <td>{{$salary->employee->fName}}</td>
                                <td>{{$salary->employee->designation->name}}</td>
                                <td>{{$salary->employee->salary}}</td>
                                <td>{{$salary->total_allowance}}</td>
                                <td>{{$salary->total_deduction}}</td>
                                <td>{{$salary->total_payable}}</td>
                                <td>
                                    <button type="button" class="btn btn-danger btn-sm" onclick="deleteSalary({{$salary->id}})">Delete</button>
                                </td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="row">
                        <div class="col-md-4"></div>
                        <div class="col-md-4"></div>
                        <div class="col-md-4">
                            <div class="card">
                                <h4 class="card-header">Total Payable</h4>
                                <div class="card-body">
                                    <label for="total_payable">Total Payable</label>
                                    <input type="number" readonly id="total_payable" class="form-control" name="total_payable">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="tile-footer" style="margin-top: 10px;">
                                <button class="btn btn-primary float-right" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Payment</button>
                            </div>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @foreach($salaries as $salary)
    <form action="{{route('salary.destroy', $salary)}}" id="delete_form_{{$salary->id}}" onsubmit="return confirm('Are you sure?')" method="post">
        @csrf
        @method('DELETE')
    </form>
    @endforeach
@endsection

@section('footer')
    <script>
        function addToPayable(){
            var totalPayable = 0;
            $('.pay_check:checked').each(function(index, item){
                var payable = $(item).siblings('input.net_payable').val();
                totalPayable+=parseFloat(payable);
            })
            $('#total_payable').val(totalPayable);
        }

        $('#all_check').on('change', function (event) {
            var i = $('input#all_check:checked').val();
            switch (i){
                case '1':
                    $('.pay_check').each(function(index, elem){
                        $(elem).attr('checked', 'checked');
                    });
                    break;
                default :
                    $('.pay_check').each(function(index, elem){
                        $(elem).removeAttr('checked', 'checked');
                    });
                    break;

            }
            addToPayable();
        })

        function deleteSalary(id){
            $('#delete_form_'+id).submit();
        }
    </script>
@endsection