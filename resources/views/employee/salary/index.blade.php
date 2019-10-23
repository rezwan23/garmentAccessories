@extends('layouts.master')

@section('title', 'Salary Setup List')

@section('content')
<div class="row">
<div class="col-md-12">
        <div class="card">
            <h4 class="card-header">Salary Setup List <span class="float-right"><a href="" class="btn btn-warning btn-sm">Generate  </a></span></h4>
            <div class="card-body">
                <div class="tile">
                    <div class="tile-body">
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label class="control-label">Department</label>
                                    <form action="" id="department_submit">
                                        <select onchange="formSubmit();" class="form-control" name="department_id">
                                            <option value="">Select Department</option>
                                            @foreach($departments as $department)
                                                <option value="{!! $department->id !!}">{!! $department->name !!}</option>
                                            @endforeach
                                        </select>
                                    </form>
                                </div>
                                {{--<div class="tile-add">--}}
                                    {{--<div class="row">--}}
                                        {{--<div class="col-md-12">--}}
                                            {{--<button class="btn btn-primary float-right" id="submit" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Get</button>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                    {{--<br/><br/>--}}
                                {{--</div>--}}
                          @if($employeeDetails->count()>0)
                            <div class="col-md-12 hidden" id="view">
                                <div class="panel">
                                    <div class="panel-heading">
                                        <div class="panel-heading-btn">
                                        </div>
                                        <br/><br/>
                                        <h4 class="panel-title">Salary List</h4>
                                    </div>
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-sm-12">

                                                <table class="table table-bordered table-hover">
                                                    <thead>
                                                    <tr>
                                                        <th width="10%">Employee Id</th>
                                                        <th width="5%">Photo</th>
                                                        <th width="15%">Employee</th>
                                                        <th width="15%">Designation</th>
                                                        <th width="15%">Department</th>
                                                        <th width="15%">Basic Salary</th>
                                                        <th width="20%">Action</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody id="load_data">
                                                        @foreach($employeeDetails as  $employee)
                                                            <tr>
                                                                <td>{{$employee->id}}</td>
                                                                <td>
                                                                   <span>
                                                                      <img src="{!! asset($employee->image) !!}" alt="image" class="emp_img1" >
                                                                   </span>
                                                                </td>
                                                                <td>{{$employee->fName}}</td>
                                                                <td>{{$employee->designation->name}}</td>
                                                                <td>{{$employee->department->name}}</td>
                                                                <td>{{$employee->salary}}/- BDT</td>
                                                                <td>
                                                                    <a href="{{route('employee.show', $employee->id)}}" class="btn btn-primary btn-sm float-left" style="margin-right: 2px;">View</a>
                                                                    <a href="{{route('employee.edit', $employee->id)}}" class="btn btn-primary btn-sm" style="margin-right: 2px;">Edit</a>
                                                                    <form onsubmit="return confirm('Are You Sure This Delete ?')" method="post" action="{{route('employee.destroy', $employee->id)}}" class="float-left">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button class="btn btn-danger btn-sm float-left" style="margin-right: 2px;" type="submit">Delete</button>
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
                            </div>
                          @endif
                        </div>
                    </div>
                </div>
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

        function formSubmit(){
            $('#department_submit').submit();
        }
    </script>
@endsection