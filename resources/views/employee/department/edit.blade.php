@extends('layouts.master')

@section('title', 'Department')

@section('content')
<div class="row">
<div class="col-md-12">
        <div class="card">
            <h4 class="card-header">Edit Department <span class="float-right"><a href="{{route('department.index')}}" class="btn btn-warning btn-sm">All Department</a></span></h4>
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

                        <form action="{{ route('department.update',$department)}}" method="post" name="edit_department">
                            @method('PUT')
                            @csrf
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label class="control-label">Department Name</label>
                                    <input type="text" class="form-control" placeholder="Department Name" value="{!! $department->name !!}" name="name">
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


@endsection
@section('head')
    <link rel="stylesheet" href="{{asset('css/jquery-ui.min.css')}}">
@endsection

@section('footer')
    <script src="{{asset('js/jquery-ui.min.js')}}"></script>
    <script>
        document.forms['edit_department'].elements['status'].value='{!! $department->status !!}';
    </script>
@endsection