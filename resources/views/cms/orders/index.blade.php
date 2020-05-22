@extends('layouts.cms')
@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox">

                    <!-- header del box -->
                    <div class="ibox-title">
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
                                        <a href="javascript:void(0)" onclick="get_modal('{{url("cms/order_details",["id"=>$order->id])}}')" title="dettagli">
                                            <i class="fa fa-search"></i>
                                        </a>
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



    </script>
@stop
