<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">

    <title>Talks amerikas</title>
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-touch-fullscreen" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">

    {{--Estilos css de la plantilla principal    --}}
    <link rel="stylesheet" type="text/css" href="{{ asset('bootstrap4/css/bootstrap.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('template/app-assets/fonts/icomoon.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('template/app-assets/fonts/flag-icon-css/css/flag-icon.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/main/main.css') }}">

</head>
<body>
    <nav class="navbar navbar-expand-lg main-navbar">
        <div class="collapse navbar-collapse" id="main-navbar">
            <a class="navbar-brand" href="#">
                <img src="{{ asset('img/logo/logo_normal.svg') }}" alt="Talk americas" height="40">
            </a>
            <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                <li class="nav-item active">
                    <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                </li>
            </ul>
            <div class="my-2">
                <a href="{{ route('login') }}">Login</a>
            </div>
        </div>

    </nav>
    <div class="container-fluid">
        <div class="row main-banner">
            <div class="col col-lg-6 col-md-6" style="margin-top: auto; margin-bottom: auto;">
                <div class="row justify-content-center align-items-center">
                    <div class="main-card">
                        <div class="row justify-content-center">
                            <h3>Talks americas</h3>
                            <br>
                        </div>
                        <br>
                        <p style="text-align: justify">
                            Lorem ipsum dolor sit amet, rj45 consectetur adipisicing elit. Amet ducimus earum est fugit iure mollitia, nemo, nostrum nulla perspiciatis possimus quae quis quisquam tempore temporibus?
                        </p>
                        <div class="row justify-content-center">
                            <button class="main-btn">
                                Vamos !
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col col-lg-6"></div>
        </div>
    </div>
</body>
</html>
