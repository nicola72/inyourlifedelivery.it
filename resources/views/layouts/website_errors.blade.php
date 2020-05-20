<!DOCTYPE html>
<html lang="{{App::getLocale()}}">
<head>
    <title>Delivery</title>
    <meta charset="utf-8">
    <meta name="Keywords" content="" />
    <meta name="Description" content="" />
    <meta name="language" content="it" />
    <meta http-equiv="Cache-control" content="public">
    <meta name="author" content="Designed by InYourLife- https://www.inyourlife.info" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="shortcut icon" href="/favicon.png">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Styles -->
    @section('styles')

        <link href="/assets/css/plugins/plugins.css" rel="stylesheet">
        <link href="/assets/css/style.css" rel="stylesheet">
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">

    @show

    @stack('head')
</head>
<body>
<div id="preloader">
    <div id="preloader-inner"></div>
</div>

<div id="inner-preloader" class="preloader-wrapper" style="display: none">
    <div class="preloader">
        <img src="/assets/img/preloader.gif" alt="">
    </div>
</div>

<!-- menu Carrello -->
<aside id="cart-container" class="pushy pushy-right">
    <div class="cart-content">
        <div class="clearfix">
            <a href="javascript:void(0)" class="pushy-link text-white-gray">Chiudi</a>
        </div>
        <div id="cart-menu-list">

        </div>
    </div>
</aside>
<div class="site-overlay"></div>
<!-- fine menu carrello -->

@include('layouts.website_flash-message')

@yield('content')

@include('layouts.website_footer')
<a href="#" class="back-to-top hidden-xs-down" id="back-to-top"><i class="ti-angle-up"></i></a>

<!-- MODALE -->
<div id="myModal" class="modal fade" role="dialog"></div>
<!-- FINE MODALE -->

@section('scripts')

    <!-- jQuery first, then Tether, then Bootstrap JS. -->
    <script src="/assets/js/plugins/plugins.js"></script>
    <script src="/assets/js/assan.custom.js"></script>
    <!-- load cubeportfolio -->

@show

@yield('js_script')
@yield('js_script_form')
@stack('body')
</body>
</html>