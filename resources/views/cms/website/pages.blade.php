@extends('layouts.cms')
@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox">

                    <!-- header del box -->
                    <div class="ibox-title">

                        <!-- Nuovo Dominio -->
                        <a href="javascript:void(0)" onclick="get_modal('{{url("cms/website/create_page")}}')" class="btn btn-w-m btn-primary">Nuovo</a>
                        <!-- fine pulsante nuovo -->

                        <!-- Urls -->
                        <a href="{{url('cms/website/urls')}}" class="btn btn-w-m btn-primary">Urls</a>
                        <!-- -->

                        <!-- indietro -->
                        <a href="{{url("cms/website")}}" class="btn btn-w-m btn-primary">Indietro</a>
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
                                <th>Menu</th>
                                <th>Label</th>
                                <th>Ordine</th>
                                <th data-orderable="false">Sposta</th>
                                <th data-orderable="false">Azioni</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($pages as $page)
                                <tr>

                                    <td>{{$page->nome}}</td>
                                    <td>
                                        <!-- Pulsante Switch Menu -->
                                        <div class="switch">
                                            <div class="onoffswitch">
                                                <input type="checkbox" id="switch_{{$page->id}}"
                                                       data-id="{{$page->id}}"
                                                       class="onoffswitch-checkbox"
                                                        {{ ($page->menu == 1) ? "checked" : "" }} />
                                                <label class="onoffswitch-label" for="switch_{{$page->id}}">
                                                    <span class="onoffswitch-inner"></span>
                                                    <span class="onoffswitch-switch"></span>
                                                </label>
                                            </div>
                                        </div>
                                        <!-- -->
                                    </td>
                                    <td>{{$page->label_it}}</td>
                                    <td>{{$page->order}}</td>
                                    <td data-orderable="false">
                                        <!-- Pulsante per ordinare in su -->
                                        <a class="azioni-table"  href="{{url('/cms/website/page_move_up',[$page->id])}}">
                                            <i class="fa fa-arrow-circle-up fa-2x"></i>
                                        </a>
                                        <!-- -->

                                        <!-- Pulsante per ordinare in giù -->
                                        <a class="azioni-table pl-1"  href="{{url('/cms/website/page_move_down',[$page->id])}}">
                                            <i class="fa fa-arrow-circle-down fa-2x"></i>
                                        </a>
                                        <!-- -->
                                    </td>
                                    <td>
                                        <!-- pulsante per eliminare -->
                                        <a class="azioni-table azione-red elimina pl-1"  href="{{url('/cms/website/destroy_page',[$page->id])}}">
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

        //per lo switch menu
        $('.onoffswitch-checkbox').change(function ()
        {
            let stato = $(this).is(':checked') ? "1" : "0";

            $.ajax({
                type: "GET",
                url: "/cms/website/switch_menu_page",
                data: {id: $(this).attr('data-id'), stato : stato},
                dataType: "json",
                success: function (data){ alert(data.msg);},
                error: function (){ alert("Si è verificato un errore! Riprova!");}
            });
        });
    </script>
@stop
