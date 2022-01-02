@extends('adminlte::page')

@section('title', ((isset($title))?$title:""))

@section('content_header')

@stop

@section('content')
    <div class="row">
        <div class="col-md-12 mt-3">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title text-bold">Sector : {{$sector}}</h4><br>
                    <h5 class="card-title text-bold">Sub Sector : {{$subSector}}</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="myTable" class="table table-hover table-border">
                            <thead class="bg-danger">
                            <tr>
                                <th class="align-middle">No</th>
                                <th>Code</th>
                                <th>Name</th>
                                <th>Actual Price</th>
                                <th>Updated At</th>
                                <th class="text-center">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($data as $i => $item)
                                <tr>
                                    <td class="align-middle">{{$i+1}}</td>
                                    <td>{{$item->code}}</td>
                                    <td>{{$item->name}}</td>
                                    <td>Rp. {{number_format($item->actualPrice)}}</td>
                                    <td>{{date_format_diffForHumans($item->updated_at)}}</td>
                                    <td class="text-center">
                                        @if($subSector != null)
                                        <a href="{{route('yahoo.stock.detail',['sector'=>$sector, 'subSector'=>$subSector, 'id'=>$item->id])}}"
                                           class="btn btn-tool btn-outline-info">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @endif
{{--                                        <a href="" class="btn btn-tool btn-outline-danger">--}}
{{--                                            <i class="fas fa-trash"></i>--}}
{{--                                        </a>--}}
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="d-flex justify-content-between">
                        <div>
                        </div>
                        <div>
                            <a href="{{route('yahoo.list.subSector',['sector'=>$sector])}}" class="btn btn-sm btn-danger">Back</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('footer')
    @include('footer')
@stop

@section('css')

@stop

@section('plugins.Datatables', true)
@section("js")
    @include("msg")
    <script>
        function docReady(fn) {
            if (document.readyState === "complete" || document.readyState === "interactive") {
                setTimeout(fn, 1);
            } else {
                document.addEventListener("DOMContentLoaded", fn);
            }
        }
        docReady(function () {
            $('#myTable').DataTable();
        });
    </script>
@stop
