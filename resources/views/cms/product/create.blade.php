@extends('layouts.cms')
@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox">

                    <!-- header del box -->
                    <div class="ibox-title">

                        <!-- Indietro -->
                        <a href="{{url('cms/product')}}" class="btn btn-w-m btn-primary">Prodotti</a>
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
                                        <label>Categoria*</label>
                                        <select name="category_id" id="category_id" class="form-control">
                                            <option value="">seleziona</option>
                                            @foreach($categorie as $cat)
                                                <option value="{{$cat->id}}">{{$cat->nome_it}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label>Codice</label>
                                        <input type="text" name="codice" id="codice" class="form-control mb-2" />
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                @foreach($langs as $lang)
                                    <div class="col-md-6">
                                        <label class="d-block">
                                            <img class="lang-icon" src="/img/cms/{{$lang}}.png" alt=""> Nome {{$lang}}*
                                        </label>
                                        <input type="text" name="nome_{{$lang}}" id="nome_{{$lang}}" class="form-control mb-2" />
                                    </div>
                                @endforeach
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                @foreach($langs as $lang)
                                    <div class="col-md-6">
                                        <label class="d-block">
                                            <img class="lang-icon" src="/img/cms/{{$lang}}.png" alt=""> Descrizione {{$lang}}
                                        </label>
                                        <textarea id="desc_{{$lang}}" style="min-height: 100px;" name="desc_{{$lang}}" class="form-control summernote mb-2"  ></textarea>
                                    </div>
                                @endforeach
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                @foreach($langs as $lang)
                                    <div class="col-md-6">
                                        <label class="d-block">
                                            <img class="lang-icon" src="/img/cms/{{$lang}}.png" alt=""> Descrizione Breve {{$lang}}
                                        </label>
                                        <textarea id="desc_breve_{{$lang}}" style="min-height: 100px;" name="desc_breve_{{$lang}}" class="form-control summernote mb-2"  ></textarea>
                                    </div>
                                @endforeach
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    @foreach($langs as $lang)
                                        <div class="col-md-6">
                                            <label class="d-block">
                                                <img class="lang-icon" src="/img/cms/{{$lang}}.png" alt=""> Misure {{$lang}}
                                            </label>
                                            <textarea id="misure_{{$lang}}" style="min-height: 100px;" name="misure_{{$lang}}" class="form-control summernote mb-2"  ></textarea>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Prezzo</label>
                                        <input type="text" name="prezzo" id="prezzo" class="form-control mb-2" />
                                    </div>
                                    <div class="col-md-6">
                                        <label>Prezzo scontato</label>
                                        <input type="text" name="prezzo_scontato" id="prezzo_scontato" class="form-control mb-2" />
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>Disponibilità</label>
                                        <select name="availability_id" id="availability_id" class="form-control" >
                                            @foreach($availabilities as $av)
                                                <option value="{{$av->id}}">{{$av->nome_it}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label>Peso</label>
                                        <input type="number" name="peso" id="peso" class="form-control mb-2" />
                                    </div>
                                    <div class="col-md-4">
                                        <label>Stock</label>
                                        <input type="number" value="1000" name="stock" id="stock" class="form-control mb-2" />
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label class="d-block">Acquistabile</label>
                                        <label class="radio-inline"><input type="radio" name="acquistabile" value="1" checked>Si</label>
                                        <label class="radio-inline"><input type="radio" name="acquistabile" value="0">No</label>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="d-block">Acquistabile Italfama</label>
                                        <label class="radio-inline"><input type="radio" name="acquistabile_italfama" value="1" checked>Si</label>
                                        <label class="radio-inline"><input type="radio" name="acquistabile_italfama" value="0">No</label>
                                    </div>

                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label class="d-block">Visibile</label>
                                        <label class="radio-inline"><input type="radio" name="visibile" value="1" checked>Si</label>
                                        <label class="radio-inline"><input type="radio" name="visibile" value="0">No</label>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="d-block">Visibile Italfama</label>
                                        <label class="radio-inline"><input type="radio" name="italfama" value="1" checked>Si</label>
                                        <label class="radio-inline"><input type="radio" name="italfama" value="0">No</label>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="d-block">Offerta</label>
                                        <label class="radio-inline"><input type="radio" name="offerta" value="1">Si</label>
                                        <label class="radio-inline"><input type="radio" name="offerta" value="0" checked>No</label>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="d-block">Novità</label>
                                        <label class="radio-inline"><input type="radio" name="novita" value="1">Si</label>
                                        <label class="radio-inline"><input type="radio" name="novita" value="0" checked>No</label>
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
                @foreach($langs as $lang)
                nome_{{$lang}}:{required:true},
                @endforeach
                category_id:{required:true},
                prezzo:{required:true},
            },
            messages: {
                @foreach($langs as $lang)
                nome_{{$lang}}:{required:'Questo campo è obbligatorio'},
                @endforeach
                category_id:{required:'Questo campo è obbligatorio'},
                prezzo:{required:'Questo campo è obbligatorio'},
            },
            submitHandler: function (form)
            {
                $.ajax({
                    type: "POST",
                    url: "{{url('cms/product')}}",
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