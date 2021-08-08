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
                    <form action="{{route('sell.report.filter')}}" method="POST">
                        @csrf
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
                                @if($userRole == \App\Casts\UserLevel::OWNER)
                                <th>Created BY</th>
                                @endif
                                <th>Total</th>
                                <th>Note</th>
                                <th class="align-middle" rowspan="2">Created At</th>
                                <th class="align-middle" rowspan="2">Action</th>
                            </tr>
                            <tr>
                                @if($userRole == \App\Casts\UserLevel::OWNER)
                                <td>Created By</td>
                                @endif
                                <td>Total</td>
                                <td>Note</td>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($data as $i => $item)
                                <tr>
                                    <td class="align-middle">
                                        SL{{$item->created_at->format('d')}}{{$item->created_at->format('m')}}{{$item->created_at->format('Y')}}{{$item->id}}
                                    </td>
                                    @if($userRole == \App\Casts\UserLevel::OWNER)
                                    <td class="align-middle">{{$item->user->name}}</td>
                                    @endif
                                    <td class="align-middle">Rp. {{number_format($item->total)}}</td>
                                    <td class="align-middle">{{$item->note}}</td>
                                    <td class="align-middle">{{$item->created_at->format('d/m/Y')}}</td>
                                    <td class="align-middle">
                                        <div class="btn-group" role="group">
                                            <a class="btn btn-tool btn-outline-info" data-toggle="modal"
                                               data-target="#detail{{$item->id}}">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                            <a href="{{route('sell.report.print_struck',['id'=> $item->id])}}" class="btn btn-tool btn-outline-info">
                                                <i class="fa fa-file"></i>
                                            </a>
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
                                                @foreach($item->sell_transaction_details as $v)
                                                    <h4>Item Name : {{$v->master_stock->master_item->name}}</h4>
                                                    <h5>Qty : {{$v->qty}}</h5><br>
                                                @endforeach
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
