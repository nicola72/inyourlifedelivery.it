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
                                    <div class="col-md-12">
                                        <div class="row">
                                            @if(!$old_days)
                                                <div class="col-md-6">
                                                    <h4>GIORNO</h4>
                                                    <h5>Lunedì</h5>
                                                    <div class="radio">
                                                        <label><input type="radio" name="lunedi_giorno" value="0" checked>Chiuso</label>
                                                    </div>
                                                    <div class="radio">
                                                        <label><input type="radio" name="lunedi_giorno" value="1">Aperto</label>
                                                    </div>
                                                    <br>
                                                    <h5>Martedì</h5>
                                                    <div class="radio">
                                                        <label><input type="radio" name="martedi_giorno" value="0" checked>Chiuso</label>
                                                    </div>
                                                    <div class="radio">
                                                        <label><input type="radio" name="martedi_giorno" value="1">Aperto</label>
                                                    </div>
                                                    <br>
                                                    <h5>Mercoledì</h5>
                                                    <div class="radio">
                                                        <label><input type="radio" name="mercoledi_giorno" value="0" checked>Chiuso</label>
                                                    </div>
                                                    <div class="radio">
                                                        <label><input type="radio" name="mercoledi_giorno" value="1">Aperto</label>
                                                    </div>
                                                    <br>
                                                    <h5>Giovedì</h5>
                                                    <div class="radio">
                                                        <label><input type="radio" name="giovedi_giorno" value="0" checked>Chiuso</label>
                                                    </div>
                                                    <div class="radio">
                                                        <label><input type="radio" name="giovedi_giorno" value="1">Aperto</label>
                                                    </div>
                                                    <br>
                                                    <h5>Venerdì</h5>
                                                    <div class="radio">
                                                        <label><input type="radio" name="venerdi_giorno" value="0" checked>Chiuso</label>
                                                    </div>
                                                    <div class="radio">
                                                        <label><input type="radio" name="venerdi_giorno" value="1">Aperto</label>
                                                    </div>
                                                    <br>
                                                    <h5>Sabato</h5>
                                                    <div class="radio">
                                                        <label><input type="radio" name="sabato_giorno" value="0" checked>Chiuso</label>
                                                    </div>
                                                    <div class="radio">
                                                        <label><input type="radio" name="sabato_giorno" value="1">Aperto</label>
                                                    </div>
                                                    <br>
                                                    <h5>Domenica</h5>
                                                    <div class="radio">
                                                        <label><input type="radio" name="domenica_giorno" value="0" checked>Chiuso</label>
                                                    </div>
                                                    <div class="radio">
                                                        <label><input type="radio" name="domenica_giorno" value="1">Aperto</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <h4>SERA</h4>
                                                    <h5>Lunedì</h5>
                                                    <div class="radio">
                                                        <label><input type="radio" name="lunedi_sera" value="0" checked>Chiuso</label>
                                                    </div>
                                                    <div class="radio">
                                                        <label><input type="radio" name="lunedi_sera" value="1">Aperto</label>
                                                    </div>
                                                    <br>
                                                    <h5>Martedì</h5>
                                                    <div class="radio">
                                                        <label><input type="radio" name="martedi_sera" value="0" checked>Chiuso</label>
                                                    </div>
                                                    <div class="radio">
                                                        <label><input type="radio" name="martedi_sera" value="1">Aperto</label>
                                                    </div>
                                                    <br>
                                                    <h5>Mercoledì</h5>
                                                    <div class="radio">
                                                        <label><input type="radio" name="mercoledi_sera" value="0" checked>Chiuso</label>
                                                    </div>
                                                    <div class="radio">
                                                        <label><input type="radio" name="mercoledi_sera" value="1">Aperto</label>
                                                    </div>
                                                    <br>
                                                    <h5>Giovedì</h5>
                                                    <div class="radio">
                                                        <label><input type="radio" name="giovedi_sera" value="0" checked>Chiuso</label>
                                                    </div>
                                                    <div class="radio">
                                                        <label><input type="radio" name="giovedi_sera" value="1">Aperto</label>
                                                    </div>
                                                    <br>
                                                    <h5>Venerdì</h5>
                                                    <div class="radio">
                                                        <label><input type="radio" name="venerdi_sera" value="0" checked>Chiuso</label>
                                                    </div>
                                                    <div class="radio">
                                                        <label><input type="radio" name="venerdi_sera" value="1">Aperto</label>
                                                    </div>
                                                    <br>
                                                    <h5>Sabato</h5>
                                                    <div class="radio">
                                                        <label><input type="radio" name="sabato_sera" value="0" checked>Chiuso</label>
                                                    </div>
                                                    <div class="radio">
                                                        <label><input type="radio" name="sabato_sera" value="1">Aperto</label>
                                                    </div>
                                                    <br>
                                                    <h5>Domenica</h5>
                                                    <div class="radio">
                                                        <label><input type="radio" name="domenica_sera" value="0" checked>Chiuso</label>
                                                    </div>
                                                    <div class="radio">
                                                        <label><input type="radio" name="domenica_sera" value="1">Aperto</label>
                                                    </div>
                                                </div>
                                            @else
                                                <div class="col-md-6">
                                                    <h4>GIORNO</h4>
                                                    <h5>Lunedì</h5>
                                                    <div class="radio">
                                                        <label><input type="radio" name="lunedi_giorno" value="0" {{(!$old_days->lunedi_giorno)? 'checked':''}}>Chiuso</label>
                                                    </div>
                                                    <div class="radio">
                                                        <label><input type="radio" name="lunedi_giorno" value="1" {{($old_days->lunedi_giorno)? 'checked':''}}>Aperto</label>
                                                    </div>
                                                    <br>
                                                    <h5>Martedì</h5>
                                                    <div class="radio">
                                                        <label><input type="radio" name="martedi_giorno" value="0" {{(!$old_days->martedi_giorno)? 'checked':''}}>Chiuso</label>
                                                    </div>
                                                    <div class="radio">
                                                        <label><input type="radio" name="martedi_giorno" value="1" {{($old_days->martedi_giorno)? 'checked':''}}>Aperto</label>
                                                    </div>
                                                    <br>
                                                    <h5>Mercoledì</h5>
                                                    <div class="radio">
                                                        <label><input type="radio" name="mercoledi_giorno" value="0" {{(!$old_days->mercoledi_giorno)? 'checked':''}}>Chiuso</label>
                                                    </div>
                                                    <div class="radio">
                                                        <label><input type="radio" name="mercoledi_giorno" value="1" {{($old_days->mercoledi_giorno)? 'checked':''}}>Aperto</label>
                                                    </div>
                                                    <br>
                                                    <h5>Giovedì</h5>
                                                    <div class="radio">
                                                        <label><input type="radio" name="giovedi_giorno" value="0" {{(!$old_days->giovedi_giorno)? 'checked':''}}>Chiuso</label>
                                                    </div>
                                                    <div class="radio">
                                                        <label><input type="radio" name="giovedi_giorno" value="1" {{($old_days->giovedi_giorno)? 'checked':''}}>Aperto</label>
                                                    </div>
                                                    <br>
                                                    <h5>Venerdì</h5>
                                                    <div class="radio">
                                                        <label><input type="radio" name="venerdi_giorno" value="0" {{(!$old_days->venerdi_giorno)? 'checked':''}}>Chiuso</label>
                                                    </div>
                                                    <div class="radio">
                                                        <label><input type="radio" name="venerdi_giorno" value="1" {{($old_days->venerdi_giorno)? 'checked':''}}>Aperto</label>
                                                    </div>
                                                    <br>
                                                    <h5>Sabato</h5>
                                                    <div class="radio">
                                                        <label><input type="radio" name="sabato_giorno" value="0" {{(!$old_days->sabato_giorno)? 'checked':''}}>Chiuso</label>
                                                    </div>
                                                    <div class="radio">
                                                        <label><input type="radio" name="sabato_giorno" value="1"{{($old_days->sabato_giorno)? 'checked':''}}>Aperto</label>
                                                    </div>
                                                    <br>
                                                    <h5>Domenica</h5>
                                                    <div class="radio">
                                                        <label><input type="radio" name="domenica_giorno" value="0" {{($old_days->domenica_giorno)? 'checked':''}}>Chiuso</label>
                                                    </div>
                                                    <div class="radio">
                                                        <label><input type="radio" name="domenica_giorno" value="1" {{($old_days->domenica_giorno)? 'checked':''}}>Aperto</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <h4>SERA</h4>
                                                    <h5>Lunedì</h5>
                                                    <div class="radio">
                                                        <label><input type="radio" name="lunedi_sera" value="0" {{(!$old_days->lunedi_sera)? 'checked':''}}>Chiuso</label>
                                                    </div>
                                                    <div class="radio">
                                                        <label><input type="radio" name="lunedi_sera" value="1" {{($old_days->lunedi_sera)? 'checked':''}}>Aperto</label>
                                                    </div>
                                                    <br>
                                                    <h5>Martedì</h5>
                                                    <div class="radio">
                                                        <label><input type="radio" name="martedi_sera" value="0" {{(!$old_days->martedi_sera)? 'checked':''}}>Chiuso</label>
                                                    </div>
                                                    <div class="radio">
                                                        <label><input type="radio" name="martedi_sera" value="1" {{($old_days->mertedi_sera)? 'checked':''}}>Aperto</label>
                                                    </div>
                                                    <br>
                                                    <h5>Mercoledì</h5>
                                                    <div class="radio">
                                                        <label><input type="radio" name="mercoledi_sera" value="0" {{(!$old_days->mercoledi_sera)? 'checked':''}}>Chiuso</label>
                                                    </div>
                                                    <div class="radio">
                                                        <label><input type="radio" name="mercoledi_sera" value="1" {{($old_days->mercoledi_sera)? 'checked':''}}>Aperto</label>
                                                    </div>
                                                    <br>
                                                    <h5>Giovedì</h5>
                                                    <div class="radio">
                                                        <label><input type="radio" name="giovedi_sera" value="0" {{(!$old_days->giovedi_sera)? 'checked':''}}>Chiuso</label>
                                                    </div>
                                                    <div class="radio">
                                                        <label><input type="radio" name="giovedi_sera" value="1" {{($old_days->giovedi_sera)? 'checked':''}}>Aperto</label>
                                                    </div>
                                                    <br>
                                                    <h5>Venerdì</h5>
                                                    <div class="radio">
                                                        <label><input type="radio" name="venerdi_sera" value="0" {{(!$old_days->venerdi_sera)? 'checked':''}}>Chiuso</label>
                                                    </div>
                                                    <div class="radio">
                                                        <label><input type="radio" name="venerdi_sera" value="1" {{($old_days->venerdi_sera)? 'checked':''}}>Aperto</label>
                                                    </div>
                                                    <br>
                                                    <h5>Sabato</h5>
                                                    <div class="radio">
                                                        <label><input type="radio" name="sabato_sera" value="0" {{(!$old_days->sabato_sera)? 'checked':''}}>Chiuso</label>
                                                    </div>
                                                    <div class="radio">
                                                        <label><input type="radio" name="sabato_sera" value="1" {{($old_days->sabato_sera)? 'checked':''}}>Aperto</label>
                                                    </div>
                                                    <br>
                                                    <h5>Domenica</h5>
                                                    <div class="radio">
                                                        <label><input type="radio" name="domenica_sera" value="0" {{(!$old_days->domenica_sera)? 'checked':''}}>Chiuso</label>
                                                    </div>
                                                    <div class="radio">
                                                        <label><input type="radio" name="domenica_sera" value="1" {{($old_days->domenica_sera)? 'checked':''}}>Aperto</label>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>

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
                    url: "{{url('cms/configurations/update_open_days',[$shop->id])}}",
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