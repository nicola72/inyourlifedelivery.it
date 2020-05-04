@extends('layouts.website')
@section('content')
    <section class="lightSection clearfix pageHeader">
        <div class="container">
            <div class="row">
                <div class="col-xs-6">
                    <div class="page-title">
                        <h2 class="fjalla">@lang('msg.dove_siamo')</h2>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <section class="mainContent clearfix productsContent">
        <div class="container">
            <div class="row">

                <!-- COLONNA A SINISTRA -->
                <div class="col-md-3 col-sm-12 col-xs-12 sideBar ">

                    <!-- menu prodotti -->
                @include('layouts.website_menu_prodotti')
                <!-- fine menu prodotti -->

                    <!-- box facebook -->
                @include('layouts.website_box_facebook')
                <!-- -->

                </div>
                <!-- FINE COLONNA SINISTRA -->

                <!-- PAGINA -->
                <div class="col-md-9 col-xs-12 col-sm-12">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="page-content">
                                @if(app()->getLocale() == 'it')
                                    <b>CENTRO STORICO:</b><br><br>
                                    oltrepassare Ponte Vecchio in direzione Piazza Pitti,
                                    svoltare alla prima a destra (borgo S. Jacopo) e camminare per ca. 100mt:
                                    il negozio è sulla sinistra al numero 23/r.<br><br>
                                    Via Borgo S.Jacopo, 23/r<br>
                                    50125 Firenze (FI)<br>
                                    Toscana - Italia<br><br>
                                    Tel.: +39 055 2645488
                                @else
                                    <b>HISTORICAL CENTER:</b><br><br>
                                    Cross "Ponte Vecchio" bridge towards Piazza Pitti, turn right at the first cross (borgo S. Jacopo) and walk down for about 100mt: you'll find our shop on your left (number 23/r).<br><br>
                                    Via Borgo S.Jacopo, 23/r<br>
                                    50125 Florence (FI)<br>
                                    Tuscany - Italy<br><br>
                                    Phone: +39 055 2645488
                                @endif
                            </div>
                        </div>
                        <div class="col-md-8">
                            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2881.250629865218!2d11.249839015501447!3d43.767655979117585!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x132a51555407ea59%3A0xf0b9337e0e59d237!2sMarsili&#39;s+Company!5e0!3m2!1sit!2sit!4v1486030236500" width="100%" height="400" frameborder="0" style="border:0" allowfullscreen></iframe>
                        </div>
                    </div>

                </div>
                <!-- -->
            </div>
        </div>
    </section>

@endsection
@section('js_script')

@stop