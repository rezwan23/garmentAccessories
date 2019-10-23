@extends('layouts.master')

@section('title', 'Employee Profile')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <h4 class="card-header">Employee Profile <span class="float-right"><a href="{{route('employee.index')}}" class="btn btn-warning btn-sm">All Employee</a></span></h4>

                <div class="card-body">
                  <div class="tile">
                      <div class="tile-body">
                          @if($errors->any())
                              <div class="alert alert-danger">
                                  <h5>Errors!</h5>
                                  <ul>
                                      @foreach($errors->all() as $error)
                                          <li>{{ $error }}</li>
                                      @endforeach
                                  </ul>
                              </div>
                          @endif

                          <form  action="{!! route('employee.update',$employee->id) !!}" class="" method="POST" name="edit_employee" enctype="multipart/form-data">
                             @method('PUT')
                              @csrf
                            <div class="row">
                            <div class="col-md-12">
                                <div class="panel panel-warning panel-solid">
                                    <div class="panel-heading with-border">
                                        <h5 class="card-header">Personal Information</h5>
                                    </div>
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <br/>
                                                <div class="row form-group">
                                                    <label class="control-label col-sm-3 text-right">Department</label>
                                                    <div class="col-sm-8">
                                                        <select name="depart_id" id="department" onchange="loadDesignation()" class="form-control">
                                                            <option value="">Select Department</option>
                                                           @foreach($departments as $department)
                                                            <option value="{!! $department->id !!}">{!! $department->name !!}</option>
                                                           @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <br/>
                                                <div class="row form-group">
                                                    <label class="control-label col-sm-3 text-right">Designation</label>
                                                    <div class="col-sm-8">
                                                        <select name="desig_id" class="form-control" id="designation">
                                                            <option value="{{$employee->designation->id}}">{{$employee->designation->name}}</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row form-group">
                                                    <label class="control-label col-sm-3 text-right">Joining Date</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" id="demoDate" value="{!! !empty($employee->joining) ? $employee->joining: date('Y-m-d') !!}" name="joining" class="form-control datepicker" placeholder="Joining Date">
                                                        </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row form-group">
                                                    <label class="control-label col-sm-3 text-right">Basic Salary</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" name="salary" value="{!! $employee->salary !!}" class="form-control" placeholder="Basic Salary">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row form-group">
                                                    <label class="control-label col-sm-3 text-right">Name</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" value="{!! $employee->fName !!}" name="fName" placeholder="Name">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row form-group">
                                                    <label class="control-label col-sm-3 text-right">Father Name</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" value="{!! $employee->faName !!}" class="form-control" name="faName" placeholder="Father Name" >
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="control-label col-sm-3 text-right">Mother Name</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" value="{!! $employee->moName !!}" name="moName" placeholder="Mother Name" >
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group row">
                                                    <label class="control-label col-sm-3 text-right">Gender</label>
                                                    <div class="col-sm-8">
                                                        <select name="gender" class="form-control">
                                                            <option value="">Select Gender</option>
                                                            <option value="1">Male</option>
                                                            <option value="2">Female</option>
                                                            <option value="3">Other</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group row">
                                                    <label class="control-label col-sm-3 text-right">Blood Group</label>
                                                    <div class="col-sm-8">
                                                        <select name="blood" class="form-control">
                                                            <option value="">Select Blood Group</option>
                                                            <option value="1">A+</option>
                                                            <option value="2">A-</option>
                                                            <option value="3">B+</option>
                                                            <option value="4">B-</option>
                                                            <option value="5">AB+</option>
                                                            <option value="6">AB-</option>
                                                            <option value="7">O+</option>
                                                            <option value="8">O-</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group row">
                                                    <label class="control-label col-sm-3 text-right">Religion</label>
                                                    <div class="col-sm-8">
                                                        <select name="religion" class="form-control">
                                                            <option value="">Select Religion</option>
                                                            <option value="1">Muslim</option>
                                                            <option value="2">Hindu</option>
                                                            <option value="3">Buddhish</option>
                                                            <option value="4">Christian</option>
                                                            <option value="5">Other</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="control-label col-sm-3 text-right">NID</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" name="nid" value="{!! $employee->nid !!}" placeholder="NID" >
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="control-label col-sm-3 text-right">Date of Birth</label>
                                                    <div class=" col-sm-8">
                                                        <div class="input-group">
                                                            <input type="text" id="demoDate1" name="dob" class="form-control" placeholder="Date of Birth" value="{!! !empty($employee->joining) ? $employee->joining: date('Y-m-d') !!}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group row">
                                                    <label class="control-label col-sm-3 text-right">Marriage Status</label>
                                                    <div class="col-sm-8">
                                                        <select name="marriage" class="form-control">
                                                            <option value="">Select One</option>
                                                            <option value="1">Married</option>
                                                            <option value="2">Unmarried</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group row">
                                                    <label class="control-label col-sm-3 text-right" >Mobile Number</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" name="phone" placeholder="0178XXXXX" value="{!! $employee->phone !!}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group row">
                                                    <label class="control-label col-sm-3 text-right" >Email Address</label>
                                                    <div class="col-sm-8">
                                                        <input type="email" class="form-control" name="email" placeholder="Email Address" value="{!! $employee->email !!}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group row ">
                                                    <label class="control-label col-sm-3 text-right">Emergency Contact</label>
                                                    <div class="col-sm-8">
                                                       <input type="text" name="phone_emer" class="form-control" placeholder="017XXXXXXX" value="{!! $employee->phone_emer !!}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group row">
                                                    <label class="control-label col-sm-3 text-right">Employee Image(120x120)</label>
                                                    <div class="col-sm-4">
                                                        <input type="file" class="form-control"  name="image" >
                                                    </div>
                                                    <div class="col-sm-3">
                                                       <span>
                                                        <img src="{!! asset($employee->image) !!}" alt="image" class="emp_img">
                                                       </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group row">
                                                    <label class="control-label col-sm-3 text-right">Present Address</label>
                                                    <div class="col-sm-8">
                                                        <textarea type="text" class="form-control" rows="5" name="present_add" >{!! $employee->present_add !!}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group row">
                                                    <label class="control-label col-sm-3 text-right">Permanent Address</label>
                                                    <div class="col-sm-8">
                                                        <textarea type="text" class="form-control" rows="5" name="permanent_add" >{!! $employee->permanent_add !!}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                           <br/> <br/>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group" align="center">
                                    <button type="submit" class="btn btn-success">Update Registration</button>
                                </div>
                            </div>
                        </div>
                     </form>
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
    <script src="{{asset('admin/js/plugins/bootstrap-datepicker.min.js')}}"></script>
    <script src="{{asset('js/jquery-ui.min.js')}}"></script>
    <script>
        document.forms['edit_employee'].elements['depart_id'].value='{!! $employee->depart_id !!}';
        document.forms['edit_employee'].elements['gender'].value='{!! $employee->gender !!}';
        document.forms['edit_employee'].elements['blood'].value='{!! $employee->blood !!}';
        document.forms['edit_employee'].elements['religion'].value='{!! $employee->religion !!}';
        document.forms['edit_employee'].elements['marriage'].value='{!! $employee->marriage !!}';
    </script>

    <script>
        function loadDesignation(){
            var departmentId = $('#department').val();
            console.log();
            $.get('{{route('designations.get')}}', {'id':departmentId}, function(data){
                $('#designation').empty();
                $('#designation').append('<option value="null">Select Designation</option>');
                $.each(data, function(index, items){
                    $('#designation').append('<option value="'+items.id+'">'+items.name+'</option>');
                });
            })
        }
    </script>
    <script>
        $('#demoDate').datepicker({
            format: "yyyy-mm-dd",
            autoclose: true,
            todayHighlight: true
        });
        $('#demoDate1').datepicker({
            format: "yyyy-mm-dd",
            autoclose: true,
            todayHighlight: true
        });
    </script>
@endsection