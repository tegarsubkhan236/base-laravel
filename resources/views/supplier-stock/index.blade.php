@extends('adminlte::page')

@section('title', ($title?:""))

@section('content_header')@stop

@php
    use \Illuminate\Support\Facades\Auth;
    use \App\Models\RoleUser;
    $userRole = RoleUser::where('user_id',Auth::id())->first()->role_id;
@endphp

@section('content')
    <div class="row">
        @if($userRole == \App\Casts\UserLevel::OWNER || $userRole == \App\Casts\UserLevel::WAREHOUSE)
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-10 offset-1">
                                <h4 class="text-center bg-olive mt-2">
                                    Filter Data
                                </h4>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{route('stock.supplier.filter')}}" method="POST">
                            @csrf
                            <div class="form-row">
                                <div class="col-md-6 form-group">
                                    <label for="supplier">
                                        Supplier Name
                                    </label>
                                    <select name="supplier" id="supplier" class="form-control">
                                        <option value="" hidden>--Select Supplier--</option>
                                        @foreach($supplier as $item)
                                            <option
                                                value="{{$item->id}}" {{isset($edit_item)?($item->id == $edit_item->id ? 'selected':''):''}}>{{$item->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="item">
                                        Item Name
                                    </label>
                                    <select name="item" id="item" class="form-control">
                                        <option value=" " hidden>--Select Item--</option>
                                        @foreach($items as $item)
                                            <option
                                                value="{{$item->id}}" {{isset($edit_item)?($item->id == $edit_item->id ? 'selected':''):''}}>{{$item->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-2 offset-10 pl-5 mr-1 pt-3 form-group">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i>Search
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endif
    </div>
    <div class="row">
        @if(isset($data))
            @if($userRole == \App\Casts\UserLevel::SUPPLIER)
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
                                action="{{isset($edit_item) ? route('stock.supplier.update',[$edit_item->id]) : route('stock.supplier.store')}}"
                                method="POST">
                                @csrf
                                @if(isset($edit_item))
                                    <div class="form-row">
                                        <div class="col-md-12 form-group">
                                            <label for="name">
                                                Item Name
                                            </label>
                                            <input id="name" name='name' value="{{@$edit_item->master_item->name}}"
                                                   class="form-control"
                                                   type="text" disabled/>
                                        </div>
                                    </div>
                                @else
                                    <div class="form-row">
                                        <label for="item">
                                            Item Name
                                        </label>
                                        <select name="item" id="item" class="form-control select2">
                                            <option value=" " hidden>--Select Item--</option>
                                            @foreach($items as $item)
                                                <option
                                                    value="{{$item->id}}" {{isset($edit_item)?($item->id == $edit_item->item_id ? 'selected':''):''}}>{{$item->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endif
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
                                        <input id="price" name='price' value="{{@$edit_item->sell_price}}"
                                               class="form-control"
                                               type="number"/>
                                    </div>
                                </div>
{{--                                <div class="form-row">--}}
{{--                                    <div class="col-md-12 form-group">--}}
{{--                                        <label for="min_stock">--}}
{{--                                            Minimum Stock--}}
{{--                                        </label>--}}
{{--                                        <input id="min_stock" name='min_stock' value="{{@$edit_item->min_stock}}"--}}
{{--                                               class="form-control"--}}
{{--                                               type="number"/>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
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
            <div class="{{$userRole != \App\Casts\UserLevel::SUPPLIER ? 'col-12':'col-9'}}">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-10 offset-1">
                                <h4 class="text-center bg-olive mt-2">{{$title}}</h4>
                            </div>
                            @if(isset($edit_item))
                                <div class="col-1">
                                    <a href="{{route('stock.supplier.index')}}" class="btn btn-lg  btn-outline-success">
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
{{--                                    <th>Min Stock</th>--}}
                                    <th>{{$userRole == \App\Casts\UserLevel::SUPPLIER ? 'Sell Price':'Buy Price'}}</th>
                                    @if($userRole == \App\Casts\UserLevel::SUPPLIER)
                                        <th class="align-middle" rowspan="2">Action</th>
                                    @endif
                                </tr>
                                <tr>
                                    <td>Item</td>
                                    <td>Category</td>
                                    <td>Quantity</td>
{{--                                    <td>Min Stock</td>--}}
                                    <td>{{$userRole == \App\Casts\UserLevel::SUPPLIER ? 'Sell Price':'Buy Price'}}</td>
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
{{--                                        <td class="align-middle">{{$item->min_stock}}</td>--}}
                                        <td class="align-middle">Rp. {{number_format($item->sell_price)}}</td>
                                        @if($userRole == \App\Casts\UserLevel::SUPPLIER)
                                            <td class="align-middle">
                                                <div class="btn-group" role="group">
                                                    <a href="{{route('stock.supplier.edit',[$item->id])}}">
                                                        <button type="button"
                                                                class="edit btn btn-tool btn-outline-info">
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
        @endif
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
        $(document).ready(function () {
            $('.select2').select2();
        });
    </script>
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
