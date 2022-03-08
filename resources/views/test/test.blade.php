@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
@stop

@section('content')
    <div class="row">
        <div class="col-12 mt-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title text-uppercase text-bold">Test Crud</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive p-0">
                        <table id="datatable" class="table table-hover table-head-fixed" style="height: 300px; width: 100%">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Test Name</th>
                                <th>Test Desc</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@push('css')
    <style>
        tbody tr.selected {
            color: white !important;
            background-color: #007bff !important;
        }
    </style>
@endpush

@section('plugins.Datatables', true)
@push("js")
    <script>
        $(function () {

            let table = $('#datatable').DataTable({
                processing: true,
                serverSide: true,
                ordering:false,
                ajax: "{{ url('test/getList') }}",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'test_name', name: 'test_name'},
                    {data: 'test_desc', name: 'test_desc'},
                    {
                        data: 'action',
                        name: 'action',
                    },
                ]
            });
            $('#datatable tbody').on( 'click', 'tr', function () {
                if ( $(this).hasClass('selected') ) {
                    $(this).removeClass('selected');
                }
                else {
                    table.$('tr.selected').removeClass('selected');
                    $(this).addClass('selected');
                }
            } );

        });
    </script>
@endpush
