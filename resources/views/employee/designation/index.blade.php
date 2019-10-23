@extends('layouts.master')

@section('title', 'Add Designation')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <h4 class="card-header">All Designation <span class="float-right">
                        <a href="#" data-toggle="modal" data-target="#modalQuestionForm" class="btn btn-warning btn-sm">Add Designation</a>
                    </span></h4>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>#ID</th>
                            <th>Department</th>
                            <th>Designation</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($designations as $key => $designation)
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{$designation->department->name}}</td>
                                <td>{{$designation->name}}</td>
                                <td>
                                    @if($designation->status ==1)
                                        <button class="btn btn-sm btn-success">Active</button>
                                    @else
                                        <button class="btn btn-sm btn-warning">Inactive</button>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{route('designation.edit', $designation->id)}}" class="btn btn-primary btn-sm float-left" style="margin-right: 4px;">Edit</a>
                                    <form onsubmit="return confirm('Are You Sure This Delete ?')" method="post" action="{{route('designation.destroy', $designation->id)}}" class="float-left">
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

    <div class="modal modal-form modal-form-sm fade" id="modalQuestionForm">
        <div class="modal-dialog">
            <div class="modal-content-1">
                <div class="modal-body">
                    <div class="modal-form">
                        <div class="row">
                             <div class="col-md-12">
                                 <div class="card">
                                     <h4 class="card-header">New Designation <span class="float-right"><a href="{{route('designation.index')}}" class="btn btn-warning btn-sm">All Designation</a></span></h4>
                                         <div class="card-body">
                                             <div class="tile">
                                                 <div class="tile-body">
                                                     @if(session('response'))
                                                        <div class="alert alert-success">{!! session('response') !!}</div>
                                                     @endif
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

                                                     <form action="{{ route('designation.store')}}" method="post">
                                                         @csrf
                                                           <div class="row">
                                                               <div class="form-group col-md-4">
                                                                   <label class="control-label">Department</label>
                                                                   <select class="form-control" name="department_id">
                                                                      @foreach($departments as $department)
                                                                       <option value="{!! $department->id !!}">{!! $department->name !!}</option>
                                                                      @endforeach
                                                                   </select>
                                                               </div>
                                                               <div class="form-group col-md-4">
                                                                 <label class="control-label">Designation</label>
                                                                 <input type="text" class="form-control" placeholder="Designation Name" name="name">
                                                               </div>
                                                               <div class="form-group col-md-2">
                                                                  <label class="control-label">Status</label>
                                                                  <select class="form-control" name="status">
                                                                    <option value="1">Active</option>
                                                                    <option value="0">Inactive</option>
                                                                  </select>
                                                               </div>
                                                            <div class="tile-add">
                                                            <div class="row">
                                                              <div class="col-md-12">
                                                                  <button class="btn btn-primary float-right" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Submit</button>
                                                              </div>
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
    @yield('modal')
    <script src="{{asset('js/jquery-ui.min.js')}}"></script>
    <script>
        @if (session()->has('response'))
        $('#modalQuestionForm').modal();
        @endif

        @if ($errors->any())
        $('#modalQuestionForm').modal();
        @endif
    </script>
@endsection