@extends('adminlte::page')

@section('title', ((isset($title))?$title:""))

@section('content_header')

@stop

@section('content')
{{--    <div class="row">--}}
{{--        <div class="col-md-12 mt-3">--}}
{{--            <div class="card">--}}
{{--                <div class="card-header">--}}
{{--                    <h4 class="card-title">Search Stock</h4>--}}
{{--                </div>--}}
{{--                <div class="card-body">--}}
{{--                    <form action="{{route('yahoo.search')}}" method="POST" >--}}
{{--                        @csrf--}}
{{--                        <div class="form-row">--}}
{{--                            <div class="col-md-11 form-group">--}}
{{--                                <label for="symbol" class="col-form-label">Symbol of Equity</label>--}}
{{--                                <input type="text" name="symbol" id="symbol" class="form-control">--}}
{{--                            </div>--}}
{{--                            <div class="col-md-1 pt-4 mt-2 form-group">--}}
{{--                                <button type="submit" class="btn btn-danger">Search</button>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </form>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
    @if(isset($profile))
        <form action="{{route('yahoo.save')}}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-8 mt-3">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h4 class="card-title">FUNDAMENTALS</h4>
                                        </div>
                                        <div>
                                            <button type="submit" class="btn btn-sm btn-danger">Save Stock</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="form-row">
                                        <div class="col-md-4 form-group">
                                            <label for="netIncome" class="col-form-label">Net Income [TTM]</label>
                                            <input type="text" class="form-control" readonly
                                                   value={{$statistic['defaultKeyStatistics']['netIncomeToCommon']['fmt']}}>
                                            <input hidden name="netIncome" id="netIncome" type="text"
                                                   value={{$statistic['defaultKeyStatistics']['netIncomeToCommon']['raw']}}>
                                        </div>
                                        <div class="col-md-4 form-group">
                                            <label for="profitMargin" class="col-form-label">PROFIT MARGIN</label>
                                            <input type="text" class="form-control" readonly
                                                   value={{$statistic['financialData']['profitMargins']['fmt']}}>
                                            <input hidden name="profitMargin" id="profitMargin" type="text"
                                                   value={{$statistic['financialData']['profitMargins']['raw']}}>
                                        </div>
                                        <div class="col-md-4 form-group">
                                            <label for="operationMargin" class="col-form-label">OPERATION MARGIN</label>
                                            <input type="text" class="form-control" readonly
                                                   value={{$statistic['financialData']['operatingMargins']['fmt']}}>
                                            <input hidden name="operationMargin" id="operationMargin" type="text"
                                                   value={{$statistic['financialData']['operatingMargins']['raw']}}>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-md-6 form-group">
                                            <label for="returnOnAsset" class="col-form-label">RETURN ON ASSET</label>
                                            <input type="text" class="form-control" readonly
                                                   value={{$statistic['financialData']['returnOnAssets']['fmt']}}>
                                            <input hidden name="returnOnAsset" id="returnOnAsset" type="text"
                                                   value={{$statistic['financialData']['returnOnAssets']['raw']}}>
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label for="returnOnEquity" class="col-form-label">RETURN ON EQUITY</label>
                                            <input type="text" class="form-control" readonly
                                                   value={{$statistic['financialData']['returnOnEquity']['fmt']}}>
                                            <input hidden name="returnOnEquity" id="returnOnEquity" type="text"
                                                   value={{$statistic['financialData']['returnOnEquity']['raw']}}>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">OTHERS</h4>
                                </div>
                                <div class="card-body">
                                    <div class="form-row">
                                        <div class="col-md-12 form-group">
                                            <label class="col-form-label">MARKET CAP</label>
                                            <input type="text" class="form-control" readonly
                                                   value={{$statistic['summaryDetail']['marketCap']['fmt']}}>
                                            <input hidden name="marketCap" type="text"
                                                   value={{$statistic['summaryDetail']['marketCap']['raw']}}>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-md-12 form-group">
                                            <label class="col-form-label">SHARE OUT STANDING</label>
                                            <input type="text" class="form-control" readonly
                                                   value={{$statistic['defaultKeyStatistics']['sharesOutstanding']['fmt']}}>
                                            <input hidden name="outstandingShare" type="text"
                                                   value={{$statistic['defaultKeyStatistics']['sharesOutstanding']['raw']}}>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-md-12 form-group">
                                            <label class="col-form-label">ACTUAL PRICE</label>
                                            <input type="text" class="form-control" readonly
                                                   value={{$statistic['price']['regularMarketPrice']['fmt']}}>
                                            <input hidden name="actualPrice" type="text"
                                                   value={{$statistic['price']['regularMarketPrice']['raw']}}>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mt-3">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="container d-flex justify-content-center">
                                <div class="card p-4">
                                    <div class="image d-flex flex-column justify-content-center align-items-center">
                                        <a href="{{$profile['assetProfile']['website'] ?: "#"}}" target="_blank">
                                            <img src="{{isset($logo['logos'][0]) ? $logo['logos'][0]['formats'][0]['src'] : asset('MyLogo.png')}}" height="100" width="100"/>
                                        </a>
                                        <span class="text-bold mt-3">{{$profile['quoteType']['shortName']}}</span>
                                        <span class="text">Sector : {{$profile['assetProfile']['sector']}}</span>
                                        <span class="text">Sub-Sector / Industry : {{$profile['assetProfile']['industry']}}</span>
                                        <div class="text mt-3">
                                            <span>{{strtok($profile['assetProfile']['longBusinessSummary'], '.')}}</span>
                                        </div>
                                        <label>
                                            <input hidden name="avatar" type="text"
                                                   value={{isset($logo['logos'][0]) ? $logo['logos'][0]['formats'][0]['src'] : asset('MyLogo.png')}}>
                                            <input hidden name="name" type="text"
                                                   value="{{$profile['quoteType']['shortName']}}">
                                            <input hidden name="code" type="text"
                                                   value="{{$symbol}}">
                                            <input hidden name="sector" type="text"
                                                   value="{{$profile['assetProfile']['sector']}}">
                                            <input hidden name="sub_sector" type="text"
                                                   value="{{$profile['assetProfile']['industry']}}">
                                            <input hidden name="summary" type="text"
                                                   value="{{strtok($profile['assetProfile']['longBusinessSummary'], '.')}}">
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    @endif
@stop

@section('footer')
    @include('footer')
@stop

@section('css')

@stop

@section("js")
    @include("msg")
@stop
