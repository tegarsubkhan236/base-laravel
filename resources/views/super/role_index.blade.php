@extends('adminlte::page')

@section('title', ((isset($title))?$title:""))

@section('content_header')@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-11">
                            <h3 class="text-center bg-olive mt-2">{{$title}}</h3>
                        </div>
                        <div class="col-1 text-right">
                            <button data-toggle="modal" data-target="#add" class="btn btn-lg  btn-outline-success">
                                <i class="fa fa-plus-circle"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example" class="table table-hover table-border text-center" style="width: 100%">
                            <thead>
                            <tr>
                                <th style="width: 50px;">ID</th>
                                <th>Name</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($data as $i => $item)
                                <tr>
                                    <td style="width: 50px">{{$item->id}}</td>
                                    <td>{{$item->name}}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <button
                                                    data-id="{{$item->id}}"
                                                    data-namE="{{$item->name}}"
                                                    type="button"
                                                    class="edit btn btn-tool btn-outline-info">
                                                <i class="fa fa-pen"></i>
                                            </button>
                                        </div>
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

    <!-- Add -->
    <div class="modal fade" id="add" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                @include('super.role_form');
            </div>
        </div>
    </div>

    <!-- Edit -->
    <div class="modal fade" id="edit" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                @include('super.role_form');
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
                "dom":'<"top">ct<"top"p><"clear">',
            });
            $("#example .edit").on("click",function(){
                let params = $(this)
                let role_id = params.data("id")
                let name = params.data("name")
                $("#edit").modal();
                $("#edit").find(".modal-body input[name=name]").val(name);
                $("#edit").find(".modal-body form").attr("action","{{route("super.role.update")}}/"+role_id);
                $("#edit").find(".modal-title").text("Edit Role");
            });
        });
    </script>
@endpush
