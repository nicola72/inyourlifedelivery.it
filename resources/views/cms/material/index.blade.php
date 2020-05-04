@extends('layouts.cms')
@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox">

                    <!-- header del box -->
                    <div class="ibox-title">

                        <!-- NUOVO Materiale -->
                        <a href="javascript:void(0)" onclick="get_modal('{{url('cms/material/create')}}')" class="btn btn-w-m btn-primary">Aggiungi</a>
                        <!-- fine pulsante nuovo -->

                        <div class="ibox-tools">
                            <a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <!-- fine header -->

                    <div class="ibox-content">
                        <table id="table-categories" style="font-size:12px" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Per</th>
                                <th>Stato</th>
                                <th>Ordine</th>
                                <th data-orderable="false">Sposta</th>
                                <th data-orderable="false">Azioni</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($materials as $material)
                                <tr>
                                    <td>{{$material->nome_it}}</td>
                                    <td>{{$material->per}}</td>
                                    <td>

                                        <!-- Pulsante Switch Stato -->
                                        <div class="switch">
                                            <div class="onoffswitch">
                                                <input type="checkbox" id="switch_{{$material->id}}"
                                                       data-id="{{$material->id}}"
                                                       class="onoffswitch-checkbox"
                                                        {{ ($material->stato == 1) ? "checked" : "" }} />
                                                <label class="onoffswitch-label" for="switch_{{$material->id}}">
                                                    <span class="onoffswitch-inner"></span>
                                                    <span class="onoffswitch-switch"></span>
                                                </label>
                                            </div>
                                        </div>
                                        <!-- -->

                                    </td>
                                    <td>{{$material->order}}</td>
                                    <td data-orderable="false">
                                        <!-- Pulsante per ordinare in su -->
                                        <a class="azioni-table"  href="{{url('/cms/material/move_up',[$material->id])}}">
                                            <i class="fa fa-arrow-circle-up fa-2x"></i>
                                        </a>
                                        <!-- -->

                                        <!-- Pulsante per ordinare in giù -->
                                        <a class="azioni-table pl-1"  href="{{url('/cms/material/move_down',[$material->id])}}">
                                            <i class="fa fa-arrow-circle-down fa-2x"></i>
                                        </a>
                                        <!-- -->
                                    </td>
                                    <td data-orderable="false">
                                        <!-- Pulsante per modificare -->
                                        <a class="azioni-table" onclick="get_modal('{{route('material.edit',['id'=>$material->id])}}')"  href="javascript:void(0)">
                                            <i class="fa fa-edit fa-2x"></i>
                                        </a>
                                        <!-- -->

                                        <!-- pulsante per eliminare -->
                                        <a class="azioni-table azione-red elimina pl-1"  href="{{url('/cms/material/destroy',[$material->id])}}">
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
            $('#table-categories').DataTable({
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

        $('.onoffswitch-checkbox').change(function ()
        {
            let stato = $(this).is(':checked') ? "1" : "0";

            $.ajax({
                type: "GET",
                url: "/cms/material/switch_stato",
                data: {id: $(this).attr('data-id'), stato : stato},
                dataType: "json",
                success: function (data){ alert(data.msg);},
                error: function (){ alert("Si è verificato un errore! Riprova!");}
            });
        });
    </script>
@stop
