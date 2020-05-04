<!DOCTYPE html>
<html lang="@yield('lang', config('app.locale', 'it'))">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="robots" content="noindex" />
    <title>@yield('title', config('cms.name', 'CMS'))</title>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Styles -->
    @section('styles')

        <link href="{{ mix('/cms_assets/css/all.css') }}" rel="stylesheet">
        <link href="{{ mix('/cms_assets/font-awesome/css/font-awesome.css') }}" rel="stylesheet">

        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet">
    @show

@stack('head')
</head>

<body>
    <div id="wrapper">

        @include('layouts.cms_sidebar')

        <div id="page-wrapper" class="gray-bg">
            @include('layouts.cms_header')
            @include('layouts.cms_breadcrump')
            @include('layouts.cms_flash-message')

            <div class="wrapper wrapper-content">
                @yield('content')
            </div>

            @include('layouts.cms_footer')
        </div>

    </div>

    <!-- MODALE -->
    <div class="modal inmodal fade" id="myModal" tabindex="-1" role="dialog"  aria-hidden="true"></div>
    <!-- FINE MODALE -->

    @include('layouts.cms_loader')
    @include('layouts.cms_popup')

@section('scripts')
    <script src="/cms_assets/js/jquery-3.1.1.min.js"></script>
    <script src="/cms_assets/js/popper.min.js"></script>
    <script src="/cms_assets/js/bootstrap.js"></script>
    <script src="/cms_assets/js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="/cms_assets/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
    <script src="/cms_assets/js/plugins/dataTables/datatables.min.js"></script>
    <script src="/cms_assets/js/plugins/dataTables/dataTables.bootstrap4.min.js"></script>
    <script src="/cms_assets/js/plugins/summernote/summernote-bs4.js"></script>
    <script src="/cms_assets/js/plugins/validate/jquery.validate.min.js"></script>
    <script src="/cms_assets/js/plugins/dropzone/dropzone.js"></script>
    <script src="/cms_assets/js/plugins/blueimp/jquery.blueimp-gallery.min.js"></script>
    <script src="/cms_assets/js/plugins/sweetalert/sweetalert.min.js"></script>
    <script src="/cms_assets/js/plugins/chosen/chosen.jquery.js"></script>
    <script src="/cms_assets/js/plugins/datapicker/bootstrap-datepicker.js"></script>
    <script src="/cms_assets/js/plugins/chosen/chosen.jquery.js"></script>

    <!-- Custom and plugin javascript -->
    <script src="/cms_assets/js/inspinia.js"></script>
    <script src="/cms_assets/js/plugins/pace/pace.min.js"></script>

    <!-- Sparkline -->
    <script src="/cms_assets/js/plugins/sparkline/jquery.sparkline.min.js"></script>

    <script src="/cms_assets/js/cms.js"></script>
    <script>
        function showPreloader()
        {
            $('#loader-box').show();
        }

        function hidePreloader()
        {
            $('#loader-box').hide();
        }
    </script>
@show
    @yield('js_script')
@stack('body')

</body>

</html>
