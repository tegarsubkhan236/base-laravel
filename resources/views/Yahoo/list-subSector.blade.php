@extends('adminlte::page')

@section('title', ((isset($title))?$title:""))

@section('content_header')

@stop

@section('content')
    <div class="row">
        <div class="col-md-12 mt-3">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="card-title">Sub-Sector of {{$sector}}</h4>
                        </div>
                        <div>
                            <a href="{{route('yahoo.list.sector')}}" class="btn btn-sm btn-danger">Back</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach($data as $item)
                            <div class="col-lg-3 col-6 mt-3">
                                <div class="small-box bg-danger">
                                    <div class="inner">
                                        <h5>{{$item->subSector != null ? $item->subSector : 'UnGrouping'}}</h5>
                                        <p>{{$item->total}} Stock</p>
                                    </div>
                                    <div class="icon">
                                        <i class="fas fa-chart-bar"></i>
                                    </div>
                                    <a href="{{route('yahoo.list.stock',['sector' => $sector,'subSector' => $item->subSector])}}" class="small-box-footer">
                                        More info <i class="fas fa-arrow-circle-right"></i>
                                    </a>
                                </div>
                            </div>
                        @endforeach
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

@section("js")
    @include("msg")
@stop
