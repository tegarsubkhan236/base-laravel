@extends('adminlte::page')

@section('title', ((isset($title))?$title:""))

@section('content_header')

@stop

@section('content')
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
                                    <a href="{{route('yahoo.list.sector',[$sector])}}" type="button"
                                       class="btn btn-sm btn-danger">
                                        Back
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="form-row">
                                <div class="col-md-4 form-group">
                                    <label for="netIncome" class="col-form-label">Net Income [TTM]</label>
                                    <input readonly name="netIncome" id="netIncome" type="text" class="form-control"
                                           value="{{number_format_short($data['netIncome'])}}">
                                </div>
                                <div class="col-md-4 form-group">
                                    <label for="profitMargin" class="col-form-label">PROFIT MARGIN</label>
                                    <input readonly name="profitMargin" id="profitMargin" type="text"
                                           class="form-control"
                                           value="{{number_format_percentage($data['profitMargin'])}}">
                                </div>
                                <div class="col-md-4 form-group">
                                    <label for="operationMargin" class="col-form-label">OPERATION MARGIN</label>
                                    <input readonly name="operationMargin" id="operationMargin" type="text"
                                           class="form-control"
                                           value="{{number_format_percentage($data['operationMargin'])}}">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-6 form-group">
                                    <label for="returnOnAsset" class="col-form-label">RETURN ON ASSET</label>
                                    <input readonly name="returnOnAsset" id="returnOnAsset" type="text"
                                           class="form-control"
                                           value="{{number_format_percentage($data['returnOnAsset'])}}">
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="returnOnEquity" class="col-form-label">RETURN ON EQUITY</label>
                                    <input readonly name="returnOnEquity" id="returnOnEquity" type="text"
                                           class="form-control"
                                           value="{{number_format_percentage($data['returnOnEquity'])}}">
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
                                    <label for="marketCap" class="col-form-label">MARKET CAP</label>
                                    <input readonly name="marketCap" id="marketCap" type="text" class="form-control"
                                           value="{{number_format_short($data['marketCap'])}}">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-12 form-group">
                                    <label for="outstandingShare" class="col-form-label">SHARE OUT STANDING</label>
                                    <input readonly name="outstandingShare" id="outstandingShare" type="text"
                                           class="form-control"
                                           value="{{number_format_short($data['outstandingShare'])}}">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-12 form-group">
                                    <label for="actualPrice" class="col-form-label">ACTUAL PRICE</label>
                                    <input readonly name="actualPrice" id="actualPrice" type="text" class="form-control"
                                           value="{{number_format_short($data['actualPrice'])}}">
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
                                <img src="{{$data['avatar']}}" alt="avatar" height="100" width="100"/>
                                <span class="text-bold mt-3">{{$data['name']}}</span>
                            </div>
                            <div>
                                <span class="text-left">Sector : <b>{{$data['sector']}}</b></span><br>
                                <span class="text-left">Sub-Sector / Industry : <b>{{$data['subSector']}}</b></span>
                                <div class="text mt-3">
                                    <span>{{strtok($data['summary'], '.')}}</span>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="d-flex justify-content-center">
                                    <form action="{{route('yahoo.update',['id' => $data['id']])}}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-sm btn-danger">Update Stock</button>
                                    </form>
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
                            <h4 class="card-title">
                                INTRINSIC VALUE
                            </h4>
                        </div>
                        <div class="card-body">
                            <div class="form-row">
                                <div class="col-md-12 form-group">
                                    <label for="EPS" class="col-form-label">EPS</label>
                                    <input readonly name="EPS" id="EPS" type="text" class="form-control"
                                           value="{{number_format_short($data['netIncome']/$data['outstandingShare'])}}">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-12 form-group">
                                    <label for="PER" class="col-form-label">PER</label>
                                    <input readonly name="PER" id="PER" type="text"
                                           class="form-control"
                                           value="{{number_format_short($data['actualPrice']/($data['netIncome']/$data['outstandingShare']))}}">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-12 form-group">
                                    <label for="avgPER" class="col-form-label">Average PER {{$sector}} Industry</label>
                                    <input readonly name="avgPER" id="avgPER" type="text"
                                           class="form-control" value="{{number_format_short($avgPER_Industry)}}">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-12 form-group">
                                    <label for="intrinsicValue" class="col-form-label">INTRINSIC VALUE</label>
                                    <input readonly name="intrinsicValue" id="intrinsicValue" type="text" class="form-control"
                                           value="{{number_format($intrinsicValue,'0')}}">
                                </div>
                            </div>
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

@section("js")
    @include("msg")
@stop
