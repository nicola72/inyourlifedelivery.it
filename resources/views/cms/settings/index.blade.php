@extends('layouts.cms')
@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox">

                    <!-- header del box -->
                    <div class="ibox-title">

                        <!-- NUOVO Modulo -->
                        <a href="javascript:void(0)" onclick="get_modal('{{url('cms/settings/create_module')}}')" class="btn btn-w-m btn-primary">Aggiungi</a>
                        <!-- fine pulsante nuovo -->


                        <div class="ibox-tools">
                            <a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <!-- fine header -->

                    <div class="ibox-content">
                        <table id="table-moduli" style="font-size:12px" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Label</th>
                                <th>Icon</th>
                                <th data-orderable="false">Stato</th>
                                <th data-orderable="false">Azioni</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach($moduli as $modulo)
                                    <tr>
                                        <td>{{$modulo->nome}}</td>

                                        <td>{{$modulo->label}}</td>

                                        <td>{{$modulo->icon}}</td>

                                        <td data-orderable="false">

                                            <!-- Pulsante Switch Stato -->
                                            <div class="switch">
                                                <div class="onoffswitch">
                                                    <input type="checkbox" id="switch_{{$modulo->id}}"
                                                           data-id="{{$modulo->id}}"
                                                           class="onoffswitch-checkbox"
                                                           {{ ($modulo->stato == 1) ? "checked" : "" }} />
                                                    <label class="onoffswitch-label" for="switch_{{$modulo->id}}">
                                                        <span class="onoffswitch-inner"></span>
                                                        <span class="onoffswitch-switch"></span>
                                                    </label>
                                                </div>
                                            </div>
                                            <!-- -->

                                        </td>
                                        <td data-orderable="false">

                                            <!-- Pulsante per modificare -->
                                            <a class="azioni-table" onclick="get_modal('{{url('/cms/settings/edit_module',[$modulo->id])}}')"  href="javascript:void(0)">
                                                <i class="fa fa-edit fa-2x"></i>
                                            </a>
                                            <!-- -->

                                            <!-- Pulsante per configurazione modulo -->
                                            <a class="azioni-table" href="{{url('/cms/settings/config_module',[$modulo->id])}}">
                                                <i class="fa fa-cogs fa-2x"></i>
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
            $('#table-moduli').DataTable({
                responsive: true,
                pageLength: 100,
                language:{ "url": "/cms_assets/js/plugins/dataTables/dataTable.ita.lang.json" }
            });

        });
        
        $('.onoffswitch-checkbox').change(function ()
        {
            let stato = $(this).is(':checked') ? "1" : "0";

            $.ajax({
                type: "GET",
                url: "/cms/settings/switch_stato_module",
                data: {id: $(this).attr('data-id'), stato : stato},
                dataType: "json",
                success: function (data){ alert(data.msg);},
                error: function (){ alert("Si è verificato un errore! Riprova!");}
            });
        });

    </script>
@stop