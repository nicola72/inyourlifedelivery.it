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
                                        <select name="category_id" id="category_id" class="form-control" onchange="get_ingredients_and_variants()">
                                            <option value="">seleziona</option>
                                            @foreach($categorie as $cat)
                                                @if($cat->id == $product->category_id)
                                                    <option value="{{$cat->id}}" selected>{{$cat->nome_it}}</option>
                                                @else
                                                    <option value="{{$cat->id}}">{{$cat->nome_it}}</option>
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
                                            <input value="{{$product->{'nome_'.$lang} }}" type="text" name="nome_{{$lang}}" id="nome_{{$lang}}" class="form-control mb-2" />
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
                                            <textarea id="desc_{{$lang}}" style="min-height: 100px;" name="desc_{{$lang}}" class="form-control summernote mb-2"  >{{$product->{'desc_'.$lang} }}</textarea>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="d-block">Disponibile per</label>
                                        <label class="radio-inline"><input type="radio" name="per_quando" value="entrambi" {{($product->pranzo == 1 && $product->cena == 1) ? 'checked':''}}> Pranzo e Cena</label>
                                        <label class="radio-inline"><input type="radio" name="per_quando" value="solo_pranzo" {{($product->pranzo == 1 && $product->cena == 0) ? 'checked':''}}> Solo Pranzo</label>
                                        <label class="radio-inline"><input type="radio" name="per_quando" value="solo_cena" {{($product->pranzo == 0 && $product->cena == 1) ? 'checked':''}}> Solo Cena</label>
                                    </div>

                                </div>
                            </div>
                            <div id="ingredients_and_variants">
                                <div class="form-group">
                                    <div class="row">
                                        @if($ingredients->count() > 0)
                                            <div class="col-md-6">
                                                <label>Ingredienti <small>(quelli già presenti nel prodotto)</small></label>
                                                <select name="ingredients[]" id="ingredients" class="chosen-select" data-placeholder="Seleziona" multiple style="width:350px;">
                                                    @foreach($ingredients as $ingredient)
                                                        @if(in_array($ingredient->id,$ing_selected))
                                                            <option value="{{$ingredient->id}}" selected>{{$ingredient->nome_it}}</option>
                                                        @else
                                                            <option value="{{$ingredient->id}}">{{$ingredient->nome_it}}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                        @endif
                                        @if($variants->count() > 0)
                                            <div class="col-md-4">
                                                <label>Varianti <small>(stabilisci le varianti da poter scegliere)</small></label>
                                                <select name="variants[]" id="variants" class="chosen-select" data-placeholder="Seleziona" multiple style="width:350px;">
                                                    @foreach($variants as $variant)
                                                        @if(in_array($variant->id,$var_selected))
                                                            <option value="{{$variant->id}}" selected>{{$variant->nome_it}}</option>
                                                        @else
                                                            <option value="{{$variant->id}}">{{$variant->nome_it}}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Prezzo</label>
                                        <input value="{{$product->prezzo}}" type="text" name="prezzo" id="prezzo" class="form-control mb-2" />
                                    </div>
                                    <div class="col-md-6">
                                        <label>Prezzo scontato</label>
                                        <input value="{{$product->prezzo_scontato}}" type="text" name="prezzo_scontato" id="prezzo_scontato" class="form-control mb-2" />
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
        //per la multiselect
        $('.chosen-select').chosen({width: "100%"});

        //ajax per prendere le varianti e gli ingredienti della categoria selezionata
        function get_ingredients_and_variants()
        {
            let category_id = $('#category_id').val();

            $.ajax({
                type :"GET",
                url: "{{url('cms/product/ingredients_and_variants')}}",
                data:{'category_id':category_id },
                dataType: "json",
                success: function (data)
                {
                    if (data.result === 1)
                    {
                        $('#ingredients_and_variants').html(data.msg);
                    }
                    else{ alert( data.msg ); }
                },
                error: function (){ alert("Si è verificato un errore! Riprova!"); }
            });
        }

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
                    type: "PUT",
                    url: "{{route('product.update',[$product->id])}}",
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