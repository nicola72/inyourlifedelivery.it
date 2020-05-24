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
                        <table id="table-categories" style="font-size:12px" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Shop</th>
                                <th>Ordine</th>
                                <th data-orderable="false">Foto</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($categorie as $cat)
                                <tr>
                                    <td>{{$cat->nome_it}}</td>
                                    <td>{{$cat->shop->insegna}}</td>
                                    <td>{{$cat->order}}</td>
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
                order: [[ 1, "asc" ]], //order in base a order
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
