@extends('layouts.master')

@section('title', 'All Payment Methods')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <h4 class="card-header">All Payment Methods <span class="float-right">
                        <a href="#" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#addNewModal">Add New</a>
                    </span></h4>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Method Name</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($methods as $method)
                            <tr>
                                <td>{{$loop->index+1}}</td>
                                <td>{{$method->name}}</td>
                                <td><button class="btn btn-sm btn-{{$method->getStatusClass()}}">{{$method->getStatus()}}</button></td>
                                <td>
                                    @can('payment-method-edit')
                                    <a href="{{route('paymentMethod.edit', $method->id)}}" class="btn btn-primary btn-sm float-left" style="margin-right:4px;">Edit</a>
                                    @endcan
                                    @can('payment-method-delete')
                                    <form class="float-left" onsubmit="return confirm('Are you sure?')" action="{{route('paymentMethod.destroy', $method->id)}}" method="post">
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
                    <h4 class="modal-title">Add New Account</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <form id="create-form" action="{{route('paymentMethod.store')}}" method="post">
                        @csrf
                    <div class="tile-body">
                            <div class="form-group">
                                <label class="control-label">Method Name</label>
                                <input class="form-control" type="text" name="name" placeholder="Enter Method Name">
                            </div>
                            <div class="form-group">
                                <label class="control-label">Status</label>
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input class="form-check-input" value="1" checked type="radio" name="status">Active
                                    </label>
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="radio" value="0" name="status">Inactive
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="tile-footer float-right">
                            <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Create</button>
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