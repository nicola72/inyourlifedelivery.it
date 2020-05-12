@extends('layouts.cms')
@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox">

                    <!-- header del box -->
                    <div class="ibox-title">

                        <!-- Indietro -->
                        <a href="{{url('cms/configurations')}}" class="btn btn-w-m btn-primary">Indietro</a>
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
                                        <label>Comuni*</label>
                                        <select name="comuni[]" id="comuni" class="chosen-select" data-placeholder="Seleziona" multiple style="width:350px;">
                                            @foreach($comuni as $comune)
                                                @if(in_array($comune['comune'],$selected))
                                                    <option value="{{$comune['comune']}}" selected>{{$comune['comune']}}</option>
                                                @else
                                                    <option value="{{$comune['comune']}}">{{$comune['comune']}}</option>
                                                @endif

                                            @endforeach
                                        </select>
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

        $("#{{$form_name}}").validate({
            rules: {
            },
            messages: {
            },
            submitHandler: function (form)
            {
                $.ajax({
                    type: "POST",
                    url: "{{url('cms/configurations/update_comuni',[$shop->id])}}",
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