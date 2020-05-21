@extends('layouts.website')
@section('content')
    <div id="main-page" class="col-md-12" style="background-color:#fff;padding-top:140px;">
        <div class="container">
            <div class="row" style="min-height: 460px">
                <div class="col-md-12">
                    <h4>
                        Grazie {{$order->nome}}<br>
                        Abbiamo preso in carico la tua ordinazione!
                    </h4>
                    <br>
                    <h5>

                        Ti abbiamo inviato un'email con il riepilogo dell'ordinazione.<br>
                        @if($order->tipo == 'domicilio')
                            La consegna è prevista per le {{$order->orario}}
                            <br>
                            al seguente indirizzo:
                            <br>
                            {{$order->orderShipping->indirizzo}}, {{$order->orderShipping->nr_civico}} {{$order->orderShipping->comune}}
                        @else
                            Il ritiro è previsto per le {{$order->orario}}
                        @endif
                        <br>
                        <br>
                        <br>
                        <a class="testo-bottone btn btn-light btn-aggiungi pb-2 pt-2 pr-4 pl-4" href="/">Torna allo shop</a>
                    </h5>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js_script')
    <script>

    </script>
@stop