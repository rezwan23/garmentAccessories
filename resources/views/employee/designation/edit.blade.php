@extends('layouts.master')

@section('title', 'Edit Designation')

@section('content')
<div class="row">
<div class="col-md-12">
        <div class="card">
            <h4 class="card-header">Edit Designation <span class="float-right"><a href="{{route('designation.index')}}" class="btn btn-warning btn-sm">All Designation</a></span></h4>
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

                        <form action="{{ route('designation.update',$edit)}}" method="post" name="edit_designation">
                            @method('PUT')
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
                                    <input type="text" class="form-control" placeholder="Department Name" value="{!! $edit->name !!}" name="name">
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
                                            <button class="btn btn-primary float-right" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Update</button>
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


@endsection
@section('head')
    <link rel="stylesheet" href="{{asset('css/jquery-ui.min.css')}}">
@endsection

@section('footer')
    <script src="{{asset('js/jquery-ui.min.js')}}"></script>
    <script>
        document.forms['edit_designation'].elements['status'].value='{!! $edit->status !!}';
        document.forms['edit_designation'].elements['department_id'].value='{!! $edit->department->id !!}';
    </script>
@endsection