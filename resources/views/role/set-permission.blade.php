@extends('layouts.master')

@section('title', 'Set Permission')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <h4 class="card-header">Set Permission for role: {{$role->name}}</h4>
                <div class="card-body">
                    <div class="tile">
                        <form action="" method="post">
                        <div class="tile-body">

                                @csrf
                            <div class="row">
                                <input type="hidden" name="role_id" value="{{$role->id}}">
                                <div class="col-md-4">
                                    <h4>Order</h4>
                                @foreach($permissions->where('group', 'order') as $permission)
                                    <div class="animated-checkbox">
                                        <label>
                                            <input type="checkbox"
                                                   @foreach($role->permissions as $perm)
                                                           @if($perm->id == $permission->id)
                                                           checked
                                                            @break
                                                        @endif
                                                   @endforeach
                                            name="permission_id[]" value="{{$permission->id}}"><span class="label-text">{{$permission->name}}</span>
                                        </label>
                                    </div>
                                @endforeach
                                </div>
                                <div class="col-md-4">
                                    <h4>Sample Order</h4>
                                    @foreach($permissions->where('group', 'Sample') as $permission)
                                        <div class="animated-checkbox">
                                            <label>
                                                <input type="checkbox"
                                                       @foreach($role->permissions as $perm)
                                                       @if($perm->id == $permission->id)
                                                       checked
                                                       @break
                                                       @endif
                                                       @endforeach
                                                       name="permission_id[]" value="{{$permission->id}}"><span class="label-text">{{$permission->name}}</span>
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="col-md-4">
                                    <h4>Commercial</h4>
                                    @foreach($permissions->where('group', 'commercial') as $permission)
                                        <div class="animated-checkbox">
                                            <label>
                                                <input type="checkbox"
                                                       @foreach($role->permissions as $perm)
                                                       @if($perm->id == $permission->id)
                                                       checked
                                                       @break
                                                       @endif
                                                       @endforeach
                                                       name="permission_id[]" value="{{$permission->id}}"><span class="label-text">{{$permission->name}}</span>
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="col-md-4">
                                    <h4>Dyeing</h4>
                                    @foreach($permissions->where('group', 'dyeing') as $permission)
                                        <div class="animated-checkbox">
                                            <label>
                                                <input type="checkbox"
                                                       @foreach($role->permissions as $perm)
                                                       @if($perm->id == $permission->id)
                                                       checked
                                                       @break
                                                       @endif
                                                       @endforeach
                                                       name="permission_id[]" value="{{$permission->id}}"><span class="label-text">{{$permission->name}}</span>
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="col-md-4">
                                    <h4>Factory</h4>
                                    @foreach($permissions->where('group', 'factory') as $permission)
                                        <div class="animated-checkbox">
                                            <label>
                                                <input type="checkbox"
                                                       @foreach($role->permissions as $perm)
                                                       @if($perm->id == $permission->id)
                                                       checked
                                                       @break
                                                       @endif
                                                       @endforeach
                                                       name="permission_id[]" value="{{$permission->id}}"><span class="label-text">{{$permission->name}}</span>
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="col-md-4">
                                    <h4>Purchase</h4>
                                    @foreach($permissions->where('group', 'purchase') as $permission)
                                        <div class="animated-checkbox">
                                            <label>
                                                <input type="checkbox"
                                                       @foreach($role->permissions as $perm)
                                                       @if($perm->id == $permission->id)
                                                       checked
                                                       @break
                                                       @endif
                                                       @endforeach
                                                       name="permission_id[]" value="{{$permission->id}}"><span class="label-text">{{$permission->name}}</span>
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="col-md-4">
                                    <h4>Employee</h4>
                                    @foreach($permissions->where('group', 'employee') as $permission)
                                        <div class="animated-checkbox">
                                            <label>
                                                <input type="checkbox"

                                                       @foreach($role->permissions as $perm)
                                                       @if($perm->id == $permission->id)
                                                       checked
                                                       @break
                                                       @endif
                                                       @endforeach
                                                       name="permission_id[]" value="{{$permission->id}}"><span class="label-text">{{$permission->name}}</span>
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="col-md-4">
                                    <h4>Account</h4>
                                    @foreach($permissions->where('group', 'account') as $permission)
                                        <div class="animated-checkbox">
                                            <label>
                                                <input type="checkbox"
                                                       @foreach($role->permissions as $perm)
                                                       @if($perm->id == $permission->id)
                                                       checked
                                                       @break
                                                       @endif
                                                       @endforeach
                                                       name="permission_id[]" value="{{$permission->id}}"><span class="label-text">{{$permission->name}}</span>
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="col-md-4">
                                    <h4>Account Configuration</h4>
                                    @foreach($permissions->where('group', 'account-configuration') as $permission)
                                        <div class="animated-checkbox">
                                            <label>
                                                <input type="checkbox"
                                                       @foreach($role->permissions as $perm)
                                                       @if($perm->id == $permission->id)
                                                       checked
                                                       @break
                                                       @endif
                                                       @endforeach
                                                       name="permission_id[]" value="{{$permission->id}}"><span class="label-text">{{$permission->name}}</span>
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="col-md-4">
                                    <h4>Salary Allowance</h4>
                                    @foreach($permissions->where('group', 'salary-allowance') as $permission)
                                        <div class="animated-checkbox">
                                            <label>
                                                <input type="checkbox"
                                                       @foreach($role->permissions as $perm)
                                                       @if($perm->id == $permission->id)
                                                       checked
                                                       @break
                                                       @endif
                                                       @endforeach
                                                       name="permission_id[]" value="{{$permission->id}}"><span class="label-text">{{$permission->name}}</span>
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="col-md-4">
                                    <h4>Payroll</h4>
                                    @foreach($permissions->where('group', 'payroll') as $permission)
                                        <div class="animated-checkbox">
                                            <label>
                                                <input type="checkbox"
                                                       @foreach($role->permissions as $perm)
                                                       @if($perm->id == $permission->id)
                                                       checked
                                                       @break
                                                       @endif
                                                       @endforeach
                                                       name="permission_id[]" value="{{$permission->id}}"><span class="label-text">{{$permission->name}}</span>
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="col-md-4">
                                    <h4>Settings</h4>
                                    @foreach($permissions->where('group', 'settings') as $permission)
                                        <div class="animated-checkbox">
                                            <label>
                                                <input type="checkbox"
                                                       @foreach($role->permissions as $perm)
                                                       @if($perm->id == $permission->id)
                                                       checked
                                                       @break
                                                       @endif
                                                       @endforeach
                                                       name="permission_id[]" value="{{$permission->id}}"><span class="label-text">{{$permission->name}}</span>
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="col-md-4">
                                    <h4>Reports</h4>
                                    @foreach($permissions->where('group', 'reports') as $permission)
                                        <div class="animated-checkbox">
                                            <label>
                                                <input type="checkbox"
                                                       @foreach($role->permissions as $perm)
                                                       @if($perm->id == $permission->id)
                                                       checked
                                                       @break
                                                       @endif
                                                       @endforeach
                                                       name="permission_id[]" value="{{$permission->id}}"><span class="label-text">{{$permission->name}}</span>
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="col-md-4">
                                    <h4>User</h4>
                                    @foreach($permissions->where('group', 'user') as $permission)
                                        <div class="animated-checkbox">
                                            <label>
                                                <input type="checkbox"
                                                       @foreach($role->permissions as $perm)
                                                       @if($perm->id == $permission->id)
                                                       checked
                                                       @break
                                                       @endif
                                                       @endforeach
                                                       name="permission_id[]" value="{{$permission->id}}"><span class="label-text">{{$permission->name}}</span>
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="col-md-4">
                                    <h4>Other Settings</h4>
                                    @foreach($permissions->where('group', 'Other Settings') as $permission)
                                        <div class="animated-checkbox">
                                            <label>
                                                <input type="checkbox"
                                                       @foreach($role->permissions as $perm)
                                                       @if($perm->id == $permission->id)
                                                       checked
                                                       @break
                                                       @endif
                                                       @endforeach
                                                       name="permission_id[]" value="{{$permission->id}}"><span class="label-text">{{$permission->name}}</span>
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="col-md-4">
                                    <h4>Backup</h4>
                                    @foreach($permissions->where('group', 'Backup') as $permission)
                                        <div class="animated-checkbox">
                                            <label>
                                                <input type="checkbox"

                                                       @foreach($role->permissions as $perm)
                                                       @if($perm->id == $permission->id)
                                                       checked
                                                       @break
                                                       @endif
                                                       @endforeach
                                                       name="permission_id[]" value="{{$permission->id}}"><span class="label-text">{{$permission->name}}</span>
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="tile-footer">
                            <div class="row">
                                <div class="col-md-12">
                                    <button class="btn btn-primary float-right" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Submit</button>
                                </div>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection