@extends('layouts.master')

@section('title', 'Add New User')

@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <h4 class="card-header">New User</h4>
                <div class="card-body">
                    <div class="tile">
                        <form action="{{route('user.store')}}" method="post">
                            @csrf
                            <div class="tile-body">
                                <div class="form-group {{$errors->has('name')?'has-danger':''}}">
                                    <label class="control-label">Name</label>
                                    <input class="form-control {{$errors->has('name')?'is-invalid':''}}" required name="name" type="text" placeholder="Enter full name">
                                    @if($errors->has('name'))
                                        <div class="form-control-feedback">{{$errors->first('name')}}</div>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Role</label>
                                    <select name="role_id" id="" class="form-control">
                                        @foreach($roles as $role)
                                            @if($role->name=='Super Super Admin')
                                                @continue
                                            @endif
                                            <option value="{{$role->id}}">{{$role->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group {{$errors->has('email')?'has-danger':''}}">
                                    <label class="control-label">Email</label>
                                    <input class="form-control {{$errors->has('email')?'is-invalid':''}}" name="email" required type="email" placeholder="Enter email address">
                                    @if($errors->has('email'))
                                        <div class="form-control-feedback">{{$errors->first('email')}}</div>
                                    @endif
                                </div>
                                <div class="form-group {{$errors->has('password')?'has-danger':''}}">
                                    <label class="control-label">Password</label>
                                    <input class="form-control {{$errors->has('password')?'is-invalid':''}}" name="password" required type="password" placeholder="Enter Password">
                                    @if($errors->has('password'))
                                        <div class="form-control-feedback">{{$errors->first('password')}}</div>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Password Confirm</label>
                                    <input class="form-control" name="password_confirmation" required type="password" placeholder="Enter Password Again">
                                </div>
                            </div>
                            <div class="tile-footer">
                                <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Create</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection