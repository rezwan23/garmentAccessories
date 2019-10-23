@extends('layouts.master')

@section('title', 'All Allowance & Deduction')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <h4 class="card-header">All Allowance & Deduction <span class="float-right">
                        <a href="#" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#addNewModal">Add Allowance & Deduction</a>
                    </span></h4>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Type</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($allowances as $allowance)
                            <tr>
                                <td>{{$loop->index+1}}</td>
                                <td>{{$allowance->title}}</td>
                                <td>
                                    @if($allowance->type == 1)
                                        <button class="btn btn-sm btn-success">Allowance</button>
                                    @else
                                        <button class="btn btn-sm btn-primary">Deduction</button>
                                    @endif

                                </td>
                                <td>
                                    @if($allowance->status == 1)
                                        <button class="btn btn-sm btn-success">Active</button>
                                    @else
                                        <button class="btn btn-sm btn-danger">Inactive</button>
                                    @endif

                                </td>
                                <td>
                                    <a href="{{route('allowance.edit', $allowance)}}" class="btn btn-primary btn-sm float-left" style="margin-right:4px;">Edit</a>

                                    <form class="float-left" onsubmit="return confirm('Are You Sure This Delete ?')" action="{{route('allowance.destroy', $allowance)}}" method="post">
                                        @method('DELETE')
                                        @csrf
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

    <!-- The Modal -->
    <div class="modal fade" id="addNewModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Add New Allowance & Deduction</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <form action="{{route('allowance.store')}}" method="POST">
                        @csrf
                        <div class="tile-body">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="row form-group">
                                        <label class="control-label col-sm-3 text-right">Title</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" name="title" placeholder="Title" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-8">
                                        <div class="row form-group">
                                            <label class="control-label col-sm-3 text-right">Type</label>
                                            <div class="col-sm-8">
                                                <select class="form-control" name="type">
                                                    <option value="1">Allowance</option>
                                                    <option value="0">Deduction</option>
                                                </select>
                                            </div>
                                        </div>
                                 </div>
                                <div class="col-sm-8">
                                        <div class="row form-group">
                                            <label class="control-label col-sm-3 text-right">Status</label>
                                            <div class="col-sm-8">
                                                <select class="form-control" name="status">
                                                    <option value="1">Active</option>
                                                    <option value="0">Inactive</option>
                                                </select>
                                                    <br/>
                                                <button class="btn btn-primary float-left" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Submit</button>
                                            </div>
                                        </div>
                                    </div>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('footer')

    <script src="{{asset('js/form.js')}}"></script>

    <script>
        $('#create-form').transmitData({
            formReset: false,
            redirectPath: location.href,
        });
    </script>

@endsection/