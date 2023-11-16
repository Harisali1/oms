<!DOCTYPE html>
<html class="no-js" lang="en">

<head>
    <title>@yield('page-title') | Al Rafeeq Dispatch</title>
    <meta name="description" content="" />
    <meta charset="UTF-8" />
    <meta content='IE=edge' http-equiv=X-UA-Compatible>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="{{ asset('assets/front/assets/css/select2.min.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('assets/front/assets/css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/front/assets/custom_css/custom.css') }}">
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
    <link rel="manifest" href="{{ asset('assets/front/favicon/manifest.json') }}">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="{{ asset('assets/front/assets/images/logo.jpg') }}">
    <meta name="theme-color" content="#e36d29">
    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @yield('css')
</head>

<body>

        <header>
            @include('front.layouts.includes.header')
        </header>

        @yield('content')

        @include('front.layouts.includes.footer')

</body>

{{--<script src="{{ asset('assets/front/assets/js/jquery-3.0.0.js') }}"></script>--}}
<script src="{{ asset('assets/front/assets/js/jquery-migrate-3.3.2.js') }}"></script>
<script src="{{ asset('assets/front/assets/js/bootstrap.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script src="{{ asset('assets/front/assets/js/main.js') }}"></script>
<script src="{{ asset('assets/front/assets/js/joeyco-script.js') }}"></script>
@yield('js')
</html>