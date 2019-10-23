@extends('layouts.master')

@section('title', 'Change Password for - '.$user->name)

@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <h4 class="card-header">Change Password - {{$user->name}}</h4>
                <div class="card-body">
                    <div class="tile">
                        <form action="{{route('user.password.change', $user)}}" method="post">
                            @csrf
                            <div class="tile-body">
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