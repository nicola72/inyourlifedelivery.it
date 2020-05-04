@extends('layouts.cms')
@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox">

                    <!-- header del box -->
                    <div class="ibox-title">

                        <!-- NUOVA NEWS -->
                        <a href="javascript:void(0)" onclick="get_modal('{{url('cms/news/create')}}')" class="btn btn-w-m btn-primary">Aggiungi</a>
                        <!-- fine pulsante nuovo -->

                        <div class="ibox-tools">
                            <a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <!-- fine header -->

                    <div class="ibox-content">
                        <table id="table-news" style="font-size:12px" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Descrizione</th>
                                <th>Visibile</th>
                                <th>Popup</th>
                                <th>Ordine</th>
                                <th data-orderable="false">Sposta</th>
                                <th data-orderable="false">Azioni</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($newsitems as $item)
                                <tr>
                                    <td>{{$item->nome_it}}</td>
                                    <td>{{$item->desc_it}}</td>

                                    <td data-orderable="false">

                                        <!-- Pulsante Switch Visibile -->
                                        <div class="switch">
                                            <div class="onoffswitch">
                                                <input type="checkbox" id="switch_{{$item->id}}"
                                                       data-id="{{$item->id}}"
                                                       class="onoffswitch-checkbox vis-check"
                                                        {{ ($item->visibile == 1) ? "checked" : "" }} />
                                                <label class="onoffswitch-label" for="switch_{{$item->id}}">
                                                    <span class="onoffswitch-inner"></span>
                                                    <span class="onoffswitch-switch"></span>
                                                </label>
                                            </div>
                                        </div>
                                        <!-- -->

                                    </td>

                                    <td data-orderable="false">

                                        <!-- Pulsante Switch Popup -->
                                        <div class="switch">
                                            <div class="onoffswitch">
                                                <input type="checkbox" id="switch_pop_{{$item->id}}"
                                                       data-id="{{$item->id}}"
                                                       class="onoffswitch-checkbox pop-check"
                                                        {{ ($item->popup == 1) ? "checked" : "" }} />
                                                <label class="onoffswitch-label" for="switch_pop_{{$item->id}}">
                                                    <span class="onoffswitch-inner"></span>
                                                    <span class="onoffswitch-switch"></span>
                                                </label>
                                            </div>
                                        </div>
                                        <!-- -->

                                    </td>
                                    <td>{{$item->order}}</td>
                                    <td data-orderable="false">
                                        <!-- Pulsante per ordinare in su -->
                                        <a class="azioni-table"  href="{{url('/cms/news/move_up',[$item->id])}}">
                                            <i class="fa fa-arrow-circle-up fa-2x"></i>
                                        </a>
                                        <!-- -->

                                        <!-- Pulsante per ordinare in giù -->
                                        <a class="azioni-table pl-1"  href="{{url('/cms/news/move_down',[$item->id])}}">
                                            <i class="fa fa-arrow-circle-down fa-2x"></i>
                                        </a>
                                        <!-- -->
                                    </td>
                                    <td data-orderable="false">
                                        <!-- Pulsante per le immagini -->
                                        <a class="azioni-table"  href="{{url('/cms/news/images',['id'=>$item->id])}}" title="immagini">
                                            <i class="fa fa-camera fa-2x"></i>
                                        </a>
                                        <!-- -->
                                        <!-- Pulsante per modificare -->
                                        <a class="azioni-table pl-1" onclick="get_modal('{{route('news.edit',['id'=>$item->id])}}')"  href="javascript:void(0)">
                                            <i class="fa fa-edit fa-2x"></i>
                                        </a>
                                        <!-- -->

                                        <!-- pulsante per eliminare -->
                                        <a class="azioni-table azione-red elimina pl-1"  href="{{url('/cms/news/destroy',[$item->id])}}">
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
            $('#table-news').DataTable({
                responsive: true,
                pageLength: 100,
                order: [[ 4, "desc" ]], //order in base a order
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
        $('.vis-check').change(function ()
        {
            let stato = $(this).is(':checked') ? "1" : "0";

            $.ajax({
                type: "GET",
                url: "/cms/news/switch_visibility",
                data: {id: $(this).attr('data-id'), stato : stato},
                dataType: "json",
                success: function (data){ alert(data.msg);},
                error: function (){ alert("Si è verificato un errore! Riprova!");}
            });
        });

        //per lo switch popup
        $('.pop-check').change(function ()
        {
            let stato = $(this).is(':checked') ? "1" : "0";

            $.ajax({
                type: "GET",
                url: "/cms/news/switch_popup",
                data: {id: $(this).attr('data-id'), stato : stato},
                dataType: "json",
                success: function (data){ alert(data.msg);},
                error: function (){ alert("Si è verificato un errore! Riprova!");}
            });
        });
    </script>
@stop
