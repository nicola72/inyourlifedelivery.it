@extends('layouts.cms')
@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-5">
                <div class="ibox">
                    <!-- header del box -->
                    <div class="ibox-title">

                        <!-- Indietro -->
                        @if($user->role_id != 1)
                        <a href="{{url('cms/configurations')}}" class="btn btn-w-m btn-primary">Indietro</a>
                        @else
                            <a href="{{url('cms/configurations/shop_config',$shop->id)}}" class="btn btn-w-m btn-primary">Indietro</a>
                        @endif
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
                            <form action="{{url('cms/configurations/upload_logo')}}" class="dropzone" id="dropzoneForm">
                                {{ csrf_field() }}
                                <input type="hidden" name="fileable_id" id="fileable_id" value="{{$shop->id}}" />
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
                                    Puoi caricare il logo... se ne hai già caricato uno il prossimo andrà a
                                    sostituirsi a quello vecchio
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

            </div>
            @if($logo)
                <div class="col-lg-7 animated fadeInRight">
                    <div class="row">
                        <div id="sortable" class="col-md-12 sortable">
                            <div id="{{$logo->id}}" class="file-box" style="cursor: pointer">
                                <div class="file">

                                    <span class="corner"></span>

                                    <div class="image">
                                        <a href="/file/{{$logo->path}}"  data-gallery="">
                                            <img src="/file/{{$logo->path}}" alt="" class="img-fluid"  />
                                        </a>
                                    </div>
                                    <a class="" data-toggle="collapse" href="#file-name-{{$logo->id}}" role="button" aria-expanded="false" aria-controls="collapseExample">
                                        DETTAGLI
                                    </a>
                                    <div  class="file-name">
                                        <div class="collapse" id="file-name-{{$logo->id}}">
                                            <small class="mb-2">Inserito il: {{$logo->created_at->format('d/m/Y')}}</small>
                                        </div>

                                        <!-- pulsante per eliminare file -->
                                        <a href="{{url('/cms/file/destroy',[$logo->id])}}" class="azione-red float-right elimina" title="elimina">
                                            <i class="fa fa-trash-o fa-2x"></i>
                                        </a>
                                        <!-- fine pulsante per eliminare file -->
                                        <div class="clearfix"></div>
                                    </div>

                                </div>
                            </div>
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
                error:function(error,msg){alert(msg);return},

                queuecomplete: function(){showPreloader();location.reload();}
            };
    </script>
@stop