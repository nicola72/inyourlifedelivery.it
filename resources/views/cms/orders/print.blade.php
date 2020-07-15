<!DOCTYPE html>
<html lang="{{App::getLocale()}}">
<head>
    <title>{{$shop->insegna}}</title>
    <meta charset="utf-8">
    <meta name="Keywords" content="" />
    <meta name="Description" content="" />
    <meta name="language" content="it" />
    <meta http-equiv="Cache-control" content="public">
    <meta name="author" content="Designed by InYourLife- https://www.inyourlife.info" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="shortcut icon" href="/favicon.png">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Styles -->
    @section('styles')

        <link rel="stylesheet" href="/assets/css/print.css" >
        <link rel="stylesheet" href="/assets/css/style.css" >
    @show

    @stack('head')
</head>
<body onload="window.print()">
<div class="container-fluid">
    <div class="row" style="padding-top:60px;">
        <div class="col-md-12">
            <div>
                <h5 style="font-size:26px;">
                    Ordine n° {{$order->id}} &nbsp;&nbsp;
                    @if($order->tipo == 'asporto')
                        <button class="btn btn-sm btn-default text-uppercase">{{$order->tipo}}</button>
                    @else
                        <button class="btn btn-sm btn-default text-uppercase">{{$order->tipo}}</button>
                    @endif

                </h5>
            </div>
            <div>
                <div class="row">
                    <div class="col-md-6 mb-2" style="font-size:20px;">
                        <b>Orario</b>: {{substr($order->orario, 0, -3)}}
                    </div>
                    <div class="col-md-6 mb-2" style="font-size:20px;">
                        <b>Data</b>: {{$order->created_at->format('d/m/Y')}}
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-2" style="font-size:20px;">
                        <b>Cliente</b>: {{$order->nome}} {{$order->cognome}}
                    </div>

                </div>
                <div class="row">
                    <div class="col-md-6 mb-2" style="font-size:20px;">
                        <b>Tel.</b>: {{$order->telefono}}
                    </div>
                    <div class="col-md-6 mb-2" style="font-size:20px;">
                        <b>Email</b>: {{$order->email}}
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-12">
                        <table class="table" style="font-size:20px;">
                            <tr>
                                <th>prodotto</th>
                                <th>senza</th>
                                <th>con</th>
                                <th>variante</th>
                                <th>prezzo</th>
                            </tr>
                            @foreach($order->orderDetails as $item)
                                <tr>
                                    <td>{{$item->qta}} x {{$item->nome_prodotto}}</td>
                                    <td>{{$item->ingredienti_eliminati}}</td>
                                    <td>{{$item->ingredienti_aggiunti}}</td>
                                    <td>{{$item->variante}}</td>
                                    <td>@money($item->prezzo)</td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
                @if($order->orderShipping)
                    <div class="row mt-3">
                        <div class="col-md-12" style="font-size:26px;">
                            <b>Indirizzo di consegna</b><br><br>
                            {{$order->orderShipping->indirizzo}}, {{$order->orderShipping->nr_civico}} {{$order->orderShipping->comune}}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@section('scripts')

    <!-- jQuery first, then Tether, then Bootstrap JS. -->
    <script src="/assets/js/plugins/plugins.js"></script>
    <script src="/assets/js/assan.custom.js"></script>

    <!-- JAVASCRIPT -->
    <script type="text/javascript" src="/assets/js/website.js"></script>
    <!-- -->

@show

@yield('js_script')
@yield('js_script_form')
@yield('js_flash')
@stack('body')
</body>
</html>
