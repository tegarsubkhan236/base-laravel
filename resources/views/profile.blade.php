@extends('adminlte::page')

@section('title', ((isset($title))?:''))

@section('content_header')

@stop

@section('content')
    <div class="row">
        <!-- Profile Image -->
        <div class="col-md-3">
            <div class="card card-primary card-outline">
                <div class="card-body box-profile">
                    <div class="text-center">
                        <img class="profile-user-img img-fluid img-circle" src="{{$account->avatar?:'https://via.placeholder.com/100'}}" alt="User profile picture">
                    </div>
                    <h3 class="profile-username text-center">{{$account->name}}</h3>
                    <p class="text-muted text-center">{{Auth::user()->roles()->pluck('name')[0]}}</p>
                </div>
            </div>
        </div>

        <!-- Pages -->
        <div class="col-md-9">
            <div class="card card-primary card-outline">
                <div class="card-header p-2">
                    <ul class="nav nav-pills" id="already-set">
                        <li class="nav-item"><a class="nav-link active" href="#account" data-toggle="tab">Settings</a></li>
                        <li class="nav-item"><a class="nav-link" href="#avatar" data-toggle="tab">Photo Profile</a></li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane active" id="account">
                            <form class="form-horizontal">
                                <div class="form-group row">
                                    <label for="inputName" class="col-sm-2 col-form-label">Name</label>
                                    <div class="col-sm-10">
                                        <input type="text" value="{{$account->name}}" class="form-control" id="inputName" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputUsername" class="col-sm-2 col-form-label">Username</label>
                                    <div class="col-sm-10">
                                        <input value="{{$account->username}}" type="text" class="form-control" id="inputUsername" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputName2" class="col-sm-2 col-form-label">Status</label>
                                    <div class="col-sm-10">
                                        <span class="badge badge-{{$account->status === 1 ? 'success' : 'danger'}}">
                                            {{\App\Casts\UserStatus::lang($account->status)}}
                                        </span>
                                    </div>
                                </div>
{{--                                <div class="form-group row">--}}
{{--                                    <div class="offset-sm-2 col-sm-10">--}}
{{--                                        <button type="submit" class="btn btn-danger">Submit</button>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
                            </form>
                        </div>
                        <div class="tab-pane" id="avatar">
                            <form class="form-horizontal" action="{{route('avatar',$account->id)}}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group row">
                                    <label for="avatar" class="col-sm-2 col-form-label mt-3">Avatar</label>
                                    <div class="col-sm-10">
                                        <input type="file" name="avatar" id="avatar">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="text-right">
                                        <button type="submit" class="btn btn-outline-success">Save</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@push('css')
    <link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet" />

    <style>
        #already-set li a.active {
            display: block;
            color: white;
            background: #2E8B57;
            text-decoration: none;
        }
    </style>
@endpush

@push("js")
    <script src="https://unpkg.com/filepond/dist/filepond.js"></script>
    <script>
        const inputElement = document.querySelector('input[id="avatar"]');
        FilePond.create( inputElement );
        FilePond.setOptions({
            server : {
                url: '/upload',
                headers : {
                    'X-CSRF-ToKEN' : '{{csrf_token()}}',
                }
            }
        });
    </script>
    @include("msg")
@endpush
