@extends('adminlte::page')

@section('title', ($title?:""))

@section('content_header')@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="text-center bg-olive mt-2">
                        {{$title?:""}}
                    </h4>
                </div>
                <div class="card-body">
                    <form action="{{route('buy.search_supplier')}}" method="GET">
                        @csrf
                        <div class="form-row">
                            <div class="col-12">
                                <label for="supplier">Supplier</label>
                                <select name="supplier" id="supplier" class="form-control select2">
                                    <option value="" hidden>--Select Supplier--</option>
                                    @foreach($supplier as $item)
                                        <option value="{{$item->id}}">{{$item->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-2 offset-10 pl-5 mr-1 pt-3 form-group">
                                <button type="submit" class="btn btn-info">
                                    <i class="fa fa-search"></i> Search
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            @if(isset($search_result))
                <form action="{{route('buy.store')}}" method="POST">
                    @csrf
                    <div class="card">
                        <div class="card-header">
                            <h4 class="text-center bg-olive mt-2">
                                {{$search_result->name}}'s Stock
                            </h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-8">
                                    <button class="btn btn-outline-primary" id="addMore_Item" type="button">
                                        <span class="fa fa-plus"></span> Add Item
                                    </button>
                                    <button class="btn btn-outline-primary" id="getTotal" type="button">
                                        <span class="fa fa-dollar-sign"></span> Get Total
                                    </button>
                                    <table class="table table-responsive table-bordered table-hover"
                                           style="display: none;">
                                        <thead>
                                        <tr>
                                            <th>Item Name</th>
                                            <th>Buy Price</th>
                                            <th>Stock Left</th>
                                            <th>Quantity</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody id="add_item" class="add_item"></tbody>
                                        <tbody>
                                        <tr>
                                            <td colspan="5">
                                                <label for="total">Total</label>
                                                <input type="number" id="total" class="form-control" value="0" readonly>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-4">
                                    <label for="note" class="col-form-label">Note</label>
                                    <textarea name="note" id="note" cols="30" rows="6" class="form-control"></textarea>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-md-2 offset-10 pl-5 mr-1 pt-3 form-group">
                                    <button type="submit" class="btn btn-warning">Checkout</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            @endif
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
        $(document).ready(function () {
            $('.select2').select2();
        });
    </script>
    @if(isset($search_result))
        <script src="https://cdnjs.cloudflare.com/ajax/libs/handlebars.js/4.7.6/handlebars.min.js"></script>
        <script type="text/javascript">
            $(document).on('click', '#addMore_Item', function () {
                $('.table').show();
                let item_id = $("#item_id").val();
                let qty = $("#qty").val();
                let price = $("#price").val();
                let stock = $("#stock").val();
                let source = $("#document-template").html();
                let template = Handlebars.compile(source);
                let data = {
                    item_id: item_id,
                    qty: qty,
                    price: price,
                    stock: stock,
                }
                let html = template(data);
                $("#add_item").append(html)
            });
        </script>
        <script id="document-template" type="text/x-handlebars-template">
            <tr class="delete_item" id="delete_item">
                <td style="display: none">
                    <input type="text" value="{{$search_result->id}}" name="supplier_id" id="supplier_id" hidden>
                </td>
                <td>
                    <select class="form-control" value="@{{ item_id }}" name="item_id[]" id="item_id">
                        <option data-display="Item *" value=" ">Item Name *</option>
                        @foreach($masterItem as $item)
                            <option value="{{$item->master_item->id}}">{{$item->master_item->name}}</option>
                        @endforeach
                    </select>
                </td>
                <td>
                    <input name="price[]" value="0" type="number" class="form-control price" placeholder="Price *"
                           id="price" disabled>
                </td>
                <td>
                    <input name="stock[]" value="0" type="number" class="form-control stock" placeholder="Stock Left *"
                           id="stock" disabled>
                </td>
                <td>
                    <input name="qty[]" value="@{{ qty }}" type="number" class="form-control qty"
                           placeholder="Quantity *">
                </td>
                <td class="text-center">
                    <div class="btn btn-group">
                        <button type="button" class="remove_item btn btn-danger btn-sm">
                            <span class="fa fa-trash"></span>
                        </button>
                    </div>
                </td>
            </tr>
        </script>
        <script>
            $(document).on('click', '.remove_item', function () {
                $(this).closest('.delete_item').remove();
            });
            $(document).on('change', '#item_id', function () {
                let id = $(this).closest('.delete_item').find(':selected').val();
                let supplier_id = $(this).closest('.delete_item').find('#supplier_id').val();
                let url = '{{ url('buy/detail_item/:id/:supplier_id') }}';
                let element = this;
                url = url.replace(':id', id);
                url = url.replace(':supplier_id', supplier_id);
                $.ajax({
                    type: 'get',
                    url: url,
                    dataType: 'json',
                    success: function (response) {
                        console.log(response)
                        $(element).closest('.delete_item').find('#price').val(response.sell_price);
                        $(element).closest('.delete_item').find('#stock').val(response.qty);
                    }
                });
            });
            $(document).on('click', '#getTotal', function () {
                var sumPrice = [];
                var sumQty = [];
                var total = 0;
                $('.price').each(function (i, obj) {
                    // test = Number($(this).val());
                    sumPrice[i] = Number($(this).val());
                });
                $('.qty').each(function (i, obj) {
                    sumQty[i] = Number($(this).val());
                });
                $(sumPrice).each(function (i, obj) {
                    total = sumPrice[i] * sumQty[i] + total;
                });
                // console.log(total)
                $('#total').val(total);
            })
            $(document).on('keyup', '#down_payment', function () {
                let total = $(this).val() - $('#total').val();
                $('#change_money').val(total)
            })
        </script>
    @endif
@endpush
