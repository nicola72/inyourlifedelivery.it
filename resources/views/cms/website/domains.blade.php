@extends('layouts.cms')
@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox">

                    <!-- header del box -->
                    <div class="ibox-title">

                        <!-- Nuovo Dominio -->
                        <a href="javascript:void(0)" onclick="get_modal('{{url("cms/website/create_domain")}}')" class="btn btn-w-m btn-primary">Nuovo</a>
                        <!-- fine pulsante nuovo -->

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
                                <th>Locale</th>
                                <th>Nome</th>
                                <th data-orderable="false">Azioni</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($domains as $domain)
                                <tr>
                                    <td>{{$domain->locale}}</td>

                                    <td>{{$domain->nome}}</td>

                                    <td>
                                        <!-- Pulsante per modificare -->
                                        <a class="azioni-table" onclick="get_modal('{{url('/cms/website/edit_domain',[$domain->id])}}')"  href="javascript:void(0)">
                                            <i class="fa fa-edit fa-2x"></i>
                                        </a>
                                        <!-- -->

                                        <!-- pulsante per eliminare -->
                                        <a class="azioni-table azione-red elimina pl-1"  href="{{url('/cms/website/destroy_domain',[$domain->id])}}">
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
    </script>
@stop
