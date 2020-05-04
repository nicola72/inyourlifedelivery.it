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
                        <table id="table-sliders" style="font-size:12px" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>Nome</th>
                                <td data-orderable="false">Visibile</th>
                                <th data-orderable="false">Azioni</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($sliders as $slider)
                                <tr>
                                    <td>{{$slider->nome}}</td>
                                    <td data-orderable="false">

                                        <!-- Pulsante Switch Stato -->
                                        <div class="switch">
                                            <div class="onoffswitch">
                                                <input type="checkbox" id="switch_{{$slider->id}}"
                                                       data-id="{{$slider->id}}"
                                                       class="onoffswitch-checkbox"
                                                        {{ ($slider->visibile == 1) ? "checked" : "" }} />
                                                <label class="onoffswitch-label" for="switch_{{$slider->id}}">
                                                    <span class="onoffswitch-inner"></span>
                                                    <span class="onoffswitch-switch"></span>
                                                </label>
                                            </div>
                                        </div>
                                        <!-- -->

                                    </td>
                                    <td data-orderable="false">
                                        <!-- Pulsante per le immagini -->
                                        <a class="azioni-table"  href="{{url('/cms/sliders/images',['id'=>$slider->id])}}" title="immagini">
                                            <i class="fa fa-camera fa-2x"></i>
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
            $('#table-sliders').DataTable({
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
                url: "/cms/sliders/switch_visibility",
                data: {id: $(this).attr('data-id'), stato : stato},
                dataType: "json",
                success: function (data){ alert(data.msg);location.reload();},
                error: function (){ alert("Si è verificato un errore! Riprova!");}
            });
        });
    </script>
@stop
