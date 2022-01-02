@extends('adminlte::page')

@section('title', ((isset($title))?$title:""))

@section('content_header')

@stop

@section('content')
<div class="row">
    <div class="col-md-12 mt-3">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">List Of Sector</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    @foreach($data as $item)
                        <div class="col-lg-3 col-6 mt-3">
                            <div class="small-box bg-danger">
                                <div class="inner">
                                    <h5>{{$item->sector}}</h5>
                                    <p>{{$item->total}} Sub-Sector</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-chart-bar"></i>
                                </div>
                                <a href="{{route('yahoo.list.subSector',['sector' => $item->sector])}}" class="small-box-footer">
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