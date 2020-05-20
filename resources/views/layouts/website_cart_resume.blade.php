<!DOCTYPE html>
<html lang="{{App::getLocale()}}">
<head>
    <title>{{$shop->insegna}}</title>
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

@include('layouts.website_header')

@yield('content')

@include('layouts.website_footer')
<a href="#" class="back-to-top hidden-xs-down" id="back-to-top"><i class="ti-angle-up"></i></a>

<!-- FLASH MESSAGE IN MODALE -->
@include('layouts.website_flash-message')
<!-- -->

<!-- MODALE -->
<div id="myModal" class="modal fade" role="dialog"></div>
<!-- FINE MODALE -->

@section('scripts')

    <!-- jQuery first, then Tether, then Bootstrap JS. -->
    <script src="/assets/js/plugins/plugins.js"></script>
    <script src="/assets/js/assan.custom.js"></script>
    <!-- load cubeportfolio -->
    <script type="text/javascript" src="/assets/cubeportfolio/js/jquery.cubeportfolio.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>
    <script src='https://www.google.com/recaptcha/api.js?hl=it'></script>
    <script>

        function showPreloader()
        {
            $('#inner-preloader').show();
            $('body').addClass('preloader-site');
        }

        function hidePreloader()
        {
            $('.preloader-wrapper').fadeOut();
            $('#inner-preloader').hide();
            $('body').removeClass('preloader-site');
        }

        function show_products(category_id)
        {
            showPreloader();
            $.ajax({
                type: "GET",
                url: "/category/"+category_id,
                dataType: "json",
                success: function (data){
                    $('#main-page').html(data.html);
                    hidePreloader();
                },
                error: function (){
                    hidePreloader();
                    alert("Si è verificato un errore! Riprova!");
                }
            });
        }

        function remove_from_cart(cart_id)
        {
            showPreloader();
            $.ajax({
                type: "GET",
                url: "/remove_from_cart/"+cart_id,
                dataType: "json",
                success: function (data){
                    $('#cart-menu-list').html(data.cart);
                    $('#cart_count').html(data.cart_count);
                    hidePreloader();
                },
                error: function (){
                    hidePreloader();
                    alert("Si è verificato un errore! Riprova!");
                }
            });
        }
    </script>
@show

@yield('js_script')
@yield('js_script_form')
@yield('js_flash')
@stack('body')
</body>
</html>