@extends('layouts.cms')
@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-5">
                <div class="ibox">
                    <!-- header del box -->
                    <div class="ibox-title">

                        <!-- Indietro -->
                        <a href="{{url('cms/pairing')}}" class="btn btn-w-m btn-primary">Abbinamenti</a>
                        <!-- fine pulsante nuovo -->

                        <div class="ibox-tools">
                            <a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <!-- fine header -->

                    <!-- se non ho raggiunto il massimo dei file da caricare: -->
                    @if(!$limit_max_file)
                        <div class="ibox-content">
                            <div class="row">
                                <div class="col-md-12">
                                    <em>
                                        Numero massimo di file da caricare: <b>
                                        {{$max_numero_file}}
                                        </b>
                                    </em>
                                    <br>
                                    <em>
                                        Grandezza max file:<b>
                                        {{$max_file_size}} Mb
                                        </b>
                                    </em>
                                    <br>
                                    <em>
                                        Tipo di file consentiti:<b>
                                        {{$extensions}}
                                        </b>
                                    </em>
                                    <br>
                                    <br>
                                </div>
                            </div>

                            <!-- DROPZONE per upload immagini -->
                            <form action="{{url('cms/pairing/upload_images')}}" class="dropzone" id="dropzoneForm">
                                {{ csrf_field() }}
                                <input type="hidden" name="fileable_id" id="fileable_id" value="{{$pairing->id}}" />
                                <div class="row">
                                    <div class="col-md-12">
                                        <div>
                                            <div class="fallback">
                                                <input name="file" type="file" multiple />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <!-- -->

                        </div>
                    @else
                    <div class="ibox-content">
                        <div class="row">
                            <div class="col-md-12">
                                Hai già raggiunto il limite massimo di immagini da poter caricare!
                            </div>
                        </div>
                    </div>
                    @endif
                </div>

            </div>
            @if($images->count() > 0)
            <div class="col-lg-7 animated fadeInRight">
                <div class="ibox">
                    <!-- header del box -->
                    <div class="ibox-title">
                        <h4>Lista delle immagini</h4>
                        <ul class="list-unstyled">
                            <li>puoi trascinare le immagini per cambiarne l'ordine</li>
                        </ul>
                    </div>
                </div>
                <div class="row">
                    <div id="sortable" class="col-md-12 sortable">
                        @foreach($images as $img)
                        <div id="{{$img->id}}" class="file-box" style="cursor: pointer">
                            <div class="file">

                                <span class="corner"></span>

                                <div class="image">
                                    <a href="{{$website_config['cs_big_dir'].$img->path}}"  data-gallery="">
                                        <img src="{{$website_config['cs_small_dir'].$img->path}}" alt="" class="img-fluid" />
                                    </a>
                                </div>
                                <a class="" data-toggle="collapse" href="#file-name-{{$img->id}}" role="button" aria-expanded="false" aria-controls="collapseExample">
                                    DETTAGLI
                                </a>
                                <div  class="file-name">
                                    <div class="collapse" id="file-name-{{$img->id}}">
                                        <small class="mb-2">Inserito il: {{$img->created_at->format('d/m/Y')}}</small>
                                    </div>
                                    <!-- pulsante per eliminare file -->
                                    <a href="{{url('/cms/file/destroy',[$img->id])}}" class="azione-red float-right elimina" title="elimina">
                                        <i class="fa fa-trash-o fa-2x"></i>
                                    </a>
                                    <!-- fine pulsante per eliminare file -->
                                    <div class="clearfix"></div>
                                </div>

                            </div>
                        </div>
                        @endforeach
                    </div>

                </div>
            </div>
            @endif
        </div>
    </div>
@endsection
@section('js_script')

    <!-- librerie per il sortable non possono essere messe nel layout perchè vanno in conflitto con summernote -->
    <script src="/cms_assets/js/plugins/jquery-ui/jquery-ui.min.js"></script>
    <script src="/cms_assets/js/plugins/touchpunch/jquery.ui.touch-punch.min.js"></script>
    <!-- -->
    <script>

        //per l'ordinamento delle immagini
        $(document).ready(function(){
            $("#sortable").sortable({
                update: function (event, ui)
                {
                    var order = [];
                    $('#sortable .file-box').each(function (e)
                    {
                        order.push($(this).attr('id') + '=' + ($(this).index() + 1));
                    });
                    var positions = order.join(';');
                    $.ajax({
                        type: "POST",
                        url: "{{url('cms/file/sort_images')}}",
                        data: "pos=" + positions + "&_token={{csrf_token()}}",
                        dataType: "html",
                        success: function (msg)
                        {
                            $("#responsosortable").fadeIn();
                            setTimeout(function (){$("#responsosortable").fadeOut();}, 2000);
                        }
                    });
                }
            });
        });
        //---//

        Dropzone.options.dropzoneForm =
            {
                paramName: "file", // The name that will be used to transfer the file
                maxFilesize: "{{ $max_file_size }}",
                maxFiles:"{{$file_restanti}}",
                dictDefaultMessage: "Trascina i file qui, oppure fai click.",
                dictFileTooBig: "Le dimensioni in byte del file sono troppo grandi",
                dictInvalidFileType: "Questo tipo di file non può essere caricato",
                dictMaxFilesExceeded:"Hai superato il limite max di file da cricare",
                acceptedFiles:"{{$extensions}}",
                error:function(error,msg){alert(msg);},

                queuecomplete: function(){showPreloader();location.reload();}
            };
    </script>
@stop