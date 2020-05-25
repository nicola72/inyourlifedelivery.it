<div class="row">
    <!-- menu categorie -->
    <div id="cat-list" class="col-md-3">
        @if($categories->count() > 0)
            @foreach($categories as $category)
                @if($category_selected->id == $category->id)
                    <div class="{{($category_selected->id == $category->id) ? 'active':''}} mb-2">
                        @if($category->cover($shop->id))
                            <a href="javascript:void(0)" class="btn btn-lg  img-categoria classiche-button" style="background-image:url('/file/big/{{$category->cover($shop->id)}}'); "></a>
                        @endif
                        <a href="javascript:void(0)" class="btn btn-lg  btn-primary  classiche-button btn-light w-100">
                            <span class="titolo-categoria">{{$category->nome_it}}</span>
                        </a>
                    </div>
                @else
                    <div class="{{($category_selected->id == $category->id) ? 'active':''}} mb-2">
                        @if($category->cover($shop->id))
                            <a href="javascript:void(0)" onclick="show_products('{{encrypt($category->id)}}')" class="btn btn-lg  img-categoria classiche-button" style="background-image:url('/file/big/{{$category->cover($shop->id)}}'); "></a>
                        @endif
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
                                        <div class="titolo-piatto">
                                            @if($product->novita)
                                                <span class="badge badge-primary">Novità</span>&nbsp;
                                            @endif
                                            {{$product->nome_it}}
                                        </div>
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
                                        <div class="col-md-12  testo-bottone  btn-light btn-aggiungi-carrello " >
                                            <a href="javascript:void(0)" onclick="addToCart({{$product->id}})" class="link-white">
                                                <i class="ti-shopping-cart"></i>
                                                <br/>AGGIUNGI AL CARRELLO
                                            </a>
                                        </div>
                                    </div>
                                    <!-- -->

                                    <!-- pulsante collapse x Ingredienti -->
                                    @if($product->ingredients->count() > 0)
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
                                    @endif
                                    <!-- -->



                                    <!-- pulsante collapse x Varianti -->
                                    @if($product->variants->count() > 0)
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
                                    @endif
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