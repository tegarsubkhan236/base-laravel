@extends('_layout.base')

@section('header')
    <div class="page-header row no-gutters py-4">
        <div class="col-12 col-sm-4 text-center text-sm-left mb-0">
            <span class="text-uppercase page-subtitle">Role</span>
            <h3 class="page-title">Blog Overview</h3>
        </div>
    </div>
@endsection

@section('alert')
    <div class="alert alert-success alert-dismissible fade show mb-0" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
        <i class="fa fa-check mx-2"></i>
        <strong>Success!</strong> Your profile has been updated!
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col">
            <div class="card card-small mb-4">
                <div class="card-header border-bottom">
                    <h6 class="m-0">Role</h6>
                </div>
                <div class="card-body p-0 pb-3 text-center">
                    <table class="table mb-0">
                        <thead class="bg-light">
                        <tr>
                            <th scope="col" class="border-0">#</th>
                            <th scope="col" class="border-0">First Name</th>
                            <th scope="col" class="border-0">Last Name</th>
                            <th scope="col" class="border-0">Country</th>
                            <th scope="col" class="border-0">City</th>
                            <th scope="col" class="border-0">Phone</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>1</td>
                            <td>Ali</td>
                            <td>Kerry</td>
                            <td>Russian Federation</td>
                            <td>Gdańsk</td>
                            <td>107-0339</td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Clark</td>
                            <td>Angela</td>
                            <td>Estonia</td>
                            <td>Borghetto di Vara</td>
                            <td>1-660-850-1647</td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>Jerry</td>
                            <td>Nathan</td>
                            <td>Cyprus</td>
                            <td>Braunau am Inn</td>
                            <td>214-4225</td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td>Colt</td>
                            <td>Angela</td>
                            <td>Liberia</td>
                            <td>Bad Hersfeld</td>
                            <td>1-848-473-7416</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('css')

@endpush

@push('js')

@endpush
