@extends('layouts.cms')
@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox">

                    <!-- header del box -->
                    <div class="ibox-title">

                        <!-- NUOVO -->
                        <a href="{{url('cms/seo/create')}}" class="btn btn-w-m btn-primary">Aggiungi</a>
                        <!-- fine pulsante nuovo -->

                        <!-- urls -->
                        <a href="{{url('cms/website/urls')}}" class="btn btn-w-m btn-primary">Urls</a>
                        <!-- -->

                        <div class="ibox-tools">
                            <a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <!-- fine header -->

                    <div class="ibox-content">
                        <table id="table-seos" style="font-size:12px" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>Id</th>
                                <th>Locale</th>
                                <th>Title</th>
                                <th>Homepage</th>
                                <th data-orderable="false">Associa</th>
                                <th>Associato a</th>
                                <th data-orderable="false">Azioni</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($seos as $seo)
                                <tr>
                                    <td>{{$seo->id}}</td>
                                    <td>{{$seo->locale}}</td>
                                    <td>{{$seo->title}}</td>
                                    <td>
                                        <!-- Pulsante Switch Homepage -->
                                        <div class="switch">
                                            <div class="onoffswitch">
                                                <input type="checkbox" id="switch_{{$seo->id}}"
                                                       data-id="{{$seo->id}}"
                                                       class="onoffswitch-checkbox home-check"
                                                        {{ ($seo->homepage == 1) ? "checked" : "" }} />
                                                <label class="onoffswitch-label" for="switch_{{$seo->id}}">
                                                    <span class="onoffswitch-inner"></span>
                                                    <span class="onoffswitch-switch"></span>
                                                </label>
                                            </div>
                                        </div>
                                        <!-- -->
                                    </td>
                                    <td data-orderable="false">
                                        @if($seo->homepage != 1 && !$seo->url && $seo->bind_to == '')
                                        <a href="javascript:void(0)" onclick="get_modal('{{url('cms/seo/associa_url',$seo->id)}}')" class="btn btn-primary d-block btn-sm mb-2 w-100">
                                            url
                                        </a>
                                        <a href="javascript:void(0)" onclick="get_modal('{{url('cms/seo/associa_model',$seo->id)}}')" class="btn btn-primary d-block btn-sm w-100">
                                            tipo url
                                        </a>
                                        @endif
                                    </td>
                                    <td>
                                        @if($seo->url)
                                            www.{{$seo->url->domain->nome}}/{{$seo->url->locale}}/{{$seo->url->slug}}
                                            <a href="{{url('cms/seo/delete_associazione_url',$seo->url->id)}}" class="btn btn-danger btn-sm mt-1 mb-2 d-block" title="rimuovi associazione">
                                                <i class="fa fa-trash"></i> associazione
                                            </a>
                                        @elseif($seo->bind_to != '')
                                            {{$seo->bind_to}}
                                            <a href="{{url('cms/seo/delete_associazione_model',$seo->id)}}" class="btn btn-danger btn-sm mt-1 mb-2 d-block" title="rimuovi associazione">
                                                <i class="fa fa-trash"></i> associazione
                                            </a>
                                        @else
                                            @if($seo->homepage != 1)
                                                niente
                                            @else
                                                homepage
                                            @endif
                                        @endif
                                    </td>
                                    <td data-orderable="false">

                                        <!-- Pulsante per modificare -->
                                        <a class="azioni-table pl-1"  href="{{route('seo.edit',['id'=>$seo->id])}}" title="modifica">
                                            <i class="fa fa-edit fa-2x"></i>
                                        </a>
                                        <!-- -->

                                        <!-- pulsante per eliminare -->
                                        <a class="azioni-table azione-red elimina pl-1"  href="{{url('/cms/seo/destroy',[$seo->id])}}" title="elimina">
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
            $('#table-seos').DataTable({
                responsive: true,
                pageLength: 100,
                order: [[ 0, "asc" ]], //order in base a order
                language:{ "url": "/cms_assets/js/plugins/dataTables/dataTable.ita.lang.json" }
            });

        });

        //Switch per Homepage
        $('.home-check').change(function ()
        {
            let stato = $(this).is(':checked') ? "1" : "0";

            $.ajax({
                type: "GET",
                url: "/cms/seo/switch_homepage",
                data: {id: $(this).attr('data-id'), stato : stato},
                dataType: "json",
                success: function (data){ alert(data.msg);location.reload();},
                error: function (){ alert("Si è verificato un errore! Riprova!");}
            });
        });
        //Fine

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
                    location.href = url;
                });
            });
        });
        //Fine Pulsante ELIMINA



    </script>
@stop
