@extends('adminlte::page')

@section('title', ((isset($title))?$title:""))

@section('content_header')

@stop

@section('content')
    <div class="row">
        <div class="col-md-12 mt-3">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Stock Compare</h4>
                </div>
                <div class="card-body">
                    <form action="{{route('yahoo.search')}}" method="POST" >
                        @csrf
                        <div class="form-row">
                            <div class="col-md-3 form-group">
                                <label for="symbol" class="col-form-label">Symbol of Equity</label>
                                <input type="text" name="symbol" id="symbol" class="form-control">
                            </div>
                            <div class="col-md-3 form-group">
                                <label for="symbol" class="col-form-label">Symbol of Equity</label>
                                <input type="text" name="symbol" id="symbol" class="form-control">
                            </div>
                            <div class="col-md-3 form-group">
                                <label for="symbol" class="col-form-label">Symbol of Equity</label>
                                <input type="text" name="symbol" id="symbol" class="form-control">
                            </div>
                            <div class="col-md-3 form-group">
                                <label for="symbol" class="col-form-label">Symbol of Equity</label>
                                <input type="text" name="symbol" id="symbol" class="form-control">
                            </div>
                            <div class="col-md-1 pt-4 mt-2 form-group">
                                <button type="submit" class="btn btn-danger">Search</button>
                            </div>
                        </div>
                    </form>
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
