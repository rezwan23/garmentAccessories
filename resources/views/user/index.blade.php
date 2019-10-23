@extends('layouts.master')

@section('title', 'All Users')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <h4 class="card-header">All Users <span class="float-right">
                        <a href="{{route('user.create')}}" class="btn btn-warning btn-sm">Add New</a>
                    </span></h4>
                <div class="card-body">
                    <div class="tile">
                        <div class="tile-body">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $i=0;?>
                                @foreach($users as $user)
                                    @if($user->role->name=='Super Super Admin')
                                        @continue;
                                        @endif
                                <tr>
                                    <td>{{$i+1}}</td>
                                    <td>{{$user->name}}</td>
                                    <td>{{$user->email}}</td>
                                    <td>{{$user->role->name}}</td>
                                    <td>
                                        <span class="badge badge-{{$user->statusClass()}}">{{$user->statusText()}}</span>
                                    </td>
                                    <td>
                                        <a href="{{route('user.edit', $user)}}" class="btn btn-primary btn-sm float-left" style="margin-right: 4px;">Edit</a>
                                        @if($user->status)
                                            <form action="{{route('user.inactive', $user)}}" method="post">
                                                @csrf
                                                @method('PUT')
                                                <button class="btn btn-warning btn-sm" type="submit">Inactive</button>
                                            </form>
                                            @else
                                            <form action="{{route('user.active', $user)}}" method="post">
                                                @csrf
                                                @method('PUT')
                                                <button class="btn btn-warning btn-sm" type="submit">Active</button>
                                            </form>
                                            @endif
                                        <a href="{{route('user.password.change', $user)}}" class="btn btn-primary btn-sm float-left" style="margin-right: 4px;">Change Password</a>
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
        </div>
    </div>

@endsection