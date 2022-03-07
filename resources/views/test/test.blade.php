@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
@stop

@section('content')
    <div class="row">
        <div class="col-md-12 mt-3">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title text-uppercase text-bold">TEST SECTION</h3>
                </div>
                <div class="card-header justify-content-between">
                    <div class="row justify-content-between">
                        <div class="col-9">
                            <div class="btn-group-sm">
                                @can('test-create')
                                    <a class="btn btn-success bg-olive" href="{{ route('test.create') }}">
                                        <i class="fas fa-plus"></i> Create
                                    </a>
                                @endcan
                                @can('test-create')
                                    <a class="btn btn-warning" href="{{ route('test.create') }}">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                @endcan
                                @can('test-create')
                                    <a class="btn btn-danger" href="{{ route('test.create') }}">
                                        <i class="fas fa-trash"></i> Delete
                                    </a>
                                @endcan
                            </div>
                        </div>
                        <div class="col-3">

                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="myTable" class="table table-hover table-border">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Desc</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($tests as $key => $test)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ $test->test_name }}</td>
                                    <td>{{ $test->test_desc }}</td>
                                    <td>
                                        <div class="btn-group-sm">
                                            <a class="btn btn-info" href="{{ route('test.show',$test->id) }}">Show</a>
                                            @can('test-edit')
                                                <a class="btn btn-primary" href="{{ route('test.edit',$test->id) }}">Edit</a>
                                            @endcan
                                            @can('test-delete')
                                                {!! Form::open(['method' => 'DELETE','route' => ['test.destroy', $test->id],'style'=>'display:inline']) !!}
                                                {!! Form::submit('Delete', ['class' => 'btn btn-sm btn-danger']) !!}
                                                {!! Form::close() !!}
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')

@stop

@section('plugins.Datatables', true)
@section("js")
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
