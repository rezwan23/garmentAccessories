@extends('layouts.master')
@section('title', 'Prepare Salary')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <h4 class="card-header">Prepare Salary</h4>
                <div class="card-body">
                    <form action="">
                        <div class="row">
                            <div class="col-md-3">
                                <label for="department">Select Department</label>
                                <select onchange="loadEmployees()" name="department_id" id="department_id" class="form-control">
                                    <option value="">Select Department</option>
                                    @foreach($departments as $department)
                                        <option value="{{$department->id}}">{{$department->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="employee">Select Employee</label>
                                <select name="employee_id" id="employees" class="form-control">
                                    <option value="">Select Department First</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="employee">Select Month</label>
                                <select name="month" id="month" class="form-control">
                                    <?php
                                    for($m=1; $m<=12; ++$m){
                                        ?>
                                        <option value="{{date('F', mktime(0, 0, 0, $m, 1))}}">{{date('F', mktime(0, 0, 0, $m, 1))}}</option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="employee">Year</label>
                                <input type="text" class="form-control" name="year" value="{{date('Y')}}">
                            </div>
                            <div class="col-md-3">
                                <button type="submit" style="margin-top:20px;" class="btn btn-primary">Get Details</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            @if($employeeDetails->count()>0)
                <form action="{{route('salary.prepare.store')}}" method="post">
                    <input type="hidden" name="month" value="{{request('month')}}">
                    <input type="hidden" name="year" value="{{request('year')}}">
                    <input type="hidden" value="{{$employeeDetails->count()}}" id="empCount">
                    @php
                    $totalBasic = 0;
                    @endphp
                    @foreach($employeeDetails as $detail)
                        <input type="hidden" name="employee_id[]" value="{{$detail->id}}">
                        <input type="hidden" name="department_id[]" value="{{$detail->depart_id}}">
                        <input type="hidden" name="designation_id[]" value="{{$detail->desig_id}}">
                        @php
                        $totalBasic += $detail->salary;
                        @endphp
                    @endforeach
                    @csrf
                <div class="card">
                <h4 class="card-header">Employee Name : {{$employeeDetails->count()>1?'Multiple':$employeeDetails->first()->fName}}</h4>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="">Name : {{$employeeDetails->count()>1?'Multiple':$employeeDetails->first()->fName}}</label>
                        </div>
                        <div class="col-md-3">
                            <label for="">Designation : {{$employeeDetails->count()>1?'Multiple':$employeeDetails->first()->designation->name}}</label>
                        </div>
                        <div class="col-md-3">
                            <label for="">Department : {{$employeeDetails->first()->department->name}}</label>
                        </div>
                        <div class="col-md-3">
                            <label for="">Basic Salary : </label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="tile">
                                <h3 class="tile-title">Allowances</h3>
                                <div class="tile-body">
                                @foreach($allowances->where('type', 1) as $allowance)
                                    <div class="form-group">
                                        <label class="control-label">{{$allowance->title}}</label>
                                        <input type="hidden" value="{{$allowance->id}}" name="allowance_id[]">
                                        <input class="form-control allowance" onkeyup="calculateTotal()" type="number" name="allowance_value[]" min="0" value="0" step=".001">
                                    </div>
                                @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="tile">
                                <h3 class="tile-title">Deductions</h3>
                                <div class="tile-body">
                                @foreach($allowances->where('type', 0) as $deduction)
                                    <div class="form-group">
                                        <label class="control-label">{{$deduction->title}}</label>
                                        <input type="hidden" value="{{$deduction->id}}" name="deduction_id[]">
                                        <input class="form-control deduction" onkeyup="calculateTotal()" min="0" value="0" type="number" name="deduction_value[]" step=".001">
                                    </div>
                                @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <h4 class="card-header">Individual Allowances & Deductions</h4>
                            <div class="card">
                                <div class="card-body">
                                    <label for="">Individual Allowance</label>
                                    <input type="number" readonly id="single_allowance" step=".001" class="form-control" value="0" name="single_allowance">
                                    <label for="">Individual Deduction</label>
                                    <input type="number" readonly id="single_deduction" step=".001" class="form-control" value="0" name="single_deduction">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card">
                                <h4 class="card-header">Allowances & Deductions</h4>
                                <div class="card-body">
                                    <label for="">Total Allowance</label>
                                    <input type="number" readonly id="total_allowance" step=".001" class="form-control" value="0" name="total_allowance">
                                    <label for="">Total Deduction</label>
                                    <input type="number" readonly id="total_deduction" step=".001" class="form-control" value="0" name="total_deduction">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card">
                                <h4 class="card-header">Payable</h4>
                                <div class="card-body">
                                    <label for="">Total Basic Salary</label>
                                    <input type="number" readonly id="basic_salary" step=".001" class="form-control" value="{{$totalBasic}}" name="total_payable">
                                    <label for="">Total Payable</label>
                                    <input type="number" readonly id="total_payable" step=".001" class="form-control" value="{{$totalBasic}}" name="total_payable">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="tile-footer" style="margin-top: 10px;">
                                <button class="btn btn-primary float-right" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Create</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
                </form>
            @endif
        </div>
    </div>
@endsection

@section('footer')
    <script>
        function loadEmployees(){
            var departmentId = $('#department_id').val();
            console.log(departmentId);
            $.get('{{route('employees.get')}}', {'department_id':departmentId}, function(data){
                $('#employees').empty();
                $('#employees').append($("<option />").val('*').text('All'));
                $.each(data, function(index, item) {
                    $('#employees').append($("<option />").val(item.id).text(item.fName));
                });
            });
        }
        function calculateTotal(){
            var empCount = $('#empCount').val();
            var totalAllowance = 0;
            var totalDeduction = 0;
            $('.allowance').each(function(index, data){
                totalAllowance+=parseFloat($(data).val());
            });
            $('#single_allowance').val(totalAllowance);
            totalAllowance*=empCount;
            $('.deduction').each(function(index, data){
                totalDeduction+=parseFloat($(data).val());
            });
            $('#single_deduction').val(totalDeduction);
            totalDeduction*=empCount;
            var total = parseFloat($('#basic_salary').val());
            var payable = total+totalAllowance-totalDeduction;
            $('#total_payable').val(payable);
            $('#total_allowance').val(totalAllowance);
            $('#total_deduction').val(totalDeduction);
        }
        $(document).ready(function(){
            $('#month').val("{{date('F')}}")
        })

    </script>
@endsection