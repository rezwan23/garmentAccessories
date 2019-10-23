@extends('layouts.master')

@section('title', 'Edit Allowance & Deduction')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <h4 class="card-header">Edit Allowance & Deduction <span class="float-right"><a href="{{route('allowance.index')}}" class="btn btn-warning btn-sm">All Allowance & Deduction</a></span></h4>
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

                            <form action="{{ route('allowance.update',$allowance->id)}}" method="post" name="edit_allowance">
                                @method('PUT')
                                @csrf
                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label class="control-label">Title</label>
                                        <input type="text" class="form-control" name="title" placeholder="Title" value="{!! $allowance->title !!}" required>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label class="control-label">Type</label>
                                        <select class="form-control" name="type">
                                            <option value="1">Allowance</option>
                                            <option value="0">Deduction</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-3">
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

    <!-- The Modal -->
@endsection

@section('footer')

    <script src="{{asset('js/form.js')}}"></script>

    <script>
        $('#create-form').transmitData({
            formReset: false,
            redirectPath: location.href,
        });
    </script>
    <script>
        document.forms['edit_allowance'].elements['type'].value='{!! $allowance->type !!}';
        document.forms['edit_allowance'].elements['status'].value='{!! $allowance->status !!}';
    </script>

@endsection