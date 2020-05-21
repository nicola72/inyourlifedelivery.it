@extends('layouts.website')
@section('content')
    <div id="main-page" class="col-md-12" style="background-color:#fff;padding-top:140px;">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-lg-10 m-auto">
                    <div id="cart-list">
                        <h4 class="text-uppercase mb-4">Riepilo prodotti ordinati</h4>
                        @foreach($carts as $cart)
                            <div class="row cart-item mb-2 pb-1">
                                <div class="col-sm-1">
                                    <a href="javascript:void(0)" title="elimina" onclick="remove_from_cart('{{encrypt($cart->id)}}',1)"><i class="fa fa-trash"></i></a>
                                </div>
                                <div class="col-sm-7">
                                    <h6 class="text-uppercase">{{$cart->nome_prodotto}}</h6>
                                    @if($cart->variante != '')
                                        {{$cart->variante}}<br>
                                    @endif

                                    @if($cart->ingredienti_eliminati != '')
                                        Senza {{$cart->ingredienti_eliminati}}<br/>
                                    @endif

                                    @if($cart->ingredienti_aggiunti != '')
                                        Con {{$cart->ingredienti_aggiunti}}<br/>
                                    @endif
                                </div>
                                <div class="col-sm-2">
                                    <strong>@money($cart->prezzo)</strong> x {{$cart->qta}}
                                </div>
                                <div class="col-sm-2 text-right">
                                    <strong>@money($cart->totale)</strong>
                                </div>
                            </div>
                        @endforeach
                        <div class="row mt-2 mb-2">
                            <div class="col-md-12 text-right">
                                <h4>Tot.: @money($carts->sum('totale'))</h4>
                            </div>
                        </div>
                    </div>
                    <div id="user-details mt-2">
                        <h4 class="text-uppercase mb-4">Tipo di consegna: {{$tipo_ordinazione}}</h4>
                    </div>
                    <div id="user-details mt-5">
                        <h4 class="text-uppercase mb-4">Alle ore {{$orario_html}}</h4>
                    </div>
                    <div id="user-details mt-5">
                        <h4 class="text-uppercase mb-4">I tuoi dati</h4>
                        <div class="row cart-item mb-2 pb-1">
                            <div class="col-sm-6">
                                <h6 class="text-uppercase">Nome:</h6>
                            </div>
                            <div class="col-md-6 text-right">
                                {{$nome}}
                            </div>
                        </div>
                        <div class="row cart-item mb-2 pb-1">
                            <div class="col-md-6">
                                <h6 class="text-uppercase">Cognome:</h6>
                            </div>
                            <div class="col-md-6 text-right">
                                {{$cognome}}
                            </div>
                        </div>
                        <div class="row cart-item mb-2 pb-1">
                            <div class="col-md-6">
                                <h6 class="text-uppercase">Email:</h6>
                            </div>
                            <div class="col-md-6 text-right">
                                {{$email}}
                            </div>
                        </div>
                        <div class="row cart-item mb-2 pb-1">
                            <div class="col-md-6">
                                <h6 class="text-uppercase">Telefono:</h6>
                            </div>
                            <div class="col-md-6 text-right">
                                {{$tel}}
                            </div>
                        </div>
                        <div class="row cart-item mb-2 pb-1">
                            <div class="col-md-6">
                                <h6 class="text-uppercase">Note:</h6>
                            </div>
                            <div class="col-md-6 text-right">
                                {{$note}}
                            </div>
                        </div>
                    </div>
                    @if($tipo_ordinazione == 'domicilio')
                    <div id="indirizzo" class="mt-5">
                        <h4 class="text-uppercase mb-4">Indirizzo di consegna</h4>
                        <div class="row cart-item mb-2 pb-1">
                            <div class="col-md-6">
                                <h6 class="text-uppercase">Comune:</h6>
                            </div>
                            <div class="col-md-6 text-right">
                                {{$comune->comune}}
                            </div>
                        </div>
                        <div class="row cart-item mb-2 pb-1">
                            <div class="col-md-6">
                                <h6 class="text-uppercase">Via/piazza:</h6>
                            </div>
                            <div class="col-md-6 text-right">
                                {{$indirizzo}}
                            </div>
                        </div>
                        <div class="row cart-item mb-2 pb-1">
                            <div class="col-md-6">
                                <h6 class="text-uppercase">N°civico:</h6>
                            </div>
                            <div class="col-md-6 text-right">
                                {{$nr_civico}}
                            </div>
                        </div>
                    </div>
                    @endif
                    <div id="pagamento" class="mt-5">
                        <div class="row pt-2 pb-2 mb-5">
                            <div class="col-md-6">
                                <a href="/" class="btn testo-bottone btn-light btn-aggiungi w-100" >Modifica</a>
                            </div>
                            <div class="col-md-6">
                                <form id="form_checkout" method="post" action="{{($tipo_pagamento == 'paypal') ? '/checkout_paypal':'checkout'}}" >
                                    {{ csrf_field() }}
                                    <input type="hidden" name="shop_id" value="{{encrypt($shop->id)}}" />
                                    <input type="hidden" name="nome" value="{{$nome}}" />
                                    <input type="hidden" name="cognome" value="{{$cognome}}" />
                                    @if($comune)
                                        <input type="hidden" name="comune" value="{{$comune->id}}" />
                                    @else
                                        <input type="hidden" name="comune" value="" />
                                    @endif

                                    <input type="hidden" name="indirizzo" value="{{$indirizzo}}" />
                                    <input type="hidden" name="nr_civico" value="{{$nr_civico}}" />
                                    <input type="hidden" name="tel" value="{{$tel}}" />
                                    <input type="hidden" name="email" value="{{$email}}" />
                                    <input type="hidden" name="orario" value="{{$orario}}" />
                                    <input type="hidden" name="tipo_ordinazione" value="{{$tipo_ordinazione}}" />
                                    <input type="hidden" name="note" value="{{$note}}" />
                                    <button type="submit" class="link-white testo-bottone btn btn-light btn-aggiungi w-100" style="background-color: red;color:#fff;">
                                        {{($tipo_pagamento == 'paypal') ? 'Conferma e vai su Paypal':'Conferma ordine'}}
                                    </button>
                                </form>
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