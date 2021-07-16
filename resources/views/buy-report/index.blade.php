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
        @if($userRole == \App\Casts\UserLevel::WAREHOUSE || $userRole == \App\Casts\UserLevel::OWNER)
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
                        <form action="{{route('buy.report.filter')}}" method="POST">
                            @csrf
                            <div class="form-row">
                                <div class="col-md-12 form-group">
                                    <label for="supplier">
                                        Supplier Name
                                    </label>
                                    <select name="supplier" id="supplier" class="form-control select2">
                                        <option value="" hidden>--Select Supplier--</option>
                                        @foreach($supplier as $item)
                                            <option
                                                value="{{$item->id}}" {{isset($req_item)?($item->id == $edit_item->id ? 'selected':''):''}}>{{$item->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-6 form-group">
                                    <label for="start-date">
                                        Start Date
                                    </label>
                                    <input id="start-date" name='start-date' class="form-control" type="date"/>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="end-date">
                                        End Date
                                    </label>
                                    <input id="end-date" name='end-date' class="form-control" type="date"/>
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

        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8 offset-2">
                            <h4 class="text-center bg-olive mt-2">{{$title}}</h4>
                        </div>
                        @if(isset($req_item))
                            <div class="col-1 offset-1">
                                <a href="{{route('sell.report.index')}}" class="btn btn-lg  btn-outline-success">
                                    <i class="fa fa-arrow-alt-circle-left"></i>
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
                                <th class="align-middle" rowspan="2">ID</th>
                                <th>Supplier</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Note</th>
                                <th class="align-middle" rowspan="2">Created At</th>
                                <th class="align-middle" rowspan="2">Action</th>
                            </tr>
                            <tr>
                                <td>Supplier</td>
                                <td>Total</td>
                                <td>Status</td>
                                <td>Note</td>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($data as $i => $item)
                                <tr>
                                    <td class="align-middle">
                                        BY{{$item->created_at->format('d')}}{{$item->created_at->format('m')}}{{$item->created_at->format('Y')}}{{$item->id}}
                                    </td>
                                    <td class="align-middle">{{$item->supplier->name}}</td>
                                    <td class="align-middle">Rp. {{number_format($item->total)}}</td>
                                    <td class="align-middle"><span
                                            class="badge badge-info">{{\App\Casts\BuyStatus::lang($item->status)}}</span>
                                    </td>
                                    <td class="align-middle">{{$item->note}}</td>
                                    <td class="align-middle">{{$item->created_at->format('d/m/Y')}}</td>
                                    <td class="align-middle">
                                        <div class="btn-group" role="group">
                                            <button class="btn btn-tool btn-outline-info" data-toggle="modal"
                                                    data-target="#detail{{$item->id}}">
                                                <i class="fa fa-eye"></i>
                                            </button>
                                            @if($item->status == \App\Casts\BuyStatus::Pending && $userRole == \App\Casts\UserLevel::OWNER)
                                                <a class="btn btn-tool btn-outline-info" data-toggle="modal"
                                                   data-target="#status{{$item->id}}">
                                                    <i class="fa fa-pen"></i>
                                                </a>
                                            @endif
                                            @if($item->status == \App\Casts\BuyStatus::AccOwner && $userRole == \App\Casts\UserLevel::SUPPLIER)
                                                <a class="btn btn-tool btn-outline-info" data-toggle="modal"
                                                   data-target="#status{{$item->id}}">
                                                    <i class="fa fa-pen"></i>
                                                </a>
                                            @endif
                                            @if($item->status == \App\Casts\BuyStatus::AccSupplier && $userRole == \App\Casts\UserLevel::SUPPLIER)
                                                <a class="btn btn-tool btn-outline-info" data-toggle="modal"
                                                   data-target="#status{{$item->id}}">
                                                    <i class="fa fa-pen"></i>
                                                </a>
                                            @endif
                                            @if($item->status == \App\Casts\BuyStatus::OnGoing && $userRole == \App\Casts\UserLevel::WAREHOUSE)
                                                <a class="btn btn-tool btn-outline-info" data-toggle="modal"
                                                   data-target="#status{{$item->id}}">
                                                    <i class="fa fa-pen"></i>
                                                </a>
                                            @endif
                                            @if($item->status == \App\Casts\BuyStatus::Pending && $userRole == \App\Casts\UserLevel::WAREHOUSE)
                                                <form action="{{route('buy.report.destroy',$item->id)}}" method="POST"
                                                      style="display: none">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button data-id="{{ $item->id }}"
                                                            class="btn btn-tool btn-outline-danger delete-item">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                <div class="modal fade" id="detail{{$item->id}}" tabindex="-1" role="dialog"
                                     aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Detail {{$title}}</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                @foreach($item->buy_transaction_details as $v)
                                                    <h4>Item Name : {{$v->supplier_stock->master_item->name}}</h4>
                                                    <h5>Qty : {{$v->qty}}</h5><br>
                                                @endforeach
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="modal fade" id="status{{$item->id}}" tabindex="-1" role="dialog"
                                     aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Detail {{$title}}</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{route('buy.report.update_status',['id'=>$item->id])}}"
                                                      method="POST">
                                                    @csrf
                                                    <div class="form-row">
                                                        <div class="col-md-12 form-group">
                                                            <label for="status">STATUS</label> <br>
                                                            <select name="status" id="status"
                                                                    class="form-control select2" style="width: 100%">
                                                                @if($item->status == \App\Casts\BuyStatus::Pending && $userRole == \App\Casts\UserLevel::OWNER)
                                                                    <option
                                                                        value="{{\App\Casts\BuyStatus::Pending}}"
                                                                        selected>
                                                                        {{\App\Casts\BuyStatus::lang(\App\Casts\BuyStatus::Pending)}}
                                                                    </option>
                                                                    <option
                                                                        value="{{\App\Casts\BuyStatus::AccOwner}}">
                                                                        {{\App\Casts\BuyStatus::lang(\App\Casts\BuyStatus::AccOwner)}}
                                                                    </option>
                                                                @endif
                                                                @if($item->status == \App\Casts\BuyStatus::AccOwner && $userRole == \App\Casts\UserLevel::SUPPLIER)
                                                                    <option
                                                                        value="{{\App\Casts\BuyStatus::AccOwner}}"
                                                                        selected>
                                                                        {{\App\Casts\BuyStatus::lang(\App\Casts\BuyStatus::AccOwner)}}
                                                                    </option>
                                                                    <option
                                                                        value="{{\App\Casts\BuyStatus::AccSupplier}}">
                                                                        {{\App\Casts\BuyStatus::lang(\App\Casts\BuyStatus::AccSupplier)}}
                                                                    </option>
                                                                @endif
                                                                @if($item->status == \App\Casts\BuyStatus::AccSupplier && $userRole == \App\Casts\UserLevel::SUPPLIER)
                                                                    <option
                                                                        value="{{\App\Casts\BuyStatus::AccSupplier}}"
                                                                        selected>
                                                                        {{\App\Casts\BuyStatus::lang(\App\Casts\BuyStatus::AccSupplier)}}
                                                                    </option>
                                                                    <option
                                                                        value="{{\App\Casts\BuyStatus::OnGoing}}">
                                                                        {{\App\Casts\BuyStatus::lang(\App\Casts\BuyStatus::OnGoing)}}
                                                                    </option>
                                                                @endif
                                                                @if($item->status == \App\Casts\BuyStatus::OnGoing && $userRole == \App\Casts\UserLevel::WAREHOUSE)
                                                                    <option
                                                                        value="{{\App\Casts\BuyStatus::OnGoing}}"
                                                                        selected>
                                                                        {{\App\Casts\BuyStatus::lang(\App\Casts\BuyStatus::OnGoing)}}
                                                                    </option>
                                                                    <option
                                                                        value="{{\App\Casts\BuyStatus::Complete}}">
                                                                        {{\App\Casts\BuyStatus::lang(\App\Casts\BuyStatus::Complete)}}
                                                                    </option>
                                                                @endif
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-row">
                                                        <div class="col-md-3 offset-9 pt-3 form-group">
                                                            <button type="submit" class="btn btn-primary">
                                                                <i class="fa fa-pen"></i> Update
                                                            </button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            @empty
                                <tr>
                                    <td colspan="5">No Data Available</td>
                                </tr>
                            @endforelse
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

        // Delete record
        $(document).on('click', '.delete-item', function (e) {
            e.preventDefault();
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
                    $(e.target).closest('form').submit();
                }
            })
        });
    </script>
@endpush
