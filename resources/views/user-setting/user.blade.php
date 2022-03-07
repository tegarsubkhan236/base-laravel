@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content')
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

    <div class="row">
        <div class="col-12 mt-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title text-uppercase text-bold">User Account</h3>
                </div>
                <div class="card-header">
                        <div class="row">
                            <div class="col-9">
                                <div class="btn-group-sm">
                                    @can('user-create')
                                        <a class="btn btn-success bg-olive" href="{{ route('user-setting.user.create') }}">
                                            <i class="fas fa-plus"></i> Create
                                        </a>
                                    @endcan
                                    @can('user-create')
                                        <a class="btn btn-warning" href="{{ route('user-setting.user.create') }}">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                    @endcan
                                    @can('user-create')
                                        <a class="btn btn-danger" href="{{ route('user-setting.user.create') }}">
                                            <i class="fas fa-trash"></i> Delete
                                        </a>
                                    @endcan
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="input-group btn-group-sm">
                                    <input type="text" name="table_search" class="form-control float-right" placeholder="Search">
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-default">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-head-fixed text-nowrap table-hover">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Role</th>
{{--                            <th>Action</th>--}}
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($data as $key => $user)
                            <tr class="GetID" id="{{ $user->id }}" onclick="getID()">
                                <td>{{ $key+1 }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    @if(!empty($user->getRoleNames()))
                                        @foreach($user->getRoleNames() as $v)
                                            <label class="badge badge-success">{{ $v }}</label>
                                        @endforeach
                                    @endif
                                </td>
{{--                                <td>--}}
{{--                                    <a class="btn btn-info" href="{{ route('user-setting.user.show',$user->id) }}">Show</a>--}}
{{--                                    @can('user-edit')--}}
{{--                                        <a class="btn btn-primary" href="{{ route('user-setting.user.edit',$user->id) }}">Edit</a>--}}
{{--                                    @endcan--}}
{{--                                    @can('user-delete')--}}
{{--                                        {!! Form::open(['method' => 'DELETE','route' => ['user-setting.user.destroy', $user->id],'style'=>'display:inline']) !!}--}}
{{--                                        {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}--}}
{{--                                        {!! Form::close() !!}--}}
{{--                                    @endcan--}}
{{--                                </td>--}}
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')

@stop

@section('js')

@stop
