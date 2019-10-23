@extends('layouts.master')

@section('title', 'Employee List')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <h4 class="card-header">Employee List <span class="float-right">
                        <a href="{!! route('employee.create') !!}"  class="btn btn-warning btn-sm">Add Employee</a>
                    </span></h4>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th width="10%">Employee Id</th>
                            <th width="5%">Photo</th>
                            <th width="15%">Employee</th>
                            <th width="15%">Designation</th>
                            <th width="15%">Department</th>
                            <th width="10%">Basic Salary</th>
                            <th width="10%">Phone No</th>
                            <th width="30%">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($employees as $key => $employee)
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>
                                   <span>
                                      <img src="{!! asset($employee->image) !!}" alt="image" class="emp_img">
                                   </span>
                                </td>
                                <td>{{$employee->fName}}</td>
                                <td>{{$employee->department->name}}</td>
                                <td>{{$employee->designation->name}}</td>
                                <td>{{$employee->salary}}/-</td>
                                <td>{{$employee->phone}}</td>
                                <td>
                                    <a href="{{route('employee.edit', $employee->id)}}" class="btn btn-primary btn-sm float-left" style="margin-right: 4px;">Edit</a>
                                    <form onsubmit="return confirm('Are You Sure This Delete ?')" method="post" action="{{route('employee.destroy', $employee->id)}}" class="float-left">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm" type="submit">Delete</button>
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
@section('head')
    <link rel="stylesheet" href="{{asset('css/jquery-ui.min.css')}}">
@endsection

@section('footer')

    <script src="{{asset('js/jquery-ui.min.js')}}"></script>

@endsection