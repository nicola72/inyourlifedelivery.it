@extends('layouts.website')
@section('content')
    <div class="container">
        <div class="row" style="margin-left: 0; padding-left: 0;">
            <div class="col-md-12" style="margin-left: 0; padding-left: 0;">
                <div class="col-md-6"
                     style="margin-left: 0; padding-left: 0; font-size: 130%; margin-top: 20px;">
                </div>
            </div>
        </div>
    </div>

    <!-- SLIDER -->
    @if($slider)
        @include('website.page.partials.slider')
    @endif
    <!-- FINE SLIDER -->

    <section style="background-color:#fcfcfc;">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center" style="font-size:180%; padding-top:30px; line-height:1.5em; font-weight:bold;">
                    @lang('msg.home_1')
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
                <div class="col-md-9 col-sm-12 col-xs-12">

                    <!-- NOVITA' -->
                    @if($prodotti_novita || $abbinamenti_novita)
                        <div class="col-xs-12">
                            <div class="page-header">
                                <h3 class="fjalla" style="color: #840025;">	NOVITA' IN VETRINA</h3>
                            </div>
                        </div>
                        <div class="col-xs-12">
                            <div class="owl-carousel featuredProductsSlider">
                                @if($prodotti_novita)
                                    @foreach($prodotti_novita as $product)
                                        <div class="slide">
                                            <div class="productImage clearfix">
                                                <a href="{{$product->url()}}">
                                                    <img src="{{$website_config['cs_small_dir'].$product->cover()}}" alt="{{$seo->alt ?? ''}}">
                                                </a>
                                            </div>
                                            <div class="productCaption clearfix">
                                                <a href="{{$product->url()}}">
                                                    <div class="titolo_prodotto">
                                                        {{$product->{'nome_'.app()->getLocale()} }}
                                                    </div>
                                                </a>
                                                <div class="fjalla prezzo">
                                                    @if($product->is_scontato())
                                                        <span class="prezzo_pieno">@money($product->prezzo)  &euro;</span>
                                                        &nbsp;&nbsp;
                                                        <span>@money($product->prezzo_scontato)</span>
                                                    @else
                                                        <span>@money($product->prezzo)</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif

                                @if($abbinamenti_novita)
                                    @foreach($abbinamenti_novita as $pairing)
                                        <div class="slide">
                                            <div class="productImage clearfix">
                                                <a href="{{$pairing->url()}}">
                                                    <img src="{{$website_config['cs_small_dir'].$pairing->cover()}}" alt="{{$seo->alt ?? ''}}">
                                                </a>
                                            </div>
                                            <div class="productCaption clearfix">
                                                <a href="{{$pairing->url()}}">
                                                    <div class="titolo_prodotto">
                                                        {{$pairing->{'nome_'.app()->getLocale()} }}
                                                    </div>
                                                </a>
                                                <div class="fjalla prezzo">
                                                    @money($pairing->product1->prezzo_vendita() + $pairing->product2->prezzo_vendita()) &euro;
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    @endif
                    <!-- FINE NOVITA' -->

                    <!-- OFFERTE -->
                    @if($prodotti_offerta || $abbinamenti_offerta)
                        <div class="col-xs-12" style="padding-top:20px;">
                            <div class="page-header">
                                <h3 class="fjalla" style="color: #840025;">
                                    <img src="/img/offerte.png" alt="" style="vertical-align:middle;" class="hidden-xs"/>
                                    @lang('msg.offerte_settimana')
                                </h3>
                            </div>
                        </div>
                        <div class="col-xs-12">
                            <div class="owl-carousel featuredProductsSlider">
                                @if($prodotti_offerta)
                                    @foreach($prodotti_offerta as $product)
                                        <div class="slide">
                                            <div class="productImage clearfix">
                                                <a href="{{$product->url()}}">
                                                    <img src="{{$website_config['cs_small_dir'].$product->cover()}}" alt="{{$seo->alt ?? ''}}">
                                                </a>
                                            </div>
                                            <div class="productCaption clearfix">
                                                <a href="{{$product->url()}}">
                                                    <div class="titolo_prodotto">
                                                        {{$product->{'nome_'.app()->getLocale()} }}
                                                    </div>
                                                </a>
                                                <div class="fjalla prezzo">
                                                    @if($product->is_scontato())
                                                        <span class="prezzo_pieno">@money($product->prezzo)  &euro;</span>
                                                        &nbsp;&nbsp;
                                                        <span>@money($product->prezzo_scontato)</span>
                                                    @else
                                                        <span>@money($product->prezzo)</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif

                                @if($abbinamenti_offerta)
                                    @foreach($abbinamenti_offerta as $pairing)
                                        <div class="slide">
                                            <div class="productImage clearfix">
                                                <a href="{{$pairing->url()}}">
                                                    <img src="{{$website_config['cs_small_dir'].$pairing->cover()}}" alt="{{$seo->alt ?? ''}}">
                                                </a>
                                            </div>
                                            <div class="productCaption clearfix">
                                                <a href="{{$pairing->url()}}">
                                                    <div class="titolo_prodotto">
                                                        {{$pairing->{'nome_'.app()->getLocale()} }}
                                                    </div>
                                                </a>
                                                <div class="fjalla prezzo">
                                                    @money($pairing->product1->prezzo_vendita() + $pairing->product2->prezzo_vendita()) &euro;
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    @endif
                    <!-- FINE OFFERTE -->

                    <div class="col-md-12 col-sm-12 col-xs-12 text-center home_box hidden-md hidden-lg hidden-xs hidden-sm"  style="border-top: 1px dotted #666;">
                        <img src="img/set_1.jpg" alt="" class="img-responsive">
                        @lang('msg.home_2')
                    </div>

                    @if(app()->getLocale() == 'it')
                    <div class="col-sm-12 col-xs-12 text-center home_box  hidden-md hidden-lg">
                        <div class="imageWrapper">
                            <img src="/img/shipping.jpg" alt="{{$seo->alt ?? ''}}" class="img-responsive" style="display: block; margin: 0 auto;">
                            @lang('msg.spedizione_gratis')
                        </div>
                    </div>
                    @endif

                    <div class="col-md-12 text-center" style="margin:0; padding:0; border-top:1px dotted #850728; padding-top:15px;">
                        <p style="font-size:150%; color:#850728; padding-bottom:10px; font-weight:bold;">
                            @lang('msg.pacchetto_regalo_msg')
                        </p>
                        <img src="/img/scacchi_online_5.jpg" class="img-responsive" alt="{{$seo->alt ?? ''}}" style="margin-bottom: 20px;" />

                    </div>
                    <div class="col-md-6" style="margin: 30px 0 0 0; padding: 0 2px 0 0;">
                        <img src="/img/scacchi_online_7.jpg" class="img-responsive" alt="{{$seo->alt ?? ''}}" style="margin-bottom: 20px;" />
                    </div>

                    <div class="col-md-6"  style="margin: 30px 0 0 0; padding: 0 0 0 2px;">
                        <img src="/img/scacchi_online_6.jpg" class="img-responsive" alt="{{$seo->alt ?? ''}}" style="margin-bottom: 20px;" />
                    </div>
                </div>
                <!-- -->

            </div>
        </div>
    </section>

    <!-- POPUP NEWS -->
    @if($popup)
    <div id="popup" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modalpopup-title">{{$popup->{'nome_'.app()->getLocale()} }}</h4>
                </div>
                <div class="modalpopup-body">
                    {{$popup->{'desc_'.app()->getLocale()} }}
                </div>
                <div class="modal-footer" style="text-align:left;">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>
    @endif
    <!-- -->

@endsection
@section('js_script')
    <script>
        $(document).ready(function() {
            $("#popup").modal('show');
        });
    </script>
@stop