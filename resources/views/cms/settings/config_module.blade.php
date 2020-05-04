@extends('layouts.cms')
@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox">

                    <!-- header del box -->
                    <div class="ibox-title">

                        <!-- NUOVO Configurazione -->
                        <a href="javascript:void(0)" onclick="get_modal('{{url('cms/settings/create_config_module',[$modulo->id])}}')" class="btn btn-w-m btn-primary">Aggiungi</a>
                        <!-- fine pulsante nuovo -->

                        <!-- Copiare configurazioni -->
                        <a href="javascript:void(0)" onclick="get_modal('{{url('cms/settings/create_copy_config_module',[$modulo->id])}}')" class="btn btn-w-m btn-primary">Copia da Modulo</a>
                        <!-- -->

                        <!-- Indietro -->
                        <a href="{{url('cms/settings')}}" class="btn btn-w-m btn-primary">Indietro</a>
                        <!-- -->


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
                                <th>Descrizione</th>
                                <th>Tipo</th>
                                <th>Valore</th>
                                <th data-orderable="false">Azioni</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($configs as $config)
                                <tr>
                                    <td>{{$config->nome}}</td>

                                    <td>{{$config->desc}}</td>

                                    <td>{{$config->type}}</td>

                                    <td>
                                        @if($config->type == 'boolean')
                                            <!-- Pulsante Switch Stato -->
                                            <div class="switch">
                                                <div class="onoffswitch">
                                                    <input type="checkbox" id="switch_{{$config->id}}"
                                                           data-id="{{$config->id}}"
                                                           class="onoffswitch-checkbox"
                                                            {{ ($config->value == 1) ? "checked" : "" }} />
                                                    <label class="onoffswitch-label" for="switch_{{$config->id}}">
                                                        <span class="onoffswitch-inner"></span>
                                                        <span class="onoffswitch-switch"></span>
                                                    </label>
                                                </div>
                                            </div>
                                            <!-- -->
                                        @elseif($config->type == 'string')
                                            {{$config->value}}
                                        @endif

                                    </td>

                                    <td>
                                        <!-- Pulsante per modificare -->
                                        <a class="azioni-table" onclick="get_modal('{{url('/cms/settings/edit_config_module',[$config->id])}}')"  href="javascript:void(0)">
                                            <i class="fa fa-edit fa-2x"></i>
                                        </a>
                                        <!-- -->

                                        <!-- pulsante per eliminare -->
                                        <a class="azioni-table azione-red elimina pl-1"  href="{{url('/cms/settings/destroy_config_module',[$config->id])}}">
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
        $('.onoffswitch-checkbox').change(function ()
        {
            let stato = $(this).is(':checked') ? "1" : "0";

            $.ajax({
                type: "GET",
                url: "/cms/settings/switch_boolean_config",
                data: {id: $(this).attr('data-id'), stato : stato},
                dataType: "json",
                success: function (data){ alert(data.msg);},
                error: function (){ alert("Si è verificato un errore! Riprova!");}
            });
        });


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
                    location.href = url;
                });
            });


        });
    </script>
@stop