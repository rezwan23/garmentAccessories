@extends('layouts.master')

@section('title', 'All Roles')

@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="tile">
                <h3 class="tile-title float-left">All Roles</h3>
                <a href="{{route('role.create')}}" class="btn btn-warning btn-sm float-right">Create Role</a>
                <div class="tile-body">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $i=0;?>
                        @foreach($roles as $role)
                            @if($role->name == 'Super Super Admin')
                                @continue
                                @endif
                            <tr>
                                <td>{{$i+1}}</td>
                                <td>{{$role->name}}</td>
                                <td>
                                    <a href="{{route('role.permission.set', $role)}}" class="float-left btn btn-primary btn-sm">Set Permission</a>
                                    <form action="{{route('role.destroy', $role)}}" onsubmit="return confirm('Are You Sure?')" class="float-left" style="margin-left:4px" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            <?php $i++;?>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection