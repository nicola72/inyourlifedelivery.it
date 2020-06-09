<!-- Menù carrello a destra -->
<ul class="list-unstyled">
    @if($carts->count() > 0)
        @foreach($carts as $cart)
            <li class="clearfix">
                <a href="{{url('/cart')}}" class="float-left">
                    <img src="/file/small/{{$cart->product->cover($shop->id)}}" class="img-fluid" alt="" width="60">
                </a>
                <div class="oHidden">

                    <!-- elimina dal carrello -->
                    <span class="close">
                        <a href="javascript:void(0)" onclick="remove_from_cart('{{encrypt($cart->id)}}',false)"><i class="ti-close"></i></a>
                    </span>
                    <!-- -->

                    <h4 style="color:#fff">{{$cart->nome_prodotto}}</h4>

                    @if($cart->variante != '')
                        <p>
                            {{$cart->variante}}
                        </p>
                    @endif

                    @if($cart->ingredienti_eliminati != '')
                        <p>
                            eliminati:<br/>
                            {{$cart->ingredienti_eliminati}}
                        </p>
                    @endif

                    @if($cart->ingredienti_aggiunti != '')
                        <p>
                            aggiunti:<br/>
                            {{$cart->ingredienti_aggiunti}}
                        </p>
                    @endif

                    <p class="text-white-gray">
                        <strong>@money($cart->prezzo)</strong> x {{$cart->qta}}
                    </p>
                </div>
            </li>
        @endforeach
        <li class="clearfix">
            <!--<div class="float-right">
                <a href="#orario_ancor" class="pushy-link btn btn-primary" style="color:#000;position: relative">Procedi</a>
            </div>-->
            <h4  class="text-white">
                <small>Totale: </small> @money($carts->sum('totale'))
            </h4>
        </li>
    @endif

</ul>
<!-- fine -->
