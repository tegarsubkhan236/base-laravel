@extends('adminlte::page')

@section('title', ($title?:""))

@section('content_header')@stop

@php
    use \Illuminate\Support\Facades\Auth;
    use \App\Models\RoleUser;
    $userRole = RoleUser::where('user_id',Auth::id())->first();
@endphp

@section('content')
    <div class="row">
        @if(isset($edit_item))
            <div class="col-3">
                <div class="card">
                    <div class="card-header">
                        <h4 class="text-center bg-olive mt-2">
                            Edit
                        </h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('stock.master.update',[$edit_item->id]) }}" method="POST">
                            @csrf
                            <div class="form-row">
                                <div class="col-md-12 form-group">
                                    <label for="name">
                                        Item Name
                                    </label>
                                    <input id="name" name='name' value="{{@$edit_item->master_item->name}}" class="form-control"
                                           type="text" disabled/>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-12 form-group">
                                    <label for="name">
                                        Category
                                    </label>
                                    <input id="name" name='name' value="{{@$edit_item->master_item->item_category->name}}" class="form-control"
                                           type="text" disabled/>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-12 form-group">
                                    <label for="qty">
                                        Quantity
                                    </label>
                                    <input id="qty" name='qty' value="{{@$edit_item->qty}}" class="form-control"
                                           type="number"/>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-12 form-group">
                                    <label for="price">
                                        Sell Price
                                    </label>
                                    <input id="price" name='price' value="{{@$edit_item->sell_price}}" class="form-control"
                                           type="number"/>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-12 form-group">
                                    <label for="min_stock">
                                        Minimum Stock
                                    </label>
                                    <input id="min_stock" name='min_stock' value="{{@$edit_item->min_stock}}" class="form-control"
                                           type="number"/>
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
        @endif

        <div class="{{isset($edit_item)?'col-9':'col-12'}}">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-10 offset-1">
                            <h4 class="text-center bg-olive mt-2">{{$title}}</h4>
                        </div>
                        @if(isset($edit_item))
                            <div class="col-1">
                                <a href="{{route('stock.master.index')}}" class="btn btn-lg  btn-outline-success">
                                    <i class="fa fa-backward"></i>
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
                                <th>Item</th>
                                <th>Category</th>
                                <th>Quantity</th>
                                <th>Min Stock</th>
                                <th>Sell Price</th>
                                @if($userRole->role_id == \App\Casts\UserLevel::OWNER || $userRole->role_id == \App\Casts\UserLevel::WAREHOUSE && Route::currentRouteName() != 'stock.opname.index')
                                    <th class="align-middle" rowspan="2">Action</th>
                                @endif
                            </tr>
                            <tr>
                                <td>Item</td>
                                <td>Category</td>
                                <td>Quantity</td>
                                <td>Min Stock</td>
                                <td>Sell Price</td>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($data as $i => $item)
                                <tr>
                                    <td class="align-middle" style="width: 50px">{{$i+1}}</td>
                                    <td class="align-middle">{{$item->master_item->name}}</td>
                                    <td class="align-middle"><span
                                            class="badge badge-info">{{$item->master_item->item_category->name}}</span>
                                    </td>
                                    <td class="align-middle">{{number_format($item->qty)}}</td>
                                    <td class="align-middle">{{number_format($item->min_stock)}}</td>
                                    <td class="align-middle">Rp. {{number_format($item->sell_price)}}</td>
                                    @if($userRole->role_id == \App\Casts\UserLevel::OWNER || $userRole->role_id == \App\Casts\UserLevel::WAREHOUSE && Route::currentRouteName() != 'stock.opname.index')
                                        <td class="align-middle">
                                            <div class="btn-group" role="group">
                                                <a href="{{route('stock.master.edit',[$item->id])}}">
                                                    <button type="button" class="edit btn btn-tool btn-outline-info">
                                                        <i class="fa fa-pen"></i>
                                                    </button>
                                                </a>
                                            </div>
                                        </td>
                                    @endif
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
    </script>
@endpush
