<div class="header clearfix">
    <!-- TOPBAR -->
    <div class="topBar">
        <h1 class="h1 hidden-xs">{{$seo->h1  ?? ""}}</h1>
        <div class="container">
            <div class="row">
                <div class="col-md-6 hidden-sm hidden-xs">
                    <ul class="list-inline">
                        <li>
                            <a href="https://www.facebook.com/Marsilis-Company-316915328512344/" target="_blank">
                                <i class="fa fa-facebook"></i>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="col-md-6 col-xs-12">
                    <ul class="list-inline pull-right">

                        <!-- MENU' LINGUE -->
                        <li>
                            @if(app()->getLocale() == 'it')
                            <a href="https://www.chess-store.org">
                                <img src="/img/flag_eng.jpg" alt="{{$seo->alt ?? ""}}" />
                            </a>
                            @else
                            <a href="https://www.chess-store.it">
                                <img src="/img/flag_ita.jpg" alt="{{$seo->alt ?? ""}}" />
                            </a>
                            @endif
                            <a href="https://www.chess-store.net">
                                <img src="/img/flag_esp.jpg" alt="{{$seo->alt ?? ""}}" />
                            </a>
                            <a href="https://www.chess-store-italy.ru">
                                <img src="/img/flag_rus.jpg" alt="{{$seo->alt ?? ""}}" />
                            </a>
                            <a href="https://www.chessstore.de">
                                <img src="/img/flag_deu.jpg" alt="{{$seo->alt ?? ""}}" />
                            </a>
                        </li>
                        <!-- FINE MENU LINGUE -->

                        @auth
                            @include('layouts.website_auth_menu')
                        @endauth

                        @guest
                            @include('layouts.website_guest_menu')
                        @endguest

                        <li class="dropdown searchBox">
                            <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-search"></i>
                            </a>

                            <ul class="dropdown-menu dropdown-menu-right" style="margin-left:30px;">
                                <li>
                                    <form id="search_form" action="{{$pages->where('nome','ricerca')->first()->url()}}" method="get">
                                        <span class="input-group">
                                            <input type="text" name="searchterm" class="form-control" placeholder="@lang('msg.cerca')" aria-describedby="basic-addon2">
                                            <span style="cursor:pointer" class="input-group-addon" id="basic-addon2" onclick="$('#search_form').submit();">
                                                @lang('msg.cerca')
                                            </span>
                                        </span>
                                    </form>
                                </li>
                            </ul>

                        </li>
                        <li>
                            <a href="{{$pages->where('nome','wishlist')->first()->url()}}">
                                &nbsp;&nbsp;
                                <i class="fa fa-heart" aria-hidden="true"></i>&nbsp;&nbsp;
                            </a>
                        </li>
                        <!-- pulsante carrello per mobile -->
                        <li class="hidden-md hidden-sm hidden-lg">
                            <a href="{{$pages->where('nome','carrello')->first()->url()}}">
                                <i class="fa fa-shopping-cart"></i>
                                <span class="carrello_nr">{{$carts->count()}}</span>
                            </a>
                        </li>
                        <!--  -->

                        <!-- pulsante carrello per desktop -->
                        <li class="dropdown hidden-xs" >
                            <a href="{{$pages->where('nome','carrello')->first()->url()}}" class="dropdown-toggle" data-toggle="dropdown disabled">
                                <i class="fa fa-shopping-cart"></i>
                                <span class="carrello_nr">{{$carts->count()}}</span>
                            </a>
                            <ul id="cart-menu" class="dropdown-menu dropdown-menu-right">

                                @if($carts->count() > 0)
                                <li>@lang('msg.carrello_1')</li>

                                    @foreach($carts as $cart)
                                    <li>
                                        <a href="javascript:void(0)">
                                            <div class="media">
                                                <img class="media-left media-object foto_carrello" src="https://www.chess-store.it<?php //echo $img?>" alt="">
                                                <div class="media-body">
                                                    <h5 class="media-heading" style="max-width:130px;overflow: hidden;">
                                                        {{substr($cart->product->{'nome_'.app()->getLocale()},0,10)}}
                                                        ...
                                                        <br>
                                                        <span>{{$cart->qta}} X @money($cart->product->prezzo_vendita())</span>
                                                    </h5>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    @endforeach
                                @else
                                <li>@lang('msg.carrello_2')</li>
                                @endif
                                <li>
                                    <div class="btn-group" role="group" aria-label="..." style="text-align:right;">
                                        <button type="button" class="btn btn-default" style="color:#000;margin-left:130px;" onclick="location.href='{{$pages->where('nome','carrello')->first()->url()}}';">
                                            @lang('msg.carrello')
                                        </button>
                                    </div>
                                </li>
                            </ul>
                        </li>
                        <!--  -->
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- NAVBAR -->
    <nav class="navbar navbar-main navbar-default" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <a class="navbar-brand" href="/" style="min-height:70px; display:block; float:none;">
                    <img src="/img/logo.jpg" alt="{{$seo->alt ?? ""}}" style="margin-bottom:2px;">
                </a>

                <span class="negozio scritta hidden-sm hidden-md hidden-lg text-center" style="line-height:1.1em; font-size:20px;">
                    @lang('msg.titolo_homepage')
                </span>

            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <a href="/">Home</a>
                    </li>
                    @foreach($pages->where('menu', 1) as $page)
                        <li class="{{ $page->is_current() ? 'active' : '' }}">
                            <a href="{{$page->url()}}">{{$page->label() }}</a>
                        </li>
                    @endforeach

                </ul>
            </div><!-- /.navbar-collapse -->
        </div>
        @if(app()->getLocale() == 'it')
            <div class="negozio scritta hidden-xs col-sm-12 col-md-12 text-center abril shipping_sm" >
                <span style="color:#000; font-family: 'Fjalla One', sans-serif; font-size:50%;" class="hidden-sm">
                    <img src="img/shipping_1.jpg" alt="" style="width:100px;"/>
                    <br/>SPEDIZIONE STANDARD GRATIS IN TUTTA ITALIA<br/>
                    <span style="font-size:90%;">per ordini di importo superiore a 49 €</span>
                </span>
                <br/><br/>
                <span style="line-height:1.6em; font-size:20px;">IL NEGOZIO DI SCACCHI A FIRENZE</span>
            </div>
            <div class="col-md-6 col-md-offset-3" style="padding-top:5px; margin-bottom:10px;"></div>
        @else
            <div class="negozio scritta hidden-xs col-sm-12 col-md-12 text-center abril shipping_sm" >
                <br><br>
                <span style="line-height:1.6em; font-size:20px;">THE CHESS STORE IN FLORENCE</span>
                <span style="font-size:16px">
                    <br>FOR EXTRA UE SHIPPINGS THE ITALIAN VAT WILL BE AUTOMATICALLY DEDUCED DURING THE PURCHASE
                </span>

            </div>
            <div class="col-md-6 col-md-offset-3" style="/*border-bottom:1px dotted #850728*/; padding-top:5px; margin-bottom:10px;"></div>
        @endif
    </nav>

</div>