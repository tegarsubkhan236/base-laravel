@extends('_layout.front.app')

@section('hero')
    <section class="hero_section">
        <div class="hero-container container">
            <div class="hero_detail-box">
                <h3>
                    Welcome to <br>
                    Best educations
                </h3>
                <h1>
                    school
                </h1>
                <p>
                    There are many variations of passages of Lorem Ipsum available, but the majority have suffered
                    alteration in
                    some form, by injected humour, or randomised
                </p>
                <div class="hero_btn-continer">
                    <a href="" class="call_to-btn btn_white-border">
              <span>
                Contact
              </span>
                        <img src="{{ asset("landing/assets/images/right-arrow.png") }}" alt="">
                    </a>
                </div>
            </div>
            <div class="hero_img-container">
                <div>
                    <img src="{{ asset("landing/assets/images/hero.png") }}" alt="" class="img-fluid">
                </div>
            </div>
        </div>
    </section>
@endsection
@section('content')
    <!-- client section -->
    <section class="client_section layout_padding">
        <div class="container">
            <h2 class="main-heading ">
                Our Students Feedback
            </h2>
            <p class="text-center">
                There are many variations of passages of Lorem Ipsum available, but the majority hThere are many variations
                of
                passages of Lorem Ipsum available, but the majority h
            </p>
            <div class="layout_padding2">
                <div class="client_container d-flex flex-column">
                    <div class="client_detail d-flex align-items-center">
                        <div class="client_img-box ">
                            <img src="{{ asset("landing/assets/images/student.png") }}" alt="">
                        </div>
                        <div class="client_detail-box">
                            <h4>
                                Veniam Quis
                            </h4>
                            <span>
                (exercitation)
              </span>
                        </div>
                    </div>
                    <div class="client_text mt-4">
                        <p>
                            "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut
                            labore et
                            dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut
                            aliquip ex
                            ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum
                            dolore eu
                            fugiat
                            nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia
                            deserunt mollit
                            anim id est laborum."
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- client section -->

    <!-- contact section -->
    <section class="contact_section layout_padding-bottom">
        <div class="container">
            <h2 class="main-heading">
                Contact Now
            </h2>
            <p class="text-center">
                reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla
            </p>
            <div class="">
                <div class="contact_section-container">
                    <div class="row">
                        <div class="col-md-6 mx-auto">
                            <div class="contact-form">
                                <form action="">
                                    <div>
                                        <input type="text" placeholder="Name">
                                    </div>
                                    <div>
                                        <input type="text" placeholder="Phone Number">
                                    </div>
                                    <div>
                                        <input type="email" placeholder="Email">
                                    </div>
                                    <div>
                                        <input type="text" placeholder="Message" class="input_message">
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
    <!-- end contact section -->
@endsection
