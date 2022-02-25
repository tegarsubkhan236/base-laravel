<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Basic -->
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <!-- Mobile Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    <!-- Site Metas -->
    <meta name="keywords" content=""/>
    <meta name="description" content=""/>
    <meta name="author" content=""/>
    <title>Adward</title>
    <!-- bootstrap core css -->
    <link rel="stylesheet" type="text/css" href="{{ asset("landing/assets/css/bootstrap.css") }}"/>
    <!-- progress barstle -->
    <link rel="stylesheet" href="{{ asset("landing/assets/css/css-circular-prog-bar.css") }}">
    <!-- fonts style -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,700&display=swap" rel="stylesheet">
    <!-- font wesome stylesheet -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <!-- Custom styles for this template -->
    <link href="{{ asset("landing/assets/css/style.css") }}" rel="stylesheet"/>
    <!-- responsive style -->
    <link href="{{ asset("landing/assets/css/responsive.css") }}" rel="stylesheet"/>
    <link rel="stylesheet" href="{{ asset("landing/assets/css/css-circular-prog-bar.css") }}">
</head>

<body>
<div class="{{ \request()->is('/') ? 'top_container' : 'top_container sub_pages'}}">
    @include('_layout.front.components.header')
    @yield('hero')
</div>
<!-- end header section -->

@yield('content')

<!-- footer section -->
@include('_layout.front.components.footer')
<!-- footer section -->

<script type="text/javascript" src="{{ asset("landing/assets/js/jquery-3.4.1.min.js") }}"></script>
<script type="text/javascript" src="{{ asset("landing/assets/js/bootstrap.js") }}"></script>
</body>

</html>
