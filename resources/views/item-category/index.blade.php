@extends('adminlte::page')

@section('title', ($title?:""))

@section('content_header')@stop

@section('content')
    <div class="row">
        <div class="col-3">
            <div class="card">
                <div class="card-header">
                    <h4 class="text-center bg-olive mt-2">
                        @if(isset($edit_item))
                            Edit
                        @else
                            Add
                        @endif
                    </h4>
                </div>
                <div class="card-body">
                    @if(isset($edit_item))
                        <form action="{{route('item.category.update',[$edit_item->id])}}" method="POST">
                    @else
                        <form action="{{route('item.category.store')}}" method="POST">
                    @endif
                        @csrf
                        <div class="form-row">
                            <div class="col-md-12 form-group">
                                <label for="name">
                                    Name
                                </label>
                                <input id="name" name='name' value="{{@$edit_item['name']}}" class="form-control" type="text"/>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-2 offset-8 pt-3 form-group">
                                @if(isset($edit_item))
                                    <button type="submit" class="btn btn-warning">Update</button>
                                @else
                                    <button type="submit" class="btn btn-primary">Save</button>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-9">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-10 offset-1">
                            <h4 class="text-center bg-olive mt-2">{{$title}}</h4>
                        </div>
                        @if(isset($edit_item))
                            <div class="col-1">
                                <a href="{{route('item.category.index')}}" class="btn btn-lg  btn-outline-success">
                                    <i class="fa fa-plus-circle"></i>
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="dtable" class="table table-hover table-border text-center" style="width: 100%">
                            <thead>
                            <tr>
                                <th class="align-middle" style="width: 50px;" rowspan="2">No</th>
                                <th>Name</th>
                                <th class="align-middle" rowspan="2">Action</th>
                            </tr>
                            <tr>
                                <td>Name</td>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($data as $i => $item)
                                <tr>
                                    <td class="align-middle" style="width: 50px">{{$i+1}}</td>
                                    <td class="align-middle">{{$item->name}}</td>
                                    <td class="align-middle">
                                        <div class="btn-group" role="group">
                                            <a href="{{route('item.category.edit',[$item->id])}}">
                                                <button type="button" class="edit btn btn-tool btn-outline-info">
                                                    <i class="fa fa-pen"></i>
                                                </button>
                                            </a>
                                            <a href="#" class="delete" data-id="{{$item->id}}">
                                                <button type="button" class="btn btn-tool btn-outline-danger">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </a>
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
@stop

@section('footer')
    <div class="text-right">
        <strong>Copyright &copy; 2021 <a href="/">Lumbung Indonesia Sukses</a>.</strong> All rights reserved.
    </div>
@stop

@push('css')
@endpush

@push("js")
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
        docReady(function () {
            $('#dtable thead td').each(function () {
                let title = $(this).text();
                $(this).html('<input type="text" class="form-control" placeholder="Search ' + title + '" />');
            });
            $('#dtable').DataTable({
                "pageLength": 10,
                "bLengthChange": false,
                "dom": '<"top">ct<"top"p><"clear">',
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
        // Delete record
        docReady(function () {
            $(document).on('click', '.delete', function (e) {
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
                            url: "{{url('/item/category/destroy')}}",
                            data: {id: id},
                            success: function () {
                                Toast.fire({
                                    icon: 'success',
                                    title: "Data has been deleted"
                                })
                                setTimeout(function () {
                                    window.location.reload();
                                }, 500);
                            }
                        });
                    } else {
                        Swal.fire(
                            'Failed',
                            'Data failed to delete',
                        )
                    }
                });
            });
        });
    </script>
@endpush