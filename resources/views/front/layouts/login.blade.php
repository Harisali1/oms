<!DOCTYPE html>
<html class="no-js" lang="en">

<head>
    <title>Login | Al Rafeeq Dispatch</title>
    <meta name="description" content="" />
    <!-- InstanceEndEditable -->
    <meta charset="UTF-8" />
    <meta content='IE=edge' http-equiv=X-UA-Compatible>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="{{ asset('assets/front/assets/css/main.css') }}">

    <!--<link rel="apple-touch-icon" sizes="57x57" href="{{ asset('assets/front/favicon/apple-icon-57x57.png') }}">-->
    <!--<link rel="apple-touch-icon" sizes="60x60" href="{{ asset('assets/front/favicon/apple-icon-60x60.png') }}">-->
    <!--<link rel="apple-touch-icon" sizes="72x72" href="{{ asset('assets/front/favicon/apple-icon-72x72.png') }}">-->
    <!--<link rel="apple-touch-icon" sizes="76x76" href="{{ asset('assets/front/favicon/apple-icon-76x76.png') }}">-->
    <!--<link rel="apple-touch-icon" sizes="114x114" href="{{ asset('assets/front/favicon/apple-icon-114x114.png') }}">-->
    <!--<link rel="apple-touch-icon" sizes="120x120" href="{{ asset('assets/front/favicon/apple-icon-120x120.png') }}">-->
    <!--<link rel="apple-touch-icon" sizes="144x144" href="{{ asset('assets/front/favicon/apple-icon-144x144.png') }}">-->
    <!--<link rel="apple-touch-icon" sizes="152x152" href="{{ asset('assets/front/favicon/apple-icon-152x152.png') }}">-->
    <!--<link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/front/favicon/apple-icon-180x180.png') }}">-->
    <!--<link rel="icon" type="image/png" sizes="192x192"  href="{{ asset('assets/front/favicon/android-icon-192x192.png') }}">-->
    <!--<link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/front/favicon/favicon-32x32.png') }}">-->
    <!--<link rel="icon" type="image/png" sizes="96x96" href="{{ asset('assets/front/favicon/favicon-96x96.png') }}">-->
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/front/assets/images/logo.jpg') }}">
    <link rel="manifest" href="{{ asset('assets/front/assets/images/logo.jpg') }}">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="{{ asset('assets/front/assets/images/logo.jpg') }}">
    <meta name="theme-color" content="#e36d29">
</head>

<body>
    <main id="main" class="page-login">
        <div class="pg-container container-fluid">
            <div class="row_1 row align-items-top no-gutters justify-content-end">
                <!-- Login left column - [Start] -->
                <aside class="left-column col-12 col-md-5 full-h d-none d-sm-block">

                </aside>
                <!-- Login left column - [/end] -->

                <!-- Login right column - [Start] -->
                <aside class="right-column col-12 col-sm-7">
                    <div class="inner full-h-min flexbox flex-center">
                        <div class="full-w">
                            <div id="logo" class="dp-table marginauto mb-20">
{{--                                <img src="{{ asset('assets/front/assets/images/logo.jpg') }}" alt="">--}}
{{--                                <h1>Order Management System</h1>--}}
                            </div>
                            @yield('content')
                        </div>
                    </div>
                </aside>
                <!-- Login right column - [/end] -->
            </div>
        </div>
    </main>
</body>

<script src="{{ asset('assets/front/assets/js/jquery-3.0.0.js') }}"></script>
<script src="{{ asset('assets/front/assets/js/jquery-migrate-3.3.2.js') }}"></script>
<script src="{{ asset('assets/front/assets/js/bootstrap.js') }}"></script>
<script src="{{ asset('assets/front/assets/js/main.js') }}"></script>
</html>
