@extends('adminlte::page')

@section('title', ($title?:""))

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
                        <table id="dtable" class="table table-hover table-border text-center" style="width: 100%">
                            <thead>
                            <tr>
                                <th class="align-middle" style="width: 50px;" rowspan="2">No</th>
                                <th class="align-middle" rowspan="2">Avatar</th>
                                <th>Name</th>
                                <th>Username</th>
                                <th>Role</th>
                                <th class="align-middle" rowspan="2">Status</th>
                                <th class="align-middle" rowspan="2">Action</th>
                            </tr>
                            <tr>
                                <td>Name</td>
                                <td>Username</td>
                                <td>Role</td>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($data as $i => $item)
                                <tr>
                                    <td class="align-middle" style="width: 50px">{{$i+1}}</td>
                                    <td class="align-middle">
                                        <img src="{{$item->avatar ?: 'https://via.placeholder.com/125'}}" class="img-circle" alt="avatar">
                                    </td>
                                    <td class="align-middle">{{$item->name}}</td>
                                    <td class="align-middle">{{$item->username}}</td>
                                    <td class="align-middle">
                                        @forelse($item->roles as $role)
                                            <span class="badge badge-info">{{\App\Casts\UserLevel::lang($role->id)}}</span>
                                        @empty
                                            <span class="badge badge-danger">Null</span>
                                        @endforelse
                                    </td>
                                    <td class="align-middle">
                                        <label>
                                            <input data-id="{{$item->id}}" class="toggle-class" type="checkbox" data-onstyle="success" data-offstyle="danger" data-toggle="toggle" data-on="Active" data-off="InActive"{{ $item->status ? 'checked' : '' }} />
                                        </label>
                                    </td>
                                    <td class="align-middle">
                                        <div class="btn-group" role="group">
                                            <button
                                                    data-id = "{{$item->id}}"
                                                    data-name = "{{$item->name}}"
                                                    data-username = "{{$item->username}}"
                                                    data-password = "{{$item->password}}"
                                                    type="button"
                                                    class="edit btn btn-tool btn-outline-info">
                                                <i class="fa fa-pen"></i>
                                            </button>
                                            <button data-id="{{$item->id}}" type="button" class="delete btn btn-tool btn-outline-danger">
                                                <i class="fa fa-trash"></i>
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
                @include('.super.user_form');
            </div>
        </div>
    </div>

    <!-- Edit -->
    <div class="modal fade" id="edit" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                @include('.super.user_form');
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
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
@endpush

@push("js")
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
    @include("msg")
    <script>
        function docReady(fn) {
            if (document.readyState === "complete" || document.readyState === "interactive") {
                setTimeout(fn, 1);
            } else {
                document.addEventListener("DOMContentLoaded", fn);
            }
        }
        // DataTable
        docReady(function() {
            $('#dtable thead td').each(function () {
                let title = $(this).text();
                $(this).html('<input type="text" class="form-control" placeholder="Search ' + title + '" />');
            });
            $('#dtable').DataTable({
                "pageLength": 10,
                "bLengthChange": false,
                "dom":'<"top">ct<"top"p><"clear">',
                initComplete: function () {
                    // Apply the search
                    this.api().columns().every(function () {
                        let that = this;
                        $('input', this.header()).on('keyup change clear', function () {
                            if (that.search() !== this.value) {
                                that
                                    .search(this.value)
                                    .draw();
                            }
                        });
                    });
                }
            });
        });
        // Show on error
        @if (count($errors) > 0)
            docReady(function() {
                $('#add').modal('show');
            });
        @endif
        // toggleStatus
        docReady(function () {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 1500,
                timerProgressBar: true,
            })
            $('.toggle-class').change(function() {
                let status = $(this).prop('checked') === true ? 1 : 0;
                let user_id = $(this).data('id');
                $.ajax({
                    type: "GET",
                    dataType: "json",
                    url: '/super/user/toggle-status',
                    data: {'status': status, 'user_id': user_id},

                    success: function(data){
                        Toast.fire({
                            icon: user_id === 1 ? "error":"success",
                            title: data.success
                        })
                    }
                });
            })
        });
        // Delete record
        docReady(function () {
            $(document).on('click', '.delete', function (e){
                e.preventDefault();
                let id = $(this).data('id');
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed && id !== 1) {
                        $.ajax({
                            type: "GET",
                            url: "{{url('/super/user/destroy')}}",
                            data: {id:id},
                            success: function () {
                                Toast.fire({
                                    icon: 'success',
                                    title: "Data has been deleted"
                                })
                                setTimeout(function (){
                                    window.location.reload();
                                },500);
                            }
                        });
                    }
                    else {
                        Swal.fire(
                            'Failed',
                            'Data failed to delete',
                        )
                    }
                });
            });
        });
        // Edit Record
        docReady(function () {
            $("#dtable .edit").on("click",function(){
                let params = $(this)
                let id = params.data('id');
                let name = params.data('name');
                let username = params.data('username');
                let password = params.data('password');
                $("#edit").modal();
                $("#edit").find(".modal-body input[name=name]").val(name);
                $("#edit").find(".modal-body input[name=username]").val(username);
                $("#edit").find(".modal-body input[name=password]").val(password);
                $("#edit").find(".modal-body form").attr("action","{{route("super.user.update")}}/"+id);
                $("#edit").find(".modal-title").text("Edit Role");
            });
        })
    </script>
@endpush
