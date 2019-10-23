@extends('layouts.master')

@section('title', 'All sectors')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <h4 class="card-header">All Account Sectors <span class="float-right">
                        <a href="#" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#addNewModal">Add New</a>
                    </span></h4>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Sector type</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($sectors as $sector)
                            <tr>
                                <td>{{$loop->index+1}}</td>
                                <td>{{$sector->name}}</td>
                                <td><button class="btn btn-sm btn-{{$sector->getSectorTypeClass()}}">{{$sector->getSectorType()}}</button></td>
                                <td><button class="btn btn-sm btn-{{$sector->getStatusClass()}}">{{$sector->getStatus()}}</button></td>
                                <td>
                                    @can('sector-edit')
                                        <a href="{{route('accountSector.edit', $sector->id)}}" class="btn btn-primary btn-sm float-left" style="margin-right:4px;">Edit</a>
                                    @endcan
                                    @can('sector-delete')
                                    <form class="float-left" onsubmit="return confirm('Are you sure?')" action="{{route('accountSector.destroy', $sector->id)}}" method="post">
                                        @method('DELETE')
                                        @csrf
                                        <button class="btn btn-danger btn-sm" type="submit">Delete</button>
                                    </form>
                                    @endcan
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
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Add New Sector</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <form action="{{route('accountSector.store')}}" method="POST" id="create-form">
                        @csrf
                    <div class="tile-body">
                            <div class="form-group">
                                <label class="control-label">Sector Name</label>
                                <input class="form-control" name="name" type="text" placeholder="Enter Sector name">
                            </div>
                        <div class="form-group">
                            <label class="control-label">Sector Type</label>
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="radio" value="1" checked name="sector_type">Income
                                </label>
                            </div>
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="radio" value="0" name="sector_type">Expense
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Status</label>
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="radio" value="1" checked name="status">Active
                                </label>
                            </div>
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="radio" value="0" name="status">Inactive
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="tile-footer">
                        <button class="btn btn-primary float-right" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Submit</button>
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

    @endsection