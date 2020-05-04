@extends('layouts.cms')
@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox">

                    <!-- header del box -->
                    <div class="ibox-title">

                        <!-- NUOVO -->
                        <a href="{{url('cms/pairing/create')}}" class="btn btn-w-m btn-primary">Aggiungi</a>
                        <!-- fine pulsante nuovo -->

                        <div class="ibox-tools">
                            <a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <!-- fine header -->

                    <div class="ibox-content">
                        <table id="table-pairings" style="font-size:12px" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>Id</th>
                                <th>Nome</th>
                                <th>Prodotto 1</th>
                                <th>Prodotto 2</th>
                                <th>Categoria</th>
                                <th>Prezzo</th>
                                <th data-orderable="false">Visibile</th>
                                <th data-orderable="false">Italfama</th>
                                <th data-orderable="false">Offerta</th>
                                <th data-orderable="false">Novità</th>
                                <th data-orderable="false">Azioni</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($pairings as $pairing)
                                <tr>
                                    <td>{{$pairing->id}}</td>
                                    <td>{{$pairing->nome_it}}</td>
                                    <td>{{$pairing->product1->codice}}</td>
                                    <td>{{$pairing->product2->codice}}</td>
                                    <td>{{$pairing->category->nome_it}}</td>

                                    <td>
                                        @money($pairing->product1->prezzo_vendita() + $pairing->product2->prezzo_vendita())
                                    </td>

                                    <td>
                                        <!-- Pulsante Switch Visibilita -->
                                        <div class="switch">
                                            <div class="onoffswitch">
                                                <input type="checkbox" id="switch_vis_{{$pairing->id}}"
                                                       data-id="{{$pairing->id}}"
                                                       class="onoffswitch-checkbox vis-check"
                                                        {{ ($pairing->visibile == 1) ? "checked" : "" }} />
                                                <label class="onoffswitch-label" for="switch_vis_{{$pairing->id}}">
                                                    <span class="onoffswitch-inner"></span>
                                                    <span class="onoffswitch-switch"></span>
                                                </label>
                                            </div>
                                        </div>
                                        <!-- -->
                                    </td>

                                    <td>
                                        <!-- Pulsante Switch Visibilita Italfama -->
                                        <div class="switch">
                                            <div class="onoffswitch">
                                                <input type="checkbox" id="switch_ital_{{$pairing->id}}"
                                                       data-id="{{$pairing->id}}"
                                                       class="onoffswitch-checkbox ital-check"
                                                        {{ ($pairing->italfama == 1) ? "checked" : "" }} />
                                                <label class="onoffswitch-label" for="switch_ital_{{$pairing->id}}">
                                                    <span class="onoffswitch-inner"></span>
                                                    <span class="onoffswitch-switch"></span>
                                                </label>
                                            </div>
                                        </div>
                                        <!-- -->

                                    </td>
                                    <td>
                                        <!-- Pulsante Switch Offerta-->
                                        <div class="switch">
                                            <div class="onoffswitch">
                                                <input type="checkbox" id="switch_offer_{{$pairing->id}}"
                                                       data-id="{{$pairing->id}}"
                                                       class="onoffswitch-checkbox offer-check"
                                                        {{ ($pairing->offerta == 1) ? "checked" : "" }} />
                                                <label class="onoffswitch-label" for="switch_offer_{{$pairing->id}}">
                                                    <span class="onoffswitch-inner"></span>
                                                    <span class="onoffswitch-switch"></span>
                                                </label>
                                            </div>
                                        </div>
                                        <!-- -->
                                    </td>
                                    <td>
                                        <!-- Pulsante Switch Novita-->
                                        <div class="switch">
                                            <div class="onoffswitch">
                                                <input type="checkbox" id="switch_novita_{{$pairing->id}}"
                                                       data-id="{{$pairing->id}}"
                                                       class="onoffswitch-checkbox novita-check"
                                                        {{ ($pairing->novita == 1) ? "checked" : "" }} />
                                                <label class="onoffswitch-label" for="switch_novita_{{$pairing->id}}">
                                                    <span class="onoffswitch-inner"></span>
                                                    <span class="onoffswitch-switch"></span>
                                                </label>
                                            </div>
                                        </div>
                                        <!-- -->
                                    </td>

                                    <td data-orderable="false">
                                        <!-- Pulsante per le immagini -->
                                        <a class="azioni-table"  href="{{url('/cms/pairing/images',['id'=>$pairing->id])}}" title="immagini">
                                            <i class="fa fa-camera fa-2x"></i>
                                        </a>
                                        <!-- -->

                                        <!-- Pulsante per modificare -->
                                        <a class="azioni-table pl-1"  href="{{route('pairing.edit',['id'=>$pairing->id])}}" title="modifica">
                                            <i class="fa fa-edit fa-2x"></i>
                                        </a>
                                        <!-- -->

                                        <!-- pulsante per eliminare -->
                                        <a class="azioni-table azione-red elimina pl-1"  href="{{url('/cms/pairing/destroy',[$pairing->id])}}" title="elimina">
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
            $('#table-pairings').DataTable({
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

        //Switch per VISIBILITA
        $('.vis-check').change(function ()
        {
            let stato = $(this).is(':checked') ? "1" : "0";

            $.ajax({
                type: "GET",
                url: "/cms/pairing/switch_visibility",
                data: {id: $(this).attr('data-id'), stato : stato},
                dataType: "json",
                success: function (data){ alert(data.msg);},
                error: function (){ alert("Si è verificato un errore! Riprova!");}
            });
        });
        //Fine

        //Switch per VISIBILITA ITALFAMA
        $('.ital-check').change(function ()
        {
            let stato = $(this).is(':checked') ? "1" : "0";

            $.ajax({
                type: "GET",
                url: "/cms/pairing/switch_visibility_italfama",
                data: {id: $(this).attr('data-id'), stato : stato},
                dataType: "json",
                success: function (data){ alert(data.msg);},
                error: function (){ alert("Si è verificato un errore! Riprova!");}
            });
        });
        //Fine

        //Switch per OFFERTA
        $('.offer-check').change(function ()
        {
            let stato = $(this).is(':checked') ? "1" : "0";

            $.ajax({
                type: "GET",
                url: "/cms/pairing/switch_offerta",
                data: {id: $(this).attr('data-id'), stato : stato},
                dataType: "json",
                success: function (data){ alert(data.msg);},
                error: function (){ alert("Si è verificato un errore! Riprova!");}
            });
        });
        //Fine

        //Switch per NOVITA
        $('.novita-check').change(function ()
        {
            let stato = $(this).is(':checked') ? "1" : "0";

            $.ajax({
                type: "GET",
                url: "/cms/pairing/switch_novita",
                data: {id: $(this).attr('data-id'), stato : stato},
                dataType: "json",
                success: function (data){ alert(data.msg);},
                error: function (){ alert("Si è verificato un errore! Riprova!");}
            });
        });
        //Fine

    </script>
@stop
