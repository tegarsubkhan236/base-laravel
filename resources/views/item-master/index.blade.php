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
                    <form
                        action="{{isset($edit_item) ? route('item.update',[$edit_item->id]) : route('item.store')}}"
                        method="POST">
                        @csrf
                        <div class="form-row">
                            <div class="col-md-12 form-group">
                                <label for="name">
                                    Name
                                </label>
                                <input id="name" name='name' value="{{@$edit_item['name']}}" class="form-control"
                                       type="text"/>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-12 form-group">
                                <label for="category">
                                    Category
                                </label>
                                <select name="category_id" id="category" class="form-control">
                                    <option value="" hidden>--Select Category--</option>
                                    @foreach($category as $item)
                                        <option
                                            value="{{$item->id}}" {{isset($edit_item)?($item->id == $edit_item->item_category->id ? 'selected':''):''}}>{{$item->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        @if(!isset($edit_item))
                            <div class="form-row">
                                <div class="col-md-12 form-group">
                                    <label for="qty">
                                        Initial Quantity
                                    </label>
                                    <input id="qty" name='qty' value="{{old('qty')}}" class="form-control"
                                           type="number"/>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-12 form-group">
                                    <label for="price">
                                        Initial Sell Price
                                    </label>
                                    <input id="price" name='price' value="{{old('sell_price')}}" class="form-control"
                                           type="number"/>
                                </div>
                            </div>
                        @endif
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
                                <a href="{{route('item.index')}}" class="btn btn-lg  btn-outline-success">
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
                                <th>Category</th>
                                <th class="align-middle" rowspan="2">Action</th>
                            </tr>
                            <tr>
                                <td>Name</td>
                                <td>Category</td>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($data as $i => $item)
                                <tr>
                                    <td class="align-middle" style="width: 50px">{{$i+1}}</td>
                                    <td class="align-middle">{{$item->name}}</td>
                                    <td class="align-middle"><span
                                            class="badge badge-info">{{$item->item_category->name}}</span></td>
                                    <td class="align-middle">
                                        <div class="btn-group" role="group">
                                            <a href="{{route('item.edit',[$item->id])}}">
                                                <button type="button" class="edit btn btn-tool btn-outline-info">
                                                    <i class="fa fa-pen"></i>
                                                </button>
                                            </a>
                                            <form id="delete-item-form" action="{{route('item.destroy',$item->id)}}"
                                                  method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button onclick="return false" id="delete-item"
                                                        class="btn btn-tool btn-outline-danger"><i
                                                        class="fa fa-trash"></i></button>
                                            </form>
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
        $('#delete-item').on('click', function (e) {
            e.preventDefault();
            let id = $(this).data('id');
            Swal.fire({
                title: 'Are you sure ?',
                text: "You won't be able to revert this !",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#delete-item-form').submit();
                }
            })
        });
    </script>
@endpush
