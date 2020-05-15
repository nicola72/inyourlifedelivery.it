@extends('layouts.cms')
@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox">

                    <div class="ibox-content">
                        <div class="row mb-2 pb-2 border-bottom">

                            <!-- LOGO -->
                            <div class="col-md-4">
                                <div class="panel panel-primary">
                                    <div class="panel-heading">
                                        LOGO
                                    </div>
                                    <div class="panel-body">
                                        @if($logo)
                                            <img src="/file/{{$logo->path}}" alt="" class="img-fluid" />
                                        @endif
                                        <br>
                                        <br>
                                        <a class="btn btn-primary w-100" href="{{url('cms/configurations/edit_logo',$shop->id)}}">
                                            @if($logo)MODIFICA @else CARICA LOGO @endif
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <!-- -->

                            <!-- COMUNI CONSEGNA -->
                            <div class="col-md-4">
                                <div class="panel panel-primary">
                                    <div class="panel-heading">
                                        COMUNI DI CONSEGNA
                                    </div>
                                    <div class="panel-body">
                                        @if($comuni->count() > 0)
                                            <div class="mb-2">
                                                @foreach($comuni as $comune)
                                                    <div class="mb-2">
                                                        <h3><i class="fa fa-check"></i> {{$comune->comune}}</h3>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @else
                                            <div class="mb-2">
                                                <span>NESSUN COMUNE IMPOSTATO PER LA CONSEGNA</span>
                                            </div>

                                        @endif
                                        <br>
                                        <a class="btn btn-primary w-100" href="{{url('cms/configurations/edit_comuni',$shop->id)}}">
                                            {{($comuni->count() > 0 ? 'MODIFICA' : 'CONFIGURA')}}
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <!-- -->
                            <div class="col-md-4">
                                <div class="panel panel-primary">
                                    <div class="panel-heading">
                                        ORARI DI CONSEGNA/PRENOTAZIONE
                                    </div>
                                    <div class="panel-body">
                                        @if($hours)
                                            <table class="table">
                                                <tr>
                                                    <th></th>
                                                    <th>Dalle:</th>
                                                    <th>Alle:</th>
                                                </tr>
                                                <tr>
                                                    <td><b>Giorno</b></td>
                                                    <td>{{substr($hours->start_morning,0,-3)}}</td>
                                                    <td>{{substr($hours->end_morning,0,-3)}}</td>
                                                </tr>
                                                <tr>
                                                    <td><b>Sera</b></td>
                                                    <td>{{substr($hours->start_afternoon,0,-3)}}</td>
                                                    <td>{{substr($hours->end_afternoon,0,-3)}}</td>
                                                </tr>
                                            </table>
                                        @else
                                            <div class="mb-2">
                                                <span>NESSUN ORARIO IMPOSTATO</span>
                                            </div>
                                        @endif
                                        <br>
                                        <a class="btn btn-primary w-100" href="{{url('cms/configurations/edit_hours',$shop->id)}}">
                                            {{($hours ? 'MODIFICA' : 'CONFIGURA')}}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-2 pb-2 border-bottom">
                            <div class="col-md-4">
                                <div class="panel panel-primary">
                                    <div class="panel-heading">
                                        STEP INTERVALLI PRENOTAZIONE
                                    </div>
                                    <div class="panel-body">
                                        <form action="" method="POST" id="{{ $form_step }}">
                                            {{ csrf_field() }}
                                            @if($step)
                                                <select name="delivery_step" id="delivery_step" class="form-control mb-2" >
                                                    <option value="5" {{($step->step == 5) ? 'selected' : ''}}>5 minuti</option>
                                                    <option value="10" {{($step->step == 10) ? 'selected' : ''}}>10 minuti</option>
                                                    <option value="15" {{($step->step == 15) ? 'selected' : ''}}>15 minuti</option>
                                                    <option value="20" {{($step->step == 20) ? 'selected' : ''}}>20 minuti</option>
                                                    <option value="30" {{($step->step == 30) ? 'selected' : ''}}>30 minuti</option>
                                                </select>
                                            @else
                                                NON IMPOSTATO<br>
                                                <select name="delivery_step" id="delivery_step" class="form-control mb-2" >
                                                    <option value="5" >5 minuti</option>
                                                    <option value="10">10 minuti</option>
                                                    <option value="15">15 minuti</option>
                                                    <option value="20">20 minuti</option>
                                                    <option value="30">30 minuti</option>
                                                </select>
                                            @endif
                                            <button class="btn btn-primary btn-lg w-100" type="submit">
                                                <i class="fa fa-dot-circle-o"></i> SALVA
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="panel panel-primary">
                                    <div class="panel-heading">
                                        VALORE ORDINE MINIMO
                                    </div>
                                    <div class="panel-body">
                                        <form action="" method="POST" id="{{ $form_minimo }}">
                                            {{ csrf_field() }}
                                            @if($min)
                                                <input name="delivery_min" id="delivery_min" class="form-control mb-2" value="{{$min->min}}" />
                                            @else
                                                <input name="delivery_min" id="delivery_min" class="form-control mb-2" placeholder="scrivi qui" />
                                            @endif
                                            <button class="btn btn-primary btn-lg w-100" type="submit">
                                                <i class="fa fa-dot-circle-o"></i> SALVA
                                            </button>

                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="panel panel-primary">
                                    <div class="panel-heading">
                                        MAX QUANTITA' ORDINABILE
                                    </div>
                                    <div class="panel-body">
                                        <form action="" method="POST" id="{{ $form_maxqty }}">
                                            {{ csrf_field() }}
                                            <input type="number" min="1" class="form-control mb-2" name="max_qty" id="max_qty" placeholder="seleziona" value="{{($maxqty) ? $maxqty->qty : ''}}" />
                                            <button class="btn btn-primary btn-lg w-100" type="submit">
                                                <i class="fa fa-dot-circle-o"></i> SALVA
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-2 pb-2 border-bottom">
                            <div class="col-md-4">
                                <div class="panel panel-primary">
                                    <div class="panel-heading">
                                        SPESE DI CONSEGNA
                                    </div>
                                    <div class="panel-body">
                                        <form action="" method="POST" id="{{ $form_ship }}">
                                            {{ csrf_field() }}
                                            @if($ship_cost)
                                                <label class="d-block">Costo euro:</label>
                                                <input name="delivery_ship_cost" id="delivery_ship_cost" class="form-control mb-2" value="{{$ship_cost->cost}}" />
                                                <label class="d-block">Non applicate per ordini oltre euro:</label>
                                                <input name="delivery_ship_to" id="delivery_ship_to" class="form-control mb-2" value="{{$ship_cost->to}}" />
                                            @else
                                                <label class="d-block">Costo euro:</label>
                                                <input name="delivery_ship_cost" id="delivery_ship_cost" placeholder="es. 1.50" class="form-control mb-2" />
                                                <label class="d-block">Non applicate per ordini oltre euro:</label>
                                                <input name="delivery_ship_to" id="delivery_ship_to" placeholder="es. 20.00" class="form-control mb-2" />
                                            @endif
                                            <button class="btn btn-primary btn-lg w-100" type="submit">
                                                <i class="fa fa-dot-circle-o"></i> SALVA
                                            </button>

                                        </form>
                                    </div>
                                </div>

                            </div>
                            <div class="col-md-8">
                                <div class="panel panel-primary">
                                    <div class="panel-heading">
                                        DESCRIZIONE ATTIVITA'
                                    </div>
                                    <div class="panel-body">
                                        <form action="" method="POST" id="{{ $form_description }}">
                                            {{ csrf_field() }}
                                            <textarea name="delivery_desc" id="delivery_desc" style="min-height:133px" class="form-control mb-2">{{($description)? $description->desc : ''}}</textarea>
                                            <button class="btn btn-primary btn-lg w-100" type="submit">
                                                <i class="fa fa-dot-circle-o"></i> SALVA
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-2 pb-2 border-bottom">
                            <div class="col-md-6">
                                <div class="panel panel-primary">
                                    <div class="panel-heading">
                                        GIORNI DI APERTURA/CHIUSURA
                                    </div>
                                    <div class="panel-body">
                                        @if($opendays)
                                            <table class="table">
                                                <tr>
                                                    <th></th>
                                                    <th>Giorno</th>
                                                    <th>Sera</th>
                                                </tr>
                                                <tr>
                                                    <td><b>Lunedì</b></td>
                                                    <td>{!! $opendays->lunedi_giorno == 1 ? '<span class="badge badge-primary">Aperto</span>':'<span class="badge badge-danger">Chiuso</span>' !!}</td>
                                                    <td>{!! $opendays->lunedi_sera == 1 ? '<span class="badge badge-primary">Aperto</span>':'<span class="badge badge-danger">Chiuso</span>' !!}</td>
                                                </tr>
                                                <tr>
                                                    <td><b>Martedì</b></td>
                                                    <td>{!! $opendays->martedi_giorno == 1 ? '<span class="badge badge-primary">Aperto</span>':'<span class="badge badge-danger">Chiuso</span>' !!}</td>
                                                    <td>{!! $opendays->martedi_sera == 1 ? '<span class="badge badge-primary">Aperto</span>':'<span class="badge badge-danger">Chiuso</span>' !!}</td>
                                                </tr>
                                                <tr>
                                                    <td><b>Mercoledì</b></td>
                                                    <td>{!! $opendays->mercoledi_giorno == 1 ? '<span class="badge badge-primary">Aperto</span>':'<span class="badge badge-danger">Chiuso</span>' !!}</td>
                                                    <td>{!! $opendays->mercoledi_sera == 1 ? '<span class="badge badge-primary">Aperto</span>':'<span class="badge badge-danger">Chiuso</span>' !!}</td>
                                                </tr>
                                                <tr>
                                                    <td><b>Giovedì</b></td>
                                                    <td>{!! $opendays->giovedi_giorno == 1 ? '<span class="badge badge-primary">Aperto</span>':'<span class="badge badge-danger">Chiuso</span>' !!}</td>
                                                    <td>{!! $opendays->giovedi_sera == 1 ? '<span class="badge badge-primary">Aperto</span>':'<span class="badge badge-danger">Chiuso</span>' !!}</td>
                                                </tr>
                                                <tr>
                                                    <td><b>Venerdì</b></td>
                                                    <td>{!! $opendays->venerdi_giorno == 1 ? '<span class="badge badge-primary">Aperto</span>':'<span class="badge badge-danger">Chiuso</span>' !!}</td>
                                                    <td>{!! $opendays->venerdi_sera == 1 ? '<span class="badge badge-primary">Aperto</span>':'<span class="badge badge-danger">Chiuso</span>' !!}</td>
                                                </tr>
                                                <tr>
                                                    <td><b>Sabato</b></td>
                                                    <td>{!! $opendays->sabato_giorno == 1 ? '<span class="badge badge-primary">Aperto</span>':'<span class="badge badge-danger">Chiuso</span>' !!}</td>
                                                    <td>{!! $opendays->sabato_sera == 1 ? '<span class="badge badge-primary">Aperto</span>':'<span class="badge badge-danger">Chiuso</span>' !!}</td>
                                                </tr>
                                                <tr>
                                                    <td><b>Domenica</b></td>
                                                    <td>{!! $opendays->domenica_giorno == 1 ? '<span class="badge badge-primary">Aperto</span>':'<span class="badge badge-danger">Chiuso</span>' !!}</td>
                                                    <td>{!! $opendays->domenica_sera == 1 ? '<span class="badge badge-primary">Aperto</span>':'<span class="badge badge-danger">Chiuso</span>' !!}</td>
                                                </tr>
                                            </table>
                                        @endif
                                        <br>
                                        <a class="btn btn-primary w-100" href="{{url('cms/configurations/edit_open_days',$shop->id)}}">
                                            {{($hours ? 'MODIFICA' : 'CONFIGURA')}}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-2 pb-2 border-bottom">
                            <div class="col-md-4">
                                <div class="panel panel-primary">
                                    <div class="panel-heading">
                                        MAX MINUTI PRE ORDINAZIONE
                                    </div>
                                    <div class="panel-body">
                                        <form action="" method="POST" id="{{ $form_time }}">
                                            {{ csrf_field() }}
                                            <select name="availabletime" id="availabletime" class="form-control mb-2">
                                                @if($availabletime)
                                                    <option value="0">Non impostato</option>
                                                    <option value="10" {{($availabletime->time == 10)? 'selected':''}}>10 minuti</option>
                                                    <option value="30" {{($availabletime->time == 30)? 'selected':''}}>30 minuti</option>
                                                    <option value="60" {{($availabletime->time == 60)? 'selected':''}}>1 ora</option>
                                                    <option value="120" {{($availabletime->time == 120)? 'selected':''}}>2 ore</option>
                                                @else
                                                    <option value="0">Non impostato</option>
                                                    <option value="10">10 minuti</option>
                                                    <option value="30">30 minuti</option>
                                                    <option value="60">1 ora</option>
                                                    <option value="120">2 ore</option>
                                                @endif
                                            </select>

                                            <button class="btn btn-primary btn-lg w-100" type="submit">
                                                <i class="fa fa-dot-circle-o"></i> SALVA
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="panel panel-primary">
                                    <div class="panel-heading">
                                        EMAIL PAYPAL
                                    </div>
                                    <div class="panel-body">
                                        <form action="" method="POST" id="{{ $form_paypal }}">
                                            {{ csrf_field() }}
                                            <input type="email" class="form-control mb-2" name="email_paypal" id="email_paypal" value="{{($paypal) ? $paypal->email : ''}}" />
                                            <button class="btn btn-primary btn-lg w-100" type="submit">
                                                <i class="fa fa-dot-circle-o"></i> SALVA
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js_script')
    <script>
        $("#{{$form_step}}").validate({
            rules: {
            },
            messages: {
            },
            submitHandler: function (form)
            {
                $.ajax({
                    type: "POST",
                    url: "{{url('cms/configurations/update_step',[$shop->id])}}",
                    data: $("#{{$form_step}}").serialize(),
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

        $("#{{$form_paypal}}").validate({
            rules: {
            },
            messages: {
            },
            submitHandler: function (form)
            {
                $.ajax({
                    type: "POST",
                    url: "{{url('cms/configurations/update_paypal',[$shop->id])}}",
                    data: $("#{{$form_paypal}}").serialize(),
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

        $("#{{$form_minimo}}").validate({
            rules: {
            },
            messages: {
            },
            submitHandler: function (form)
            {
                $.ajax({
                    type: "POST",
                    url: "{{url('cms/configurations/update_min',[$shop->id])}}",
                    data: $("#{{$form_minimo}}").serialize(),
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

        $("#{{$form_description}}").validate({
            rules: {
            },
            messages: {
            },
            submitHandler: function (form)
            {
                $.ajax({
                    type: "POST",
                    url: "{{url('cms/configurations/update_desc',[$shop->id])}}",
                    data: $("#{{$form_description}}").serialize(),
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

        $("#{{$form_time}}").validate({
            rules: {
            },
            messages: {
            },
            submitHandler: function (form)
            {
                $.ajax({
                    type: "POST",
                    url: "{{url('cms/configurations/update_time',[$shop->id])}}",
                    data: $("#{{$form_time}}").serialize(),
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

        $("#{{$form_maxqty}}").validate({
            rules: {
            },
            messages: {
            },
            submitHandler: function (form)
            {
                $.ajax({
                    type: "POST",
                    url: "{{url('cms/configurations/update_maxqty',[$shop->id])}}",
                    data: $("#{{$form_maxqty}}").serialize(),
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

        $("#{{$form_ship}}").validate({
            rules: {
            },
            messages: {
            },
            submitHandler: function (form)
            {
                $.ajax({
                    type: "POST",
                    url: "{{url('cms/configurations/update_shipping_cost',[$shop->id])}}",
                    data: $("#{{$form_ship}}").serialize(),
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
@stop
