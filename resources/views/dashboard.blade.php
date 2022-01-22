@extends('adminlte::page')

@section('title', ((isset($title))?$title:""))

@section('content_header')
    <h5>NEWS</h5>
@stop

@section('content')
    <main>
        <!-- Trending Area Start -->
        <div class="trending-area fix">
            <div class="container">
                <div class="trending-main">
                    <div class="row">
                        <div class="col-lg-8">
                            <!-- Trending Top -->
                            @if(isset($headlines['articles'][0]))
                            <div class="trending-top mb-30">
                                <div class="trend-top-img">
                                    <img src="{{$headlines['articles'][0]['urlToImage']}}" alt="trend top">
                                    <div class="trend-top-cap">
                                        <span>{{$headlines['articles'][0]['source']['name']}}</span>
                                        <h2>
                                            <a href="{{$headlines['articles'][0]['url']}}">
                                                {{$headlines['articles'][0]['title']}}
                                            </a>
                                        </h2>
                                    </div>
                                </div>
                            </div>
                            @endif
                            <!-- Trending Bottom -->
                            <div class="trending-bottom">
                                <div class="row">
                                    @if(isset($headlines['articles'][1]))
                                    <div class="col-lg-4">
                                        <div class="single-bottom mb-35">
                                            <div class="trend-bottom-img mb-30">
                                                <img src="{{$headlines['articles'][1]['urlToImage']}}" alt="">
                                            </div>
                                            <div class="trend-bottom-cap">
                                                <span class="color1">{{$headlines['articles'][1]['source']['name']}}</span>
                                                <h4><a href="{{$headlines['articles'][1]['url']}}">{{$headlines['articles'][1]['title']}}</a></h4>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                    @if($headlines['articles'][2])
                                    <div class="col-lg-4">
                                        <div class="single-bottom mb-35">
                                            <div class="trend-bottom-img mb-30">
                                                <img src="{{$headlines['articles'][2]['urlToImage']}}" alt="">
                                            </div>
                                            <div class="trend-bottom-cap">
                                                <span class="color2">{{$headlines['articles'][2]['source']['name']}}</span>
                                                <h4><h4><a href="{{$headlines['articles'][2]['url']}}">{{$headlines['articles'][2]['title']}}</a></h4></h4>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                    @if($headlines['articles'][3])
                                    <div class="col-lg-4">
                                        <div class="single-bottom mb-35">
                                            <div class="trend-bottom-img mb-30">
                                                <img src="{{$headlines['articles'][3]['urlToImage']}}" alt="">
                                            </div>
                                            <div class="trend-bottom-cap">
                                                <span class="color3">{{$headlines['articles'][3]['source']['name']}}</span>
                                                <h4><a href="{{$headlines['articles'][3]['url']}}">{{$headlines['articles'][3]['title']}}</a></h4>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <!-- Riht content -->
                        <div class="col-lg-4">
                            @if($headlines['articles'][4])
                            <div class="trand-right-single d-flex">
                                <div class="trand-right-img">
                                    <img src="{{$headlines['articles'][4]['urlToImage']}}" width="120px" height="100px" alt="trend">
                                </div>
                                <div class="trand-right-cap">
                                    <span class="color1">{{$headlines['articles'][4]['source']['name']}}</span>
                                    <h4><a href="{{$headlines['articles'][4]['url']}}">{{$headlines['articles'][4]['title']}}</a></h4>
                                </div>
                            </div>
                            @endif
                            @if($headlines['articles'][5])
                                <div class="trand-right-single d-flex">
                                <div class="trand-right-img">
                                    <img src="{{$headlines['articles'][5]['urlToImage']}}" width="120px" height="100px" alt="trend">
                                </div>
                                <div class="trand-right-cap">
                                    <span class="color1">{{$headlines['articles'][5]['source']['name']}}</span>
                                    <h4><a href="{{$headlines['articles'][5]['url']}}">{{$headlines['articles'][5]['title']}}</a></h4>
                                </div>
                            </div>
                            @endif
                            @if($headlines['articles'][6])
                                <div class="trand-right-single d-flex">
                                <div class="trand-right-img">
                                    <img src="{{$headlines['articles'][6]['urlToImage']}}" width="120px" height="100px" alt="trend">
                                </div>
                                <div class="trand-right-cap">
                                    <span class="color2">{{$headlines['articles'][6]['source']['name']}}</span>
                                    <h4><a href="{{$headlines['articles'][6]['url']}}">{{$headlines['articles'][6]['title']}}</a></h4>
                                </div>
                            </div>
                            @endif
                            @if($headlines['articles'][7])
                                <div class="trand-right-single d-flex">
                                <div class="trand-right-img">
                                    <img src="{{$headlines['articles'][7]['urlToImage']}}" width="120px" height="100px" alt="trend">
                                </div>
                                <div class="trand-right-cap">
                                    <span class="color4">{{$headlines['articles'][7]['source']['name']}}</span>
                                    <h4><a href="{{$headlines['articles'][7]['url']}}">{{$headlines['articles'][7]['title']}}</a></h4>
                                </div>
                            </div>
                            @endif
                            @if($headlines['articles'][8])
                                <div class="trand-right-single d-flex">
                                <div class="trand-right-img">
                                    <img src="{{$headlines['articles'][8]['urlToImage']}}" width="120px" height="100px" alt="trend">
                                </div>
                                <div class="trand-right-cap">
                                    <span class="color1">{{$headlines['articles'][8]['source']['name']}}</span>
                                    <h4><a href="{{$headlines['articles'][8]['url']}}">{{$headlines['articles'][8]['title']}}</a></h4>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Trending Area End -->
        <!--Start pagination -->
        <div class="pagination-area pb-45 text-center">
            <div class="container">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="single-wrap d-flex justify-content-center">
                            <nav aria-label="Page navigation example">
                                <ul class="pagination justify-content-start">
                                    <li class="page-item"><a class="page-link" href="#"><span class="flaticon-arrow roted"></span></a></li>
                                    <li class="page-item active"><a class="page-link" href="#">01</a></li>
                                    <li class="page-item"><a class="page-link" href="#">02</a></li>
                                    <li class="page-item"><a class="page-link" href="#">03</a></li>
                                    <li class="page-item"><a class="page-link" href="#"><span class="flaticon-arrow right-arrow"></span></a></li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End pagination  -->
    </main>
{{--    <div class="row">--}}
{{--        @foreach($headlines['articles'] as $x)--}}
{{--            <div class="col-sm-4 col-md-4 col-lg-4">--}}
{{--                <div class="card">--}}
{{--                    <img class="card-img-top img-thumbnail" src="{{$x['urlToImage']}}" alt="Card image cap">--}}
{{--                    <div class="card-body">--}}
{{--                        <h5 class="card-title">{{$x['title']}}</h5>--}}
{{--                        <p class="card-text">{{$x['description']}}</p>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                {{$x['source']['name']}}--}}
{{--                {{ \Carbon\Carbon::parse($x['publishedAt'])->format('d/m/Y')}}--}}
{{--                {{$x['url']}}--}}
{{--            </div>--}}
{{--        @endforeach--}}
{{--    </div>--}}
@stop

@section('footer')
    @include('footer')
@stop

@push('css')
    <link rel="stylesheet" href="assets/css/style.css">
@endpush

@push("js")
    @include('msg')
@endpush
