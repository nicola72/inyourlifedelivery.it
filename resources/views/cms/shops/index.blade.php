@extends('layouts.cms')
@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox">

                    <!-- header del box -->
                    <div class="ibox-title">

                        <!-- NUOVO NEGOZIO -->
                        <a href="javascript:void(0)" onclick="get_modal('{{url('cms/shops/create')}}')" class="btn btn-w-m btn-primary">Aggiungi</a>
                        <!-- fine pulsante nuovo -->

                        <!-- Registra nuovo utente -->
                        <a href="{{ route('cms.register') }}" class="btn btn-w-m btn-primary">Registra</a>
                        <!--  -->

                        <!-- Registra utenti -->
                        <a href="{{ url('cms/shops/users') }}" class="btn btn-w-m btn-primary">Utenti Shop</a>
                        <!--  -->

                        <div class="ibox-tools">
                            <a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <!-- fine header -->

                    <div class="ibox-content">
                        <table id="table-shops" style="font-size:12px" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>R.Sociale</th>
                                <th>Dominio</th>
                                <th>P.via</th>
                                <th>Email</th>
                                <th>Domicilio</th>
                                <th>Asporto</th>
                                <th>Stato</th>
                                <th data-orderable="false">Azioni</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($shops as $shop)
                                <tr>
                                    <td>{{$shop->ragione_sociale}}</td>
                                    <td>{{$shop->domain}}</td>
                                    <td>{{$shop->p_iva}}</td>
                                    <td>{{$shop->email}}</td>

                                    <td data-orderable="false">

                                        <!-- Pulsante Switch Domicilio -->
                                        <div class="switch">
                                            <div class="onoffswitch">
                                                <input type="checkbox" id="switch_dom_{{$shop->id}}"
                                                       data-id="{{$shop->id}}"
                                                       class="onoffswitch-checkbox domicilio-check"
                                                        {{ ($shop->domicilio == 1) ? "checked" : "" }} />
                                                <label class="onoffswitch-label" for="switch_dom_{{$shop->id}}">
                                                    <span class="onoffswitch-inner"></span>
                                                    <span class="onoffswitch-switch"></span>
                                                </label>
                                            </div>
                                        </div>
                                        <!-- -->

                                    </td>

                                    <td data-orderable="false">

                                        <!-- Pulsante Switch Asporto -->
                                        <div class="switch">
                                            <div class="onoffswitch">
                                                <input type="checkbox" id="switch_asp_{{$shop->id}}"
                                                       data-id="{{$shop->id}}"
                                                       class="onoffswitch-checkbox asporto-check"
                                                        {{ ($shop->asporto == 1) ? "checked" : "" }} />
                                                <label class="onoffswitch-label" for="switch_asp_{{$shop->id}}">
                                                    <span class="onoffswitch-inner"></span>
                                                    <span class="onoffswitch-switch"></span>
                                                </label>
                                            </div>
                                        </div>
                                        <!-- -->

                                    </td>

                                    <td data-orderable="false">

                                        <!-- Pulsante Switch Stato -->
                                        <div class="switch">
                                            <div class="onoffswitch">
                                                <input type="checkbox" id="switch_{{$shop->id}}"
                                                       data-id="{{$shop->id}}"
                                                       class="onoffswitch-checkbox stato-check"
                                                        {{ ($shop->stato == 1) ? "checked" : "" }} />
                                                <label class="onoffswitch-label" for="switch_{{$shop->id}}">
                                                    <span class="onoffswitch-inner"></span>
                                                    <span class="onoffswitch-switch"></span>
                                                </label>
                                            </div>
                                        </div>
                                        <!-- -->

                                    </td>
                                    <td data-orderable="false">
                                        <!-- Pulsante per modificare -->
                                        <a class="azioni-table" onclick="get_modal('{{url('cms/shops/edit',['id'=>$shop->id])}}')"  href="javascript:void(0)">
                                            <i class="fa fa-edit fa-2x"></i>
                                        </a>
                                        <!-- -->

                                        <!-- pulsante per eliminare -->
                                        <a class="azioni-table azione-red elimina pl-1"  href="{{url('/cms/shops/destroy',[$shop->id])}}">
                                            <i class="fa fa-trash fa-2x"></i>
                                        </a>
                                        <!-- -->
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
            $('#table-shops').DataTable({
                responsive: true,
                pageLength: 100,
                order: [[ 4, "asc" ]], //order in base a order
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

        $('.stato-check').change(function ()
        {
            let stato = $(this).is(':checked') ? "1" : "0";

            $.ajax({
                type: "GET",
                url: "/cms/shops/switch_stato",
                data: {id: $(this).attr('data-id'), stato : stato},
                dataType: "json",
                success: function (data){ alert(data.msg);},
                error: function (){ alert("Si è verificato un errore! Riprova!");}
            });
        });

        $('.asporto-check').change(function ()
        {
            let stato = $(this).is(':checked') ? "1" : "0";

            $.ajax({
                type: "GET",
                url: "/cms/shops/switch_asporto",
                data: {id: $(this).attr('data-id'), stato : stato},
                dataType: "json",
                success: function (data){ alert(data.msg);},
                error: function (){ alert("Si è verificato un errore! Riprova!");}
            });
        });

        $('.domicilio-check').change(function ()
        {
            let stato = $(this).is(':checked') ? "1" : "0";

            $.ajax({
                type: "GET",
                url: "/cms/shops/switch_domicilio",
                data: {id: $(this).attr('data-id'), stato : stato},
                dataType: "json",
                success: function (data){ alert(data.msg);},
                error: function (){ alert("Si è verificato un errore! Riprova!");}
            });
        });
    </script>
@stop
