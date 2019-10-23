@extends('layouts.master')

@section('title', 'Department')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <h4 class="card-header">All Department <span class="float-right">
                        <a href="#" data-toggle="modal" data-target="#modalQuestionForm" class="btn btn-warning btn-sm">Add Department</a>
                    </span></h4>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>#ID</th>
                            <th>Department Name</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($departments as $key => $department)
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{$department->name}}</td>
                                <td>
                                    @if($department->status ==1)
                                        <button class="btn btn-sm btn-success">Publish</button>
                                    @else
                                        <button class="btn btn-sm btn-warning">Un Publish</button>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{route('department.edit', $department->id)}}" class="btn btn-primary btn-sm float-left" style="margin-right: 4px;">Edit</a>
                                    <form onsubmit="return confirm('Are You Sure This Delete ?')" method="post" action="{{route('department.destroy', $department->id)}}" class="float-left">
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
                                     <h4 class="card-header">New Department <span class="float-right"><a href="{{route('department.index')}}" class="btn btn-warning btn-sm">All Department</a></span></h4>
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

                                                     <form action="{{ route('department.store')}}" method="post">
                                                         @csrf
                                                           <div class="row">
                                                               <div class="form-group col-md-4">
                                                                 <label class="control-label">Department Name</label>
                                                                 <input type="text" class="form-control" placeholder="Department Name" name="name">
                                                               </div>
                                                               <div class="form-group col-md-4">
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