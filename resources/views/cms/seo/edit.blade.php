@extends('layouts.cms')
@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox">

                    <!-- header del box -->
                    <div class="ibox-title">

                        <!-- Indietro -->
                        <a href="{{url('cms/seo')}}" class="btn btn-w-m btn-primary">Indietro</a>
                        <!-- fine pulsante nuovo -->

                        <div class="ibox-tools">
                            <a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <!-- fine header -->

                    <div class="ibox-content">
                        <form action="" method="POST" id="{{ $form_name }}">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Locale*</label>
                                        <select name="lang" id="lang" class="form-control">
                                            <option value="">seleziona</option>
                                            @foreach($langs as $lang)
                                                @if($lang == $seo->locale)
                                                    <option value="{{$lang}}" selected>{{$lang}}</option>
                                                @else
                                                    <option value="{{$lang}}" >{{$lang}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label>Title</label>
                                        <input type="text" value="{{$seo->title}}" name="title" id="title" class="form-control mb-2" />
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label>Description</label>
                                        <textarea name="description" id="description" class="form-control">{{$seo->description}}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label>H1</label>
                                        <input type="text" value="{{$seo->h1}}" name="h1" id="h1" class="form-control" />
                                    </div>
                                </div>

                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>H2</label>
                                        <input type="text" value="{{$seo->h2}}" name="h2" id="h2" class="form-control" />
                                    </div>
                                    <div class="col-md-6">
                                        <label>Alt</label>
                                        <input type="text" value="{{$seo->alt}}" name="alt" id="alt" class="form-control" />
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label>Keywords</label>
                                        <textarea name="keywords" id="keywords" class="form-control">{{$seo->keywords}}</textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <span>* campi obbligatori</span>
                                <br><br>
                                <button class="btn btn-primary btn-lg w-100" type="submit">
                                    <i class="fa fa-dot-circle-o"></i> SALVA
                                </button>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js_script')
    <script>
        $("#{{$form_name}}").validate({
            rules: {
                lang:{required:true},
            },
            messages: {
                lang:{required:'Questo campo è obbligatorio'},
            },
            submitHandler: function (form)
            {
                $.ajax({
                    type: "PUT",
                    url: "{{route('seo.update',[$seo->id])}}",
                    data: $("#{{$form_name}}").serialize(),
                    dataType: "json",
                    success: function (data)
                    {
                        if (data.result === 1)
                        {
                            alert(data.msg);
                            $(location).attr('href', data.url);
                        }
                        else{ alert( data.msg ); }
                    },
                    error: function (){ alert("Si è verificato un errore! Riprova!"); }
                });
            }
        });
    </script>
@endsection