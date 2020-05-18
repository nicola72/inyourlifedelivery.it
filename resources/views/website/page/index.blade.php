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
    <!--  fine barra di navigazione     -->

    <!--   sezione con gli step-->
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
    <!--    fine sezione con gli step    -->

    <div class="col-md-12" style="background-color:#fff;">
        <div class="row">
            <!-- menu categorie -->
            <div class="col-md-3">
                @php $count = 1 @endphp
                @if($categories->count() > 0)
                    @foreach($categories as $category)
                        <div class="{{($count == 1) ? 'active':''}}">
                            <a href="javascript:void(0)" onclick="show_products({{$category->id}})" class="btn btn-lg  img-categoria classiche-button" style="background-image:url('/file/big/{{$category->cover($shop->id)}}'); "></a>
                            <a href="javascript:void(0)" onclick="show_products({{$category->id}})" class="btn btn-lg  btn-primary  classiche-button btn-light w-100">
                                <span class="titolo-categoria">{{$category->nome_it}}</span>
                            </a>
                        </div>
                        @php $count++ @endphp
                    @endforeach
                @endif
            </div>
            <!-- fine menu categorie -->

            <!-- prodotti -->
            <div class="col-md-9 pt20">

                    <div class="col-md-12 text-center">
                        <h3>{{$categories->first()->nome_it}}</h3>
                        <hr>
                    </div>

                    @if($products->count() > 0)
                        @foreach($products as $product)
                        <div class="col-md-12 prodotto-bianco mb-4">
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
                                            <div class="col-md-8">

                                                <!-- nome prodotto -->
                                                <div class="titolo-piatto">{{$product->nome_it}}</div>
                                                <!-- -->

                                                <!-- descrizione prodotto -->
                                                <div class="descrizione-piatto">{{$product->desc_it}}</div>
                                                <!-- -->

                                                <!-- ingredienti aggiunti-->
                                                <div id="ingredienti-aggiunti" class="ingredienti ingredienti-aggiunti" style="display: none">
                                                    Ingredienti aggiunti:
                                                    <br/>
                                                    <div id="ingredienti-aggiunti-list">
                                                    </div>
                                                </div>
                                                <!-- -->

                                                <!-- prezzo -->
                                                <div class="prezzi">
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

                                    <div class="col-md-6 text-center mt-2">
                                        <div class="row" >

                                            <!-- pulsante modale varianti -->
                                            <div class="col-md-6 varianti text-center">
                                                <div class="col-sm-12 col-md-12 testo-bottone btn-light btn-aggiungi" >
                                                    <a data-toggle="collapse" href="#collapse2_{{$product->id}}" aria-expanded="false" aria-controls="collapse" style="font-size:90%;" >
                                                        SELEZIONA<br/>VARIANTE
                                                    </a>
                                                </div>
                                            </div>
                                            <!-- -->

                                            <!-- pulsante per Q.tà -->
                                            <div class="col-md-6 text-center align-items-center pt-3 pb-4">
                                                <div class="count-input " >

                                                        <a class="incr-btn" data-action="decrease" href="#"  ><strong>–</strong></a>
                                                        <input name="qty" class="quantity" type="text" value="1" style="text-align:center">
                                                        <a class="incr-btn" data-action="increase" href="#" ><strong>+</strong></a>

                                                </div>
                                            </div>
                                            <!-- -->

                                            <!-- pulsante Ingredienti -->
                                            <div class="col-6 col-md-6 text-center   pt-2 pb-2">
                                                <div class="col-sm-12 col-md-12 testo-bottone btn-light btn-aggiungi" >
                                                    <a data-toggle="collapse" href="#collapse_{{$product->id}}" aria-expanded="false" aria-controls="collapse" style="font-size:90%;">
                                                        <i class="ti-plus"></i><br/>GESTIONE INGREDIENTI
                                                    </a>
                                                </div>
                                            </div>
                                            <!-- -->

                                            <!-- pulsante Aggiungi al Carrello -->
                                            <div class="col-6 col-md-6 text-center pt-2 pb-2">
                                                <div class="col-md-12  testo-bottone  btn-light btn-aggiungi-carrello " >
                                                    <a href="javascript:void(0)" onclick="addToCart({{$product->id}})" class="link-white">
                                                        <i class="ti-shopping-cart"></i>
                                                        <br/>AGGIUNGI AL CARRELLO
                                                    </a>
                                                </div>
                                            </div>
                                            <!-- -->



                                        </div>
                                    </div>
                                </div>

                                <!-- collapse con le varianti -->
                                <div class="col-md-12">
                                    <div class="collapse" id="collapse2_{{$product->id}}">
                                        <div class="card card-body" style="color:#000;">

                                            <h4 class="text-center  pt-3 pb-3 mb-3">SCEGLI UNA VARIANTE</h4>
                                            <div class="row mb-3">

                                                @foreach($product->variants as $variant)
                                                    <div class="col-md-4">
                                                        <input type="radio" name="variante" value="{{$variant->id}}">
                                                        {{$variant->nome_it }}<strong> {{$variant->type}} @money($variant->prezzo)</strong><br/>
                                                    </div>
                                                @endforeach

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- fine collapse varianti -->

                                <!-- collapse con ingredienti -->
                                <div class="col-md-12">
                                    <div class="collapse" id="collapse_{{$product->id}}">
                                        <div class="card card-body" style="color:#000;">

                                            <h4 class="text-center  pt-3 pb-3 mb-3">SCEGLI GLI INGREDIENTI DA AGGIUNGERE O TOGLIERE</h4>
                                            <div class="row mb-3">

                                                <div class="col-md-4">

                                                    <!-- ingredienti da togliere -->
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
                                                    <!-- -->

                                                </div>
                                                <div class="col-md-8">

                                                    <!-- ingredienti da aggiungere -->
                                                    @if($product->ingredienti_da_aggiungere()->count() > 0)
                                                    <h4>oppure Aggiungi</h4>
                                                    <div class="row">
                                                        @foreach($product->ingredienti_da_aggiungere() as $ingredient)

                                                            <div class="col-md-4">
                                                                <input type="checkbox" name="ingredient_{{$ingredient->id}}" value="{{$ingredient->id}}">
                                                                {{$ingredient->nome_it}}
                                                                @if($ingredient->prezzo == '0.00')
                                                                    ( {{'gratis'}} )
                                                                @else
                                                                    ( @money($ingredient->prezzo) )
                                                                @endif
                                                                <br/>
                                                            </div>

                                                        @endforeach
                                                    </div>
                                                    @endif
                                                    <!-- -->

                                                </div>

                                            </div>
                                            <div class="col-md-6 m-auto text-center ">
                                                <a class="btn btn-light  text-center mt30 conferma" href="javascript:void(0)" >CONFERMA</a>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                            <!-- -->
                            </form>
                        </div>
                        @endforeach
                    @endif

                </div>
            </div>
            <!-- -->
        </div>
    </div>
@endsection
@section('js_script')
    <script>
        function addToCart(product_id)
        {
            $.ajax({
                type: "POST",
                url: "/add_to_cart",
                data: $('#form_product_'+ product_id).serialize(),
                dataType: "json",
                success: function (data){ alert(data.msg);},
                error: function (){ alert("Si è verificato un errore! Riprova!");}
            });
        }
    </script>
@stop