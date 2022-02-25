@extends('_layout.front.app')

@section('content')
    <section class="client_section layout_padding">
        <div class="container">
            <h2 class="main-heading">
                Login
            </h2>
            <p class="text-center">
                reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla
            </p>
            <div class="">
                <div class="contact_section-container">
                    <div class="row">
                        <div class="col-md-6 mx-auto">
                            <div class="contact-form">
                                <form action="{{ route('login') }}" method="post">
                                    @csrf
                                    <div>
                                        <label for="username">Username :</label>
                                        <input type="text" name="username" id="username" placeholder="Username" class="form-control">
                                    </div>
                                    <div>
                                        <label for="password">Password :</label>
                                        <input type="text" name="password" id="password" placeholder="Password" class="form-control">
                                    </div>
                                    <div class="d-flex justify-content-center">
                                        <button type="submit" class="btn_on-hover">
                                            Send
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
