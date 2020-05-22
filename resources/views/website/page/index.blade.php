@extends('layouts.website')
@section('content')

    <!--  immagine principale non presente su versione mobile     -->
    <div id="home"  class="foto-header-home">
        <div class="transparent-angle angle-top-right"></div>
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg8 mr-auto ml-auto pb50 pt200 ">
                    <h3 class="h1 text-white text-shadow text-center">ORDINA IN TRE SEMPLICI STEP<br/>I TUOI PIATTI PREFERITI</h3>
                </div>
            </div>
        </div>
    </div><!--hero-->
    <!-- fine barra di navigazione -->

    <!-- titolo step 1 -->
    <a name="ordina"></a>
    <section id='reviews' class='pt60 '  style="background-color:#ececec;">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb10 m-auto wow zoomInDown" data-wow-delay=".1s">
                    <div class="client-reviews-card-active uno">
                        <div class="client-reviews-author ">
                            <h4 class="text-center active-step">Scegli quello che vuoi</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--  -->

    <div id="main-page" class="col-md-12" style="background-color:#fff;">
        <div class="row">
            <!-- menu categorie -->
            <div id="cat-list" class="col-md-3">
                @if($categories->count() > 0)
                    @foreach($categories as $category)
                        @if($category_selected->id == $category->id)
                            <div class="{{($category_selected->id == $category->id) ? 'active':''}} mb-2">
                                <a href="javascript:void(0)" class="btn btn-lg  img-categoria classiche-button" style="background-image:url('/file/big/{{$category->cover($shop->id)}}'); "></a>
                                <a href="javascript:void(0)" class="btn btn-lg  btn-primary  classiche-button btn-light w-100">
                                    <span class="titolo-categoria">{{$category->nome_it}}</span>
                                </a>
                            </div>
                        @else
                            <div class="{{($category_selected->id == $category->id) ? 'active':''}} mb-2">
                                <a href="javascript:void(0)" onclick="show_products('{{encrypt($category->id)}}')" class="btn btn-lg  img-categoria classiche-button" style="background-image:url('/file/big/{{$category->cover($shop->id)}}'); "></a>
                                <a href="javascript:void(0)" onclick="show_products('{{encrypt($category->id)}}')" class="btn btn-lg  btn-primary  classiche-button btn-light w-100">
                                    <span class="titolo-categoria">{{$category->nome_it}}</span>
                                </a>
                            </div>
                        @endif

                    @endforeach
                @endif
            </div>
            <!-- fine menu categorie -->

            <!-- PRODOTTI -->
            <div class="col-md-9 pt20">

                <div class="col-md-12 text-center">
                    <h3>{{$category_selected->nome_it}}</h3>
                    <hr>
                </div>

                @if($products->count() > 0)
                    @foreach($products as $product)
                    <div id="box_prod_{{$product->id}}" class="col-md-12 prodotto-bianco mb-4">
                        <!-- PRODOTTO -->
                        <form id="form_product_{{$product->id}}" action="" method="post">
                            {{ csrf_field() }}
                            <input type="hidden" name="product_id" id="product_id" value="{{encrypt($product->id)}}" />
                            <input type="hidden" name="shop_id" id="shop_id" value="{{encrypt($shop->id)}}" />
                            <div class="product-item row">

                                <div class="col-md-6">
                                    <div class="row">

                                        <!-- foto prodotto -->
                                        <div class="col-md-4">
                                            <img src="/file/small/{{$product->cover($shop->id)}}" alt="" class="img-fluid img-prodotto" />
                                        </div>
                                        <!-- -->

                                        <!-- dati prodotto -->
                                        <div class="col-md-8 text-center text-sm-left">

                                            <!-- nome prodotto -->
                                            <div class="titolo-piatto">{{$product->nome_it}}</div>
                                            <!-- -->

                                            <!-- descrizione prodotto -->
                                            <div class="descrizione-piatto pb-2">{{$product->desc_it}}</div>
                                            <!-- -->

                                            <!-- variante -->
                                            <div class="customizzazioni" id="variante_{{$product->id}}"></div>

                                            <!-- ingredienti eliminati -->
                                            <div class="customizzazioni" id="eliminati_{{$product->id}}"></div>

                                            <!-- ingredienti aggiunti -->
                                            <div class="customizzazioni" id="aggiunti_{{$product->id}}"></div>

                                            <!-- prezzo -->
                                            <div id="prezzo_{{$product->id}}" class="prezzi">
                                                @if($product->prezzo_scontato != '0.00')
                                                    Prezzo: <span style="text-decoration: line-through;">@money($product->prezzo)</span>
                                                    <strong>@money($product->prezzo_scontato)</strong>
                                                @else
                                                    Prezzo: <strong>@money($product->prezzo)</strong>
                                                @endif
                                            </div>
                                            <!-- -->
                                        </div>
                                        <!-- -->
                                    </div>
                                </div>

                                <div class="col-md-6 text-center">
                                    <div class="row" >

                                        <!-- pulsante per Q.tà -->
                                        <div class="col-md-6 text-center align-items-center pt-3 pb-4">
                                            <div class="count-input " >
                                                <a class="incr-btn" onclick="decrese({{$product->id}})" data-action="decrease" href="javascript:void(0)"  ><strong>–</strong></a>
                                                <input id="qty_{{$product->id}}" name="qty" class="quantity" type="text" value="1" style="text-align:center">
                                                <a class="incr-btn" onclick="increse({{$product->id}})" data-action="increase" href="javascript:void(0)" ><strong>+</strong></a>
                                            </div>
                                        </div>
                                        <!-- -->

                                        <!-- pulsante Aggiungi al Carrello -->
                                        <div class="col-md-6 text-center pt-2 pb-2">
                                            <a href="javascript:void(0)" onclick="addToCart({{$product->id}})" class="link-white">
                                                <div class="col-md-12  testo-bottone  btn-light btn-aggiungi-carrello " >
                                                    <i class="ti-shopping-cart"></i>
                                                    <br/>AGGIUNGI AL CARRELLO
                                                </div>
                                            </a>
                                        </div>
                                        <!-- -->

                                        <!-- pulsante collapse x Ingredienti -->
                                        <div class="col-6 col-md-6 text-center ">
                                            <div class="col-sm-12 col-md-12 testo-bottone btn-light btn-aggiungi" >
                                                <a data-toggle="collapse"
                                                   href="#collapse_{{$product->id}}"
                                                   onclick="$('#collapse2_{{$product->id}}').collapse('hide')"
                                                   aria-expanded="false"
                                                   aria-controls="collapse"
                                                   style="font-size:90%;">
                                                    GESTIONE<br/> INGREDIENTI
                                                </a>
                                            </div>
                                        </div>
                                        <!-- -->



                                        <!-- pulsante collapse x Varianti -->
                                        <div class="col-6 col-md-6 text-center">
                                            <div class="col-sm-12 col-md-12 testo-bottone btn-light btn-aggiungi" >
                                                <a data-toggle="collapse"
                                                   href="#collapse2_{{$product->id}}"
                                                   onclick="$('#collapse_{{$product->id}}').collapse('hide')"
                                                   aria-expanded="false"
                                                   aria-controls="collapse"
                                                   style="font-size:90%;" >
                                                    SELEZIONA<br/>VARIANTE
                                                </a>
                                            </div>
                                        </div>
                                        <!-- -->

                                    </div>
                                </div>
                            </div>

                            <div id="accordion_{{$product->id}}">

                                <!-- collapse con le varianti -->
                                <div class="col-md-12">
                                    <div class="collapse" id="collapse2_{{$product->id}}">
                                        <div class="card card-body" style="color:#000;">

                                            <h4 class="text-center  pt-1 pb-2">SCEGLI UNA VARIANTE</h4>
                                            <div class="row mb-3">
                                                <div class="col-md-4">
                                                    <input type="radio" name="variante" value="" checked>
                                                    Normale<br/>
                                                </div>
                                                @foreach($product->variants as $variant)
                                                    <div class="col-md-4">
                                                        <input type="radio" name="variante" value="{{$variant->id}}">
                                                        {{$variant->nome_it }}<strong> {{$variant->type}} @money($variant->prezzo)</strong><br/>
                                                    </div>
                                                @endforeach

                                            </div>
                                            <div class="col-md-6 m-auto text-center ">
                                                <a class="btn btn-light  text-center mt30 conferma" href="javascript:void(0)" onclick="aggiorna_prezzo({{$product->id}})">CONFERMA</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- fine collapse varianti -->

                                <!-- collapse con ingredienti -->
                                <div class="col-md-12">
                                    <div class="collapse" id="collapse_{{$product->id}}">
                                        <div class="card card-body" style="color:#000;">

                                            <h4 class="text-center  pt-1 pb-2">SCEGLI GLI INGREDIENTI DA AGGIUNGERE O TOGLIERE</h4>
                                            <div class="row mb-3">

                                                <!-- ingredienti da togliere -->
                                                <div class="col-md-4 pt-3 pb-3">
                                                    @if($product->ingredients->count() > 0)
                                                        <h4>Togli l'ingrediente</h4>
                                                        <div class="row">
                                                            @foreach($product->ingredients as $ing)

                                                                <div class="col-md-12">
                                                                    <input type="checkbox" name="ingredient_{{$ing->id}}" value="{{$ing->id}}" checked>
                                                                    {{$ing->nome_it}}<br/>
                                                                </div>

                                                            @endforeach
                                                        </div>
                                                    @endif
                                                </div>
                                                <!-- -->

                                                <!-- ingredienti da aggiungere -->
                                                <div class="col-md-8 pt-3 pb-3" style="background-color:#ddd">
                                                    @if($product->ingredienti_da_aggiungere()->count() > 0)
                                                        <h4>oppure Aggiungi</h4>
                                                        <div class="row">
                                                            @foreach($product->ingredienti_da_aggiungere() as $ingredient)

                                                                <div class="col-md-4">
                                                                    <input type="checkbox" name="ingredient_{{$ingredient->id}}" value="{{$ingredient->id}}">
                                                                    {{$ingredient->nome_it}}
                                                                    @if($ingredient->prezzo == '0.00')
                                                                        ({{'gratis'}})
                                                                    @else
                                                                        (@money($ingredient->prezzo))
                                                                    @endif
                                                                    <br/>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    @endif
                                                </div>
                                                <!-- -->

                                            </div>
                                            <div class="col-md-6 m-auto text-center ">
                                                <a class="btn btn-light  text-center mt30 conferma" href="javascript:void(0)" onclick="aggiorna_prezzo({{$product->id}})" >CONFERMA</a>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <!-- fine collapse con ingredienti -->
                            </div>


                        </form>
                    </div>
                    @endforeach
                @endif

            </div>
        </div>
        <!-- -->
    </div>

    <a id="orario_ancor" name="orario"></a>

    <section id='reviews' class='pt60 '  style="background-color:#ececec;">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 m-auto mb10 wow zoomInDown " data-wow-delay=".15s">
                    <div class="client-reviews-card-active due">

                        <div class="client-reviews-author">
                            <h4 class="text-center active-step">
                                Scegli l'orario di consegna
                            </h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <form id="form_ordinazione" method="post" action="{{url('/cart_resume')}}" >
        {{ csrf_field() }}
        <input type="hidden" name="orario" id="orario" value="{{old('orario')}}" />
        <div id="main-page" class="col-md-12" style="background-color:#fff;">

        @if(!$aperto_il_giorno && !$aperto_la_sera)
            <div class="row pb50 pt50">
                <div class="col-md-12 text-center">
                    La nostra attività oggi è chiusa...<br>
                    Non possiamo accettare ordinazioni<br>
                    Torna presto a trovarci.
                </div>
            </div>
        @elseif(!$possibile_ordinare_il_giorno && !$possibile_ordinare_la_sera)
            <div class="row pb50 pt50">
                <div class="col-md-12 text-center">
                    Spiacente...<br>
                    In questo orario non possiamo più accettare ordinazioni.<br>
                    Torna presto a trovarci.
                </div>
            </div>
        @else
            <div class="row">
                @if($possibile_ordinare_il_giorno && $aperto_il_giorno)
                    <div class="col-md-12 pt20">
                        <div class="form-group row">
                            <div class="col-sm-4 col-md-2 m-auto">
                                <h6 class="text-center">PER IL GIORNO</h6>
                                <div class="input-group input-append">
                                    <input id="timepicker1" name="orario_mattina" type="text" class="form-control pickers" placeholder="Scegli">
                                    <span class="input-group-prepend last add-on">
                                        <span class="input-group-text">
                                            <i class="icon-clock"></i>
                                        </span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

            </div>

            <div class="row pb-2">
                @if($possibile_ordinare_la_sera && $aperto_la_sera)
                    <div class="col-md-12 pt20">
                        <div class="form-group row">
                            <div class="col-sm-4 col-md-2 m-auto">
                                <h6 class="text-center">PER LA SERA</h6>
                                <div class="input-group input-append">
                                    <input id="timepicker2" name="orario_sera" type="text" class="form-control pickers" placeholder="Scegli" >
                                    <span class="input-group-prepend last add-on">
                                        <span class="input-group-text">
                                            <i class="icon-clock"></i>
                                        </span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

            </div>
        @endif

        <!-- -->
        </div>

        <a name="ordina"></a>

        <section id='reviews' class='pt60 '  style="background-color:#ececec;">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 mb10 wow zoomInDown  m-auto" data-wow-delay=".15s">
                        <div class="client-reviews-card-active tre">
                            <div class="client-reviews-author">
                                <h4 class="text-center next-step" style="color:#000;">Scegli il tipo di consegna</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <a name="consegna"></a>
        <div class="col-md-12 mb-5">
            <div class="row">
                <div class="container mt-3 mb-2">
                    <div class="row">
                        <div class="col-md-6 text-center">
                            <img src="/img/consegna.png" alt="" class="img-fluid"  style="max-width:150px;"/><br/>
                            <input class="tipo_ordinazione" id="radio_tipo_1" type="radio" name="tipo_ordinazione" value="domicilio" /> <h6 class="d-inline">CONSEGNA A DOMICILIO</h6>
                        </div>
                        <div class="col-md-6 text-center">
                            <img src="/img/asporto.png" alt="" class="img-fluid" style="max-width:150px;"/><br/>
                            <input class="tipo_ordinazione" id="radio_tipo_2" type="radio" name="tipo_ordinazione" value="asporto" checked /> <h6 class="d-inline">ASPORTO</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <section id='reviews' class='pt60'  style="background-color:#ececec;">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 mb10 wow zoomInDown  m-auto" data-wow-delay=".15s">
                        <div class="client-reviews-card-active quattro">
                            <div class="client-reviews-author">
                                <h4 class="text-center next-step" style="color:#000;">Inserisci i tuoi dati</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <div class="container mt-3 mb-3">
            <div class="row mb-3">
                <div class="col-md-6 mb-3">
                    <label for="nome">Nome*</label>
                    <input type="text" id="nome" name="nome" class="form-control" value="{{old('nome')}}" required />
                </div>
                <div class="col-md-6 mb-3">
                    <label for="nome">Cognome*</label>
                    <input type="text" id="cognome" name="cognome" class="form-control" value="{{old('cognome')}}" required />
                </div>
            </div>
            <div id="indirizzo_consegna" class="p-3 border" style="display: none">
                <div class="row mb-3">
                    <div class="col-md-12"><h4>Indirizzo di consegna</h4></div>
                    <div class="col-md-6">
                        <label for="comune">Comune*</label>
                        <select name="comune" id="comune" class="form-control">
                            <option value="">seleziona</option>
                            @foreach($shop->deliveryMunics as $munic)
                                <option value="{{$munic->id}}">{{$munic->comune}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-8 mb-3">
                        <label for="indirizzo">Via/Piazza*</label>
                        <input type="text" id="indirizzo" name="indirizzo" class="form-control" value="{{old('indirizzo')}}" />
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="nome">N°Civ.*</label>
                        <input type="text" id="nr_civico" name="nr_civico" class="form-control" value="{{old('nr_civico')}}" />
                    </div>
                </div>
            </div>
            <div class="row mb-3 mt-3">
                <div class="col-md-6 mb-3">
                    <label for="tel">Telefono*</label>
                    <input type="text" id="tel" name="tel" class="form-control" value="{{old('tel')}}" required />
                </div>
                <div class="col-md-6 mb-3">
                    <label for="email">Email*</label>
                    <input type="email" id="email" name="email" class="form-control" value="{{old('email')}}" required />
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-12">
                    <em>
                        Importante: Inserisci un numero di telefono valido al quale poter essere contattato per eventuali verifiche sulla tua prenotazione/ordinazione.
                        <br>
                        In mancanza di un numero valido la tua prenotazione verra' annullata.
                    </em>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-12">
                    <label for="note">Note</label>
                    <textarea class="form-control" name="note" id="note">{{old('note')}}</textarea>
                </div>
            </div>
            <div class="row mb-3">
                <!-- per il CAPTCHA -->
                <div class="col-md-12">
                    <div>
                        <div class="g-recaptcha" data-sitekey="{{$website_config['recaptcha_key']}}"></div>
                    </div>
                </div>
                <!-- fine CAPTCHA -->
                <div class="col-md-12">
                    Privacy* @lang('msg.consenso')
                    <input name="privacy" type="checkbox" id="privacy" value="Privacy" required />&nbsp;&nbsp; <br>
                    <a style="color:#000" href="{{url('/informativa')}}" >
                        @lang('msg.leggi_informativa')
                    </a>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-12"><span style="color:#000">* obbligatorio</span></div>
            </div>
        </div>


        <section id='reviews' class='pt60 '  style="background-color:#ececec;">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 mb10 wow zoomInDown  m-auto" data-wow-delay=".15s">
                        <div class="client-reviews-card-active cinque">
                            <div class="client-reviews-author">
                                <h4 class="text-center next-step" style="color:#000;">Scegli il tipo di pagamento</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <a name="tipo_pagamento"></a>
        <div class="col-md-12 mb-5">
            <div class="row">
                <div class="container mt-3 mb-2">
                    <div class="row">
                        <div class="col-md-6 text-center">
                            <input id="radio_pag_1" type="radio" name="tipo_pagamento" value="paypal" />
                            <h6 class="d-inline">PAYPAL</h6>
                        </div>
                        <div class="col-md-6 text-center">
                            <input id="radio_pag_2" type="radio" name="tipo_pagamento" value="alla_consegna" checked />
                            <h6 class="d-inline">ALLA CONSEGNA/RITIRO</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container mb-5">
            <div class="row">
                <div class="col-md-12">
                    <button id="submit_btn" type="submit" class="btn btn-lg  btn-primary back-orange focacce w-100">
                        <span class="titolo-categoria">PROCEDI CON L'ORDINE</span>
                    </button>
                </div>

            </div>
        </div>
    </form>

    <div class="navbar-right-elements cart-fixed pull-right">
        <ul class="list-inline">
            <li class="list-inline-item">
                <a href="javascript:void(0)" class=" menu-btn ">
                    <i class="ti-shopping-cart"  style="font-weight:bold; font-size:200%; text-shadow:1px 1px 10px;"></i>
                    <span id="cart_count2" class="badge badge-default" style="color:#000;:">{{$carts->sum('qta')}}</span>
                </a>
            </li>
        </ul>
    </div>

@endsection
@section('js_script')
    <script>

        function increse(product_id)
        {
            let input = $('#qty_'+product_id);
            let qty = input.val();
            input.val( parseInt(qty)+1);

        }

        function decrese(product_id)
        {
            let input = $('#qty_'+product_id);

            let qty = input.val();
            if(parseInt(qty) === 1)
            {
                return;
            }
            input.val( parseInt(qty)-1);

        }

        $("#radio_tipo_1").click( function()
        {
            if( $(this).is(':checked') ){
                $('#indirizzo_consegna').fadeIn();
            }
        });

        $("#radio_tipo_2").click( function()
        {
            if( $(this).is(':checked') ){
                $('#indirizzo_consegna').fadeOut();
            }
        });

        function aggiorna_prezzo(product_id)
        {
            showPreloader();
            $.ajax({
                type: "POST",
                url: "/update_price",
                data: $('#form_product_'+ product_id).serialize(),
                dataType: "json",
                success: function (data){
                        if(data.result === 1)
                        {
                            $('#collapse2_'+ product_id).collapse('hide');
                            $('#collapse_'+ product_id).collapse('hide');
                            $('#prezzo_'+ product_id).html(data.prezzo);
                            $('#variante_'+product_id).html(data.variante);
                            $('#eliminati_'+product_id).html(data.ingredienti_eliminati);
                            $('#aggiunti_'+product_id).html(data.ingredienti_aggiunti);
                            $('#alert-modal-msg').html(data.msg);
                            hidePreloader();
                            $("#alert_modal").modal();
                            scroll_to('box_prod_'+ product_id);
                        }
                        else
                        {
                            hidePreloader();
                            alert(data.msg);
                        }

                    },
                error: function (){
                    hidePreloader();
                    alert("Si è verificato un errore! Riprova!");
                }
            });
        }

        function addToCart(product_id)
        {
            showPreloader();
            $.ajax({
                type: "POST",
                url: "/add_to_cart",
                data: $('#form_product_'+ product_id).serialize(),
                dataType: "json",
                success: function (data){
                        $('#cart-menu-list').html(data.cart);
                        $('#cart_count').html(data.cart_count);
                        $('#cart_count2').html(data.cart_count);
                        $('#alert-modal-msg').html(data.msg);
                        $('#btn-procedi').addClass('d-block');
                        hidePreloader();
                        $("#alert_modal").modal();
                    },
                error: function (){
                    hidePreloader();
                    alert("Si è verificato un errore! Riprova!");
                }
            });
        }

        function scroll_to(id) {
            $('html,body').animate({
                scrollTop: $('#'+id).offset().top
            },'slow');
        }

        $(document).ready(function(){
            $('#timepicker1').timepicker({
                timeFormat: 'HH:mm',
                interval:'{{$shop->deliveryStep->step}}',
                minTime: '{{$orario_partenza_giorno}}',
                maxTime: '{{$shop->deliveryHour->end_morning}}',
                change: function(time) {
                    var element = $(this);
                    var timepicker = element.timepicker();
                    $('#orario').val(timepicker.format(time));
                }
            });
        });

        $(document).ready(function(){
            $('#timepicker2').timepicker({
                timeFormat: 'HH:mm',
                interval:'{{$shop->deliveryStep->step}}',
                minTime: '{{$orario_partenza_sera}}',
                maxTime: '{{$shop->deliveryHour->end_afternoon}}',
                change: function(time) {
                    var element = $(this);
                    var timepicker = element.timepicker();
                    $('#orario').val(timepicker.format(time));
                }
            });
        });

        $(document).ready(function(){
            $('.pickers').change(function(){
                alert('prego selezionare il valore dal menù a tendina');
            });
        });

        $(document).ready(function(){
            if( $('#radio_tipo_1').is(':checked') ){
                $('#indirizzo_consegna').fadeIn();
            }
        });

        function validateHhMm(inputField)
        {
            var isValid = /^([0-9]|0[0-9]|1[0-9]|2[0-3]):[0-5][0-9]$/.test(inputField.value);

            return isValid;
        }
    </script>
@stop