@extends('layouts.cms')
@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
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
                                                @if($cat->id == $pairing->category_id)
                                                    <option value="{{$cat->id}}" selected>{{$cat->nome_it}}</option>
                                                @else
                                                    <option value="{{$cat->id}}">{{$cat->nome_it}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label>Stile</label>
                                        <select name="style_id" id="style_id" class="form-control">
                                            <option value="">seleziona</option>
                                            @foreach($styles as $style)
                                                @if($style->id == $pairing->style_id)
                                                    <option value="{{$style->id}}" selected>{{$style->nome_it}}</option>
                                                @else
                                                    <option value="{{$style->id}}">{{$style->nome_it}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Prodotto 1*</label>
                                        <select name="product1_id" id="product1_id" class="form-control">
                                            <option value="">seleziona</option>
                                            @foreach($products as $product)
                                                @if($product->id == $pairing->product1_id)
                                                    <option value="{{$product->id}}" selected>{{$product->codice}}</option>
                                                @else
                                                    <option value="{{$product->id}}">{{$product->codice}}</option>
                                                @endif

                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label>Prodotto 2*</label>
                                        <select name="product2_id" id="product2_id" class="form-control">
                                            <option value="">seleziona</option>
                                            @foreach($products as $product)
                                                @if($product->id == $pairing->product2_id)
                                                    <option value="{{$product->id}}" selected>{{$product->codice}}</option>
                                                @else
                                                    <option value="{{$product->id}}">{{$product->codice}}</option>
                                                @endif
                                            @endforeach
                                        </select>
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
                                            <input type="text" value="{{$pairing->{'nome_'.$lang} }}" name="nome_{{$lang}}" id="nome_{{$lang}}" class="form-control mb-2" />
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
                                            <textarea id="desc_{{$lang}}"  style="min-height: 100px;" name="desc_{{$lang}}" class="form-control summernote mb-2"  >{{$pairing->{'desc_'.$lang} }}</textarea>
                                        </div>
                                    @endforeach
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
                style_id:{required:true},
                product1_id:{required:true},
                product2_id:{required:true},
            },
            messages: {
                @foreach($langs as $lang)
                nome_{{$lang}}:{required:'Questo campo è obbligatorio'},
                @endforeach
                category_id:{required:'Questo campo è obbligatorio'},
                style_id:{required:'Questo campo è obbligatorio'},
                product1_id:{required:'Questo campo è obbligatorio'},
                product2_id:{required:'Questo campo è obbligatorio'},
            },
            submitHandler: function (form)
            {
                $.ajax({
                    type: "PUT",
                    url: "{{route('pairing.update',[$pairing->id])}}",
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