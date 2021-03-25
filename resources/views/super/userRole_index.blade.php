@extends('adminlte::page')

@section('title', ((isset($title))?$title:""))

@section('content_header')
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="text-center bg-olive">{{$title}}</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example" class="table table-hover table-border text-center" style="width: 100%">
                            <thead>
                            <tr>
                                <th style="width: 50px;">No</th>
                                <th>Name</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($data as $i => $item)
                                <tr>
                                    <td style="width: 50px">{{$i+1}}</td>
                                    <td>{{$item->user->username}}</td>
                                    <td>{{$item->role->name}}</td>
                                    <td>
                                        <span class="badge {{$item->user->status ? "badge-success" : "badge-danger"}}">
                                            {{$item->user->status}}
                                        </span>
                                    </td>
                                    <td>
                                        <i class="fa fa-pen"></i>
                                        <i class="fa fa-trash"></i>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('footer')
    <div class="text-right">
        <strong>Copyright &copy; 2021 <a href="/">Base Project</a>.</strong> All rights reserved.
    </div>
@stop

@push('css')
@endpush

@push("js")
    @include("msg")
    <script>
        $(document).ready(function () {
            const table = $('#example').DataTable({
                "pageLength": 10,
                "bLengthChange": false,
                // "dom":'<"top">ct<"top"p><"clear">',
            });
        });
    </script>
@endpush
