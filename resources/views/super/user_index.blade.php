@extends('adminlte::page')

@section('title', ((isset($title))?$title:""))

@section('content_header')@stop

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
                                <th class="align-middle" style="width: 50px;" rowspan="2">No</th>
                                <th>Username</th>
                                <th class="align-middle" rowspan="2">Status</th>
                                <th class="align-middle" rowspan="2">Action</th>
                            </tr>
                            <tr>
                                <td>Username</td>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($data as $i => $item)
                                <tr>
                                    <td style="width: 50px">{{$i+1}}</td>
                                    <td>{{$item->username}}</td>
                                    <td>
                                        <label>
                                            <input
                                                data-id="{{$item->id}}"
                                                class="toggle-class"
                                                type="checkbox"
                                                data-onstyle="success"
                                                data-offstyle="danger"
                                                data-toggle="toggle"
                                                data-on="Active"
                                                data-off="InActive"
                                                {{ $item->status ? 'checked' : '' }} />
                                        </label>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-tool">
                                            <i class="fa fa-pen"></i>
                                        </button>
                                        <button type="button" class="btn btn-tool">
                                            <i class="fa fa-trash"></i>
                                        </button>
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
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
@endpush

@push("js")
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
    @include("msg")
    <script>
        $(document).ready(function () {
            // toggleStatus
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
                            icon: user_id == 1 ? "error":"success",
                            title: data.success
                        })
                    }
                });
            })
            // Setup - add a text input to each thead td cell
            $('#example thead td').each(function () {
                let title = $(this).text();
                $(this).html('<input type="text" style="width: 150px; border:none" placeholder="Search ' + title + '" />');
            });

            // DataTable
            const table = $('#example').DataTable({
                "pageLength": 10,
                "bLengthChange": false,
                // "dom":'<"top">ct<"top"p><"clear">',
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
    </script>
@endpush
