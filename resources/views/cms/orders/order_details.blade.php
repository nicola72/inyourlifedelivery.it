<div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h5 class="modal-title">
                Ordine n° {{$order->id}}
                @if($order->tipo == 'asporto')
                    <button class="btn btn-sm btn-primary text-uppercase">{{$order->tipo}}</button>
                @else
                    <button class="btn btn-sm btn-danger text-uppercase">{{$order->tipo}}</button>
                @endif

            </h5>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-6 mb-2">
                    <b>Orario</b>: {{substr($order->orario, 0, -3)}}
                </div>
                <div class="col-md-6 mb-2">
                    <b>Data</b>: {{$order->created_at->format('d/m/Y')}}
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-2">
                    <b>Cliente</b>: {{$order->nome}} {{$order->cognome}}
                </div>

            </div>
            <div class="row">
                <div class="col-md-6 mb-2">
                    <b>Tel.</b>: {{$order->telefono}}
                </div>
                <div class="col-md-6 mb-2">
                    <b>Email</b>: {{$order->email}}
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-md-12">
                    <table class="table">
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
                <div class="col-md-12">
                    <b>Indirizzo di consegna</b><br>
                    {{$order->orderShipping->indirizzo}}, {{$order->orderShipping->nr_civico}} {{$order->orderShipping->comune}}
                </div>
            </div>
            @endif
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Chiudi</button>
        </div>
    </div>

</div>