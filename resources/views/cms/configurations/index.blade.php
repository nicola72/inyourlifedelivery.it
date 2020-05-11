@extends('layouts.cms')
@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox">

                    <!-- header del box -->
                    <div class="ibox-title">

                        <div class="ibox-tools">
                            <a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <!-- fine header -->

                    <div class="ibox-content">
                        <div class="row mb-2 pb-2 border-bottom">
                            <div class="col-md-12">
                                <h4>Logo</h4>
                            </div>
                            <div class="col-md-10">
                                non impostato
                            </div>
                            <div class="col-md-2">
                                <a href="{{url('cms.configurations/edit_logo',$shop->id)}}">
                                    <i class="fa fa-edit fa-2x"></i>
                                </a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js_script')
    <script>

    </script>
@stop
