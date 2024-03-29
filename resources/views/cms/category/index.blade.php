@extends('layouts.cms')
@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox">

                    <!-- header del box -->
                    <div class="ibox-title">

                        <!-- solo l'Editore può inserire una nuova categoria -->
                        @if($user->role_id != 1)
                        <!-- NUOVA CATEGORIA -->
                        <a href="javascript:void(0)" onclick="get_modal('{{url('cms/category/create')}}')" class="btn btn-w-m btn-primary">Aggiungi</a>
                        <!-- fine pulsante nuovo -->
                        @endif

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
                                <th>Shop</th>
                                <th>Stato</th>
                                <th>Ordine</th>
                                <th data-orderable="false">Sposta</th>
                                <th data-orderable="false">Azioni</th>
                                <th data-orderable="false">Foto</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($categorie as $cat)
                                <tr>
                                    <td>{{$cat->nome_it}}</td>
                                    <td>{{$cat->shop->insegna}}</td>

                                    <td data-orderable="false">

                                        <!-- Pulsante Switch Stato -->
                                        <div class="switch">
                                            <div class="onoffswitch">
                                                <input type="checkbox" id="switch_{{$cat->id}}"
                                                       data-id="{{$cat->id}}"
                                                       class="onoffswitch-checkbox"
                                                        {{ ($cat->stato == 1) ? "checked" : "" }} />
                                                <label class="onoffswitch-label" for="switch_{{$cat->id}}">
                                                    <span class="onoffswitch-inner"></span>
                                                    <span class="onoffswitch-switch"></span>
                                                </label>
                                            </div>
                                        </div>
                                        <!-- -->

                                    </td>
                                    <td>{{$cat->order}}</td>
                                    <td data-orderable="false">
                                        <!-- Pulsante per ordinare in su -->
                                        <a class="azioni-table"  href="{{url('/cms/category/move_up',[$cat->id])}}">
                                            <i class="fa fa-arrow-circle-up fa-2x"></i>
                                        </a>
                                        <!-- -->

                                        <!-- Pulsante per ordinare in giù -->
                                        <a class="azioni-table pl-1"  href="{{url('/cms/category/move_down',[$cat->id])}}">
                                            <i class="fa fa-arrow-circle-down fa-2x"></i>
                                        </a>
                                        <!-- -->
                                    </td>
                                    <td data-orderable="false">
                                        <!-- Pulsante per modificare -->
                                        <a class="azioni-table" onclick="get_modal('{{route('category.edit',['id'=>$cat->id])}}')"  href="javascript:void(0)">
                                            <i class="fa fa-edit fa-2x"></i>
                                        </a>
                                        <!-- -->

                                        <!-- Pulsante per le immagini -->
                                        <a class="azioni-table pl-1"  href="{{url('/cms/category/images',['id'=>$cat->id])}}" title="immagini">
                                            <i class="fa fa-camera fa-2x"></i>
                                        </a>
                                        <!-- -->

                                        <!-- pulsante per eliminare -->
                                        <a class="azioni-table azione-red elimina pl-1"  href="{{url('/cms/category/destroy',[$cat->id])}}">
                                            <i class="fa fa-trash fa-2x"></i>
                                        </a>
                                        <!-- -->
                                    </td>
                                    <td>
                                        @if($cat->cover($cat->shop_id))
                                            <img src="/file/{{$cat->cover($cat->shop_id)}}" alt="" class="img-fluid" style="max-width:100px"/>
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
            $('#table-categories').DataTable({
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

        $('.onoffswitch-checkbox').change(function ()
        {
            let stato = $(this).is(':checked') ? "1" : "0";

            $.ajax({
                type: "GET",
                url: "/cms/category/switch_stato",
                data: {id: $(this).attr('data-id'), stato : stato},
                dataType: "json",
                success: function (data){ alert(data.msg);},
                error: function (){ alert("Si è verificato un errore! Riprova!");}
            });
        });
    </script>
@stop
