@extends('layouts.master')

@section('title', 'User Profile')

@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <h4 class="card-header">User Profile</h4>
                <div class="card-body">
                    <div class="tile">
                        <h3 class="tile-title">Edit User</h3>
                        <form action="{{route('profile', $user)}}" method="post">
                            @csrf
                            <div class="tile-body">
                                <div class="form-group {{$errors->has('name')?'has-danger':''}}">
                                    <label class="control-label">Name</label>
                                    <input class="form-control {{$errors->has('name')?'is-invalid':''}}" value="{{$user->name}}" required name="name" type="text" placeholder="Enter full name">
                                    @if($errors->has('name'))
                                        <div class="form-control-feedback">{{$errors->first('name')}}</div>
                                    @endif
                                </div>
                                <div class="form-group {{$errors->has('email')?'has-danger':''}}">
                                    <label class="control-label">Email</label>
                                    <input class="form-control {{$errors->has('email')?'is-invalid':''}}" value="{{$user->email}}" name="email" required type="email" placeholder="Enter email address">
                                    @if($errors->has('email'))
                                        <div class="form-control-feedback">{{$errors->first('email')}}</div>
                                    @endif
                                </div>
                            </div>
                            <div class="tile-footer">
                                <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Update</button>
                                <a href="#" data-toggle="modal" data-target="#myModal" class="btn btn-success">Change Password</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="myModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Change Password</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <form action="{{route('password.change', $user)}}" method="post">
                        @csrf
                        <label for="">Old Password</label>
                        <input type="password" class="form-control" required name="old_password">
                        <label for="">Password</label>
                        <input type="password" class="form-control" required name="password">
                        <label for="">Password Type again</label>
                        <input class="form-control" type="password" required name="password_confirmation">
                        <br>
                        <button type="submit" class="btn btn-primary">Change Password</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection