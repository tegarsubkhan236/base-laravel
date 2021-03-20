@extends('adminlte::page')

@section('title', ((isset($title))?$title:""))

@section('content_header')@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-3">
                            <h3>{{$title}}</h3>
                        </div>
                        <div class="col-md-9">
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table-bordered table-hover table" id="data-table">
                            <thead class="thead-olive">
                            <tr>
                                <th>No</th>
                                <th>Username</th>
                                <th class="text-center">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($data as $key => $row)
                                <tr>
                                    <td>{{($key+1)}}</td>
                                    <td>{{$row->username}}</td>
                                    <td class="text-center">
                                        <button type="button" data-id="{{$row->id}}" data-nama="{{$row->username}}" class="btn btn-sm btn-warning edit">
                                            <span class="fa fa-edit"></span>
                                        </button>
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

    <!-- Update Data Modal -->
    <div class="modal fade" id="update" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">{{$title}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="username">Name</label>
                            <label>
                                <input type="text" name="username" value="{{@$data['username']}}" class="form-control"  placeholder="Username">
                            </label>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Save</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop

@section('footer')
    <strong>Copyright &copy; 2021 <a href="/">Base Project</a>.</strong> All rights reserved.
@stop

@section('css')@stop

@section("js")
    @include("msg")
    <script>
        $("#data-table").DataTable({
            //
        });
    </script>
@stop
