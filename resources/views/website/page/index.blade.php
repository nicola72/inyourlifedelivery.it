@extends('layouts.website')
@section('content')

    <!--  immagine principale non presente su versione mobile     -->
    <div id="home"  class="foto-header-home">
        <div class="transparent-angle angle-top-right"></div>
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg8 mr-auto ml-auto pb50 pt120 ">
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
            @if($prodotti_omaggio->count() > 0 && $label_omaggio)
                <div class="row">
                    <div class="col-md-12 text-center">
                        <div class="promo">{{$label_omaggio->text}}</div>
                    </div>
                </div>
            @endif

            @if($minimo_ordine)
                <div class="row pb-2">
                    <div class="col-md-12 text-center">
                        <div class=""><b>Ordine minimo consentito @money($minimo_ordine->min)</b></div>
                    </div>
                </div>
            @endif

            @if($spese_consegna)
                <div class="row pb-2">
                    <div class="col-md-12 text-center">
                        <div class="">
                            <b>Per la consegna a domicilio è previsto un costo di @money($spese_consegna->cost)</b>
                            @if($spese_consegna->to != '')
                                <br><b>per ordini superiore a @money($spese_consegna->to) nessun costo</b>
                            @endif
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </section>
    <!--  -->

    <div id="main-page" class="col-md-12" style="background-color:#fff;">

        <!-- contenuto aggiornabile -->
        @include('website.page.partials.product_list')
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
                                <h6 class="text-center">PER IL PRANZO</h6>
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
                                <h6 class="text-center">PER LA CENA</h6>
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
                            <input class="tipo_ordinazione" id="radio_tipo_1" type="radio" name="tipo_ordinazione" value="domicilio" {{(old('tipo_ordinazione') == 'domicilio') ? 'checked':''}} /> <h6 class="d-inline">CONSEGNA A DOMICILIO</h6>
                        </div>
                        <div class="col-md-6 text-center">
                            <img src="/img/asporto.png" alt="" class="img-fluid" style="max-width:150px;"/><br/>
                            <input class="tipo_ordinazione" id="radio_tipo_2" type="radio" name="tipo_ordinazione" value="asporto" {{(old('tipo_ordinazione') == 'domicilio') ? '':'checked'}} /> <h6 class="d-inline">ASPORTO</h6>
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
                    <input type="text" id="nome" name="nome" class="form-control" value="{{old('nome')}}"  />
                </div>
                <div class="col-md-6 mb-3">
                    <label for="nome">Cognome*</label>
                    <input type="text" id="cognome" name="cognome" class="form-control" value="{{old('cognome')}}" />
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
                                <option value="{{$munic->id}}" {{(old('comune') == $munic->id) ? 'selected':''}}>{{$munic->comune}}</option>
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
                    <input type="text" id="tel" name="tel" class="form-control" value="{{old('tel')}}"  />
                </div>
                <div class="col-md-6 mb-3">
                    <label for="email">Email*</label>
                    <input type="email" id="email" name="email" class="form-control" value="{{old('email')}}" />
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
                    <input name="privacy" type="checkbox" id="privacy" value="Privacy" />&nbsp;&nbsp; <br>
                    <a style="color:#000" href="{{url('/informativa')}}" target="_blank">
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
                        @if($shop->deliveryPaypal || $shop->deliveryStripe)
                        <div class="col-md-6 text-center">
                            <input id="radio_pag_1" type="radio" name="tipo_pagamento" value="paypal" />
                            @if($shop->deliveryPaypal && $shop->deliveryStripe)
                                <h6 class="d-inline">PAYPAL O STRIPE</h6>
                            @elseif($shop->deliveryPaypal && !$shop->deliveryStripe)
                                <h6 class="d-inline">PAYPAL</h6>
                            @endif
                        </div>
                        @endif
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
                    <button id="submit_btn" onclick="checkForm();" class="btn btn-lg  btn-primary back-orange focacce w-100">
                        <span class="titolo-categoria">PROCEDI CON L'ORDINE</span>
                    </button>
                </div>

            </div>
        </div>

    </form>

    <div class="navbar-right-elements cart-fixed pull-right d-md-none">
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

        function checkForm()
        {
            event.preventDefault();

            var nome = $('#nome').val();
            var cognome = $('#cognome').val();
            var tel = $('#tel').val();
            var email = $('#email').val();
            var comune = $('#comune').val();
            var nr_civico = $('#nr_civico').val();
            var indirizzo = $('#indirizzo').val();
            var orario = $('#orario').val();

            if(orario === '')
            {
                alert('Attenzione! Non hai selezionato l\'orario di consegna');
                scroll_to('orario_ancor');
                return;
            }

            if(nome === '')
            {
                alert('Attenzione! Il nome è obbligatorio');
                $('#nome').focus();
                scroll_to('nome');
                return;
            }

            if(cognome === '')
            {
                alert('Attenzione! Il cognome è obbligatorio');
                $('#cognome').focus();
                scroll_to('cognome');
                return;
            }

            if(email === '')
            {
                alert('Attenzione! obbligatorio inserire un\'email valida');
                $('#email').focus();
                scroll_to('email');
                return;
            }

            if(tel === '')
            {
                alert('Attenzione! Il telefono è obbligatorio');
                $('#tel').focus();
                scroll_to('tel');
                return;
            }

            if( $('#radio_tipo_1').is(':checked') )
            {
                if(comune === '')
                {
                    alert('Attenzione! Per la consegna a domicilio è obbligatorio inserire il Comune');
                    $('#comune').focus();
                    scroll_to('comune');
                    return;
                }

                if(indirizzo === '')
                {
                    alert('Attenzione! Per la consegna a domicilio è obbligatorio inserire la Via/Piazza');
                    $('#indirizzo').focus();
                    scroll_to('indirizzo');
                    return;
                }

                if(nr_civico === '')
                {
                    alert('Attenzione! Per la consegna a domicilio è obbligatorio inserire il Numero Civico');
                    $('#nr_civico').focus();
                    scroll_to('nr_civico');
                    return;
                }
            }

            if(!$('#privacy').is(':checked'))
            {
                alert('Attenzione! E\' obbligatorio acconsentire al trattamento dei dati');
                $('#privacy').focus();
                scroll_to('privacy');
                return;
            }

            $('#form_ordinazione').submit();
        }

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