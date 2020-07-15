@extends('layouts.cms')
@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox">

                    <!-- header del box -->
                    <div class="ibox-title">
                        <!-- CREA PDF -->
                        <a href="{{url('cms/orders_print_no_evasion')}}" target="_blank" class="btn btn-w-m btn-primary">
                            <i class="fa fa-print"></i> Stampa gli ordini aperti
                        </a>
                        <!-- fine pulsante nuovo -->
                        <div class="ibox-tools">
                            <a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>

                    <!-- fine header -->

                    <div class="ibox-content">

                        <table id="table-orders" style="font-size:12px" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>Id</th>
                                <th>Orario</th>
                                <th>Cliente</th>
                                <th>Tel</th>
                                <th>Metodo pag.</th>
                                <th>Pagato</th>
                                <th>Tipo</th>
                                <th>Indirizzo</th>
                                <th>Importo</th>
                                <th>Evaso</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($orders as $order)
                                <tr>
                                    <td>{{$order->id}}</td>
                                    <td>
                                        {{substr($order->orario, 0, -3)}}
                                    </td>
                                    <td>
                                        {{$order->nome}} {{$order->cognome}}
                                    </td>
                                    <td>{{$order->telefono}}</td>
                                    <td>{{$order->modalita_pagamento}}</td>
                                    <td>
                                        @if($order->stato_pagamento == 1)
                                            si
                                        @else
                                            no
                                        @endif
                                    </td>
                                    <td>{{$order->tipo}}</td>
                                    <td>
                                        @if($order->orderShipping)
                                            {{$order->orderShipping->indirizzo}}, {{$order->orderShipping->nr_civico}}
                                            <br>
                                            {{$order->orderShipping->comune}}
                                        @endif
                                    </td>
                                    <td>@money($order->importo)</td>
                                    <td>
                                        <!-- Pulsante Switch Evaso -->
                                        <div class="switch">
                                            <div class="onoffswitch">
                                                <input type="checkbox" id="switch_{{$order->id}}"
                                                       data-id="{{$order->id}}"
                                                       class="onoffswitch-checkbox evaso-check"
                                                    {{ ($order->evaso == 1) ? "checked" : "" }} />
                                                <label class="onoffswitch-label" for="switch_{{$order->id}}">
                                                    <span class="onoffswitch-inner"></span>
                                                    <span class="onoffswitch-switch"></span>
                                                </label>
                                            </div>
                                        </div>
                                        <!-- -->
                                    </td>
                                    <td>
                                        <a class="azioni-table" href="javascript:void(0)" onclick="get_modal('{{url("cms/order_details",["id"=>$order->id])}}')" title="dettagli">
                                            <i class="fa fa-search fa-2x"></i>
                                        </a>
                                        <a class="azioni-table pl-1" href="{{url("cms/order_print",["id"=>$order->id])}}" target="_blank" title="stampa">
                                            <i class="fa fa-print fa-2x"></i>
                                        </a>
                                        @if($order->evaso == 0)
                                        <!-- pulsante per eliminare -->
                                        <a class="azioni-table azione-red elimina pl-1"  href="{{url('/cms/order_destroy',[$order->id])}}" title="elimina">
                                            <i class="fa fa-trash fa-2x"></i>
                                        </a>
                                        <!-- -->
                                        @endif
                                    </td>

                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js_script')
    <script>
        $(document).ready(function ()
        {
            $('#table-orders').DataTable({
                responsive: true,
                pageLength: 100,
                order: [[ 0, "desc" ]], //order in base a order
                language:{ "url": "/cms_assets/js/plugins/dataTables/dataTable.ita.lang.json" }
            });

        });

        //Per il Pulsante ELIMINA
        $(document).ready(function()
        {
            $('.elimina').click(function (e)
            {
                e.preventDefault();
                var url = $(this).attr('href');

                swal({
                    title: "Sei sicuro?",
                    text: "Sarà impossibile recuperare il file!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Sì, elimina!",
                    closeOnConfirm: false
                }, function ()
                {
                    showPreloader();
                    location.href = url;
                });
            });
        });
        //Fine Pulsante ELIMINA

        //per lo switch visibile
        $('.evaso-check').change(function ()
        {
            let stato = $(this).is(':checked') ? "1" : "0";

            $.ajax({
                type: "GET",
                url: "/cms/orders_switch_evaso",
                data: {id: $(this).attr('data-id'), stato : stato},
                dataType: "json",
                success: function (data){ alert(data.msg);},
                error: function (){ alert("Si è verificato un errore! Riprova!");}
            });
        });

        setTimeout(function(){
            window.location.reload();
        }, 36000);

    </script>
@stop
