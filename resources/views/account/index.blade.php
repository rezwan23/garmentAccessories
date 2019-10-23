@extends('layouts.master')

@section('title', 'All Accounts')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <h4 class="card-header">All Accounts <span class="float-right">
                        <a href="#" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#addNewModal">Add New</a>
                    </span></h4>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Branch</th>
                            <th>Swift</th>
                            <th>Routing Number</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($accounts as $account)
                            <tr>
                                <td>{{$loop->index+1}}</td>
                                <td>{{$account->name}}</td>
                                <td>{{$account->branch_name!=null?$account->branch_name:'N/A'}}</td>
                                <td>{{$account->swift_code!=null?$account->swift_code:'N/A'}}</td>
                                <td>{{$account->routing_number!=null?$account->routing_number:'N/A'}}</td>
                                <td><button class="btn btn-sm btn-{{$account->getStatusClass()}}">{{$account->getStatus()}}</button></td>
                                <td>
                                    @can('account-edit')
                                    <a href="{{route('account.edit', $account)}}" class="btn btn-primary btn-sm float-left" style="margin-right:4px;">Edit</a>
                                    @endcan
                                    @can('account-delete')
                                    <form class="float-left" onsubmit="return confirm('Are you sure?')" action="{{route('account.destroy', $account)}}" method="post">
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
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Add New Account</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <form action="{{route('account.store')}}" method="POST" id="create-form">
                        @csrf
                        <div class="tile-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Account Name</label>
                                        <input class="form-control" name="name" type="text" placeholder="Enter Account Name">
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">Account No</label>
                                        <input class="form-control" name="no" type="text" placeholder="Enter Account No">
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">Branch Name</label>
                                        <input class="form-control" name="brance_name" type="text" placeholder="Enter Brance Name">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Swift Code</label>
                                        <input class="form-control" name="swift_code" type="text" placeholder="Enter Swift Code">
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">Routing Number</label>
                                        <input class="form-control" name="routing_number" type="text" placeholder="Enter Routing Number">
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