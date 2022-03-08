@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content')
    <div class="row">
        <div class="col-12 mt-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title text-uppercase text-bold">User Account</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive p-0">
                        <table id="example" class="table display compact" style="width: 100%;">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Username</th>
                                <th>Email</th>
                            </tr>
                            </thead>
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
            color: white;
            background-color: #007bff;
        }
    </style>
@endpush

@section('plugins.Datatables', true)
@push('js')
    <script>
        $(document).ready(function() {
            let table = $('#example').DataTable({
                processing: true,
                search: {
                    return: true
                },
                serverSide: true,
                ajax: "{{ route('user-setting.user.user-list') }}",
                columns: [
                    { "data": "id" },
                    { "data": "name" },
                    { "data": "email" },
                ],
                ordering: false,
                info: false,
                paging: true,
                pageLength: 10
            });

            $('#example tbody').on( 'click', 'tr', function () {
                if ( $(this).hasClass('selected') ) {
                    $(this).removeClass('selected');
                }
                else {
                    table.$('tr.selected').removeClass('selected');
                    $(this).addClass('selected');
                }
            } );
        } );
    </script>
@endpush
