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
                        <div class="row mb-2 pb-2 border-bottom">
                            <div class="col-md-12">
                                <h3>LOGO</h3>
                            </div>
                            <div class="col-md-10">
                                @if($logo)
                                    <div class="mb-2">
                                        <img src="/file/{{$logo->path}}" alt="" class="img-fluid" style="max-width:200px;max-height:100px" />
                                    </div>
                                    <a class="btn btn-primary" href="{{url('cms/configurations/edit_logo',$shop->id)}}">
                                        modifica
                                    </a>
                                @else
                                    <div class="mb-2">
                                        <span>NON IMPOSTATO</span>
                                    </div>

                                    <a class="btn btn-primary" href="{{url('cms/configurations/edit_logo',$shop->id)}}">
                                        carica logo
                                    </a>
                                @endif

                            </div>
                            <div class="col-md-2">

                            </div>
                        </div>
                        <div class="row mb-2 pb-2 border-bottom">
                            <div class="col-md-12">
                                <h3>COMUNI DI CONSEGNA</h3>
                            </div>
                            <div class="col-md-12">
                                @if($comuni->count() > 0)
                                    <div class="mb-2">
                                        <ul>
                                            @foreach($comuni as $comune)
                                            <li>
                                                {{$comune->comune}}
                                            </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    <a class="btn btn-primary" href="{{url('cms/configurations/edit_comuni',$shop->id)}}">
                                        modifica
                                    </a>
                                @else
                                    <div class="mb-2">
                                        <span>NESSUN COMUNE IMPOSTATO PER LA CONSEGNA</span>
                                    </div>
                                    <a class="btn btn-primary" href="{{url('cms/configurations/edit_comuni',$shop->id)}}">
                                        configura
                                    </a>
                                @endif
                            </div>
                        </div>
                        <div class="row mb-2 pb-2 border-bottom">
                            <div class="col-md-12">
                                <h3>FASCE ORARIE DI CONSEGNA/PRENOTAZIONE</h3>
                            </div>
                            <div class="col-md-12">
                                @if($hours)
                                    <h4>Il Giorno dalle: {{$hours->start_morning}} alle: {{$hours->end_morning}}</h4>
                                    <h4>La Sera dalle: {{$hours->start_afternoon}} alle: {{$hours->end_afternoon}}</h4>
                                    <br>
                                    <a class="btn btn-primary" href="{{url('cms/configurations/edit_hours',$shop->id)}}">
                                        modifica
                                    </a>
                                @else
                                    <br>
                                    <a class="btn btn-primary" href="{{url('cms/configurations/edit_hours',$shop->id)}}">
                                        configura
                                    </a>
                                @endif
                            </div>
                        </div>
                        <div class="row mb-2 pb-2 border-bottom">
                            <div class="col-md-12">
                                <h3>STEP INTERVALLI PRENOTAZIONE</h3>
                            </div>
                            <div class="col-md-12">
                                <form action="" method="POST" id="{{ $form_step }}">
                                    {{ csrf_field() }}
                                    <div class="row">
                                        <div class="col-md-6">
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
                                        </div>
                                    </div>

                                </form>
                            </div>
                        </div>
                        <div class="row mb-2 pb-2 border-bottom">
                            <div class="col-md-12">
                                <h3>MINIMO ORDINE EURO</h3>
                            </div>
                            <div class="col-md-12">
                                <form action="" method="POST" id="{{ $form_minimo }}">
                                    {{ csrf_field() }}
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label class="d-block">Inserire un numero separato da virgola o punto. 0 per nessun minimo</label>
                                            @if($min)
                                                <input name="delivery_min" id="delivery_min" class="form-control mb-2" value="{{$min->min}}" />
                                            @else
                                                NON IMPOSTATO<br>
                                                <input name="delivery_min" id="delivery_min" class="form-control mb-2" />
                                            @endif
                                            <button class="btn btn-primary btn-lg w-100" type="submit">
                                                <i class="fa fa-dot-circle-o"></i> SALVA
                                            </button>
                                        </div>
                                    </div>

                                </form>
                            </div>
                        </div>
                        <div class="row mb-2 pb-2 border-bottom">
                            <div class="col-md-12">
                                <h3>SPESE DI CONSEGNA EURO</h3>
                            </div>
                            <div class="col-md-12">
                                <form action="" method="POST" id="{{ $form_ship }}">
                                    {{ csrf_field() }}
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label class="d-block">Non compilare se non sono presenti spese di spedizione</label>
                                            <label class="d-block">Inserire un numero separato da virgola o punto</label>
                                            @if($ship_cost)
                                                <label class="d-block">Costo</label>
                                                <input name="delivery_ship_cost" id="delivery_ship_cost" class="form-control mb-2" value="{{$ship_cost->cost}}" />
                                                <label class="d-block">Fino a</label>
                                                <input name="delivery_ship_to" id="delivery_ship_to" class="form-control mb-2" value="{{$ship_cost->to}}" />
                                            @else
                                                NON IMPOSTATO<br>
                                                <label class="d-block">Costo</label>
                                                <input name="delivery_ship_cost" id="delivery_ship_cost" class="form-control mb-2" />
                                                <label class="d-block">Fino a</label>
                                                <input name="delivery_ship_to" id="delivery_ship_to" class="form-control mb-2" />
                                            @endif
                                            <button class="btn btn-primary btn-lg w-100" type="submit">
                                                <i class="fa fa-dot-circle-o"></i> SALVA
                                            </button>
                                        </div>
                                    </div>

                                </form>
                            </div>
                        </div>
                        <div class="row mb-2 pb-2 border-bottom">
                            <div class="col-md-12">
                                <h3>GIORNI DI APERTURA/CHIUSURA</h3>
                            </div>
                            <div class="col-md-12">
                                @if($opendays)
                                    <div>
                                        <div class="mb-2">
                                            <b>Lunedì</b>:
                                            <br>
                                            Giorno {{$opendays->lunedi_giorno == 1 ? 'Aperto':'Chiuso'}}
                                            <br>
                                            Sera {{$opendays->lunedi_sera == 1 ? 'Aperto':'Chiuso'}}
                                        </div>
                                        <div class="mb-2">
                                            <b>Martedì</b>:
                                            <br>
                                            Giorno {{$opendays->martedi_giorno == 1 ? 'Aperto':'Chiuso'}}
                                            <br>
                                            Sera {{$opendays->martedi_sera == 1 ? 'Aperto':'Chiuso'}}
                                        </div>
                                        <div class="mb-2">
                                            <b>Mercoledì</b>:
                                            <br>
                                            Giorno {{$opendays->mercoledi_giorno == 1 ? 'Aperto':'Chiuso'}}
                                            <br>
                                            Sera {{$opendays->mercoledi_sera == 1 ? 'Aperto':'Chiuso'}}
                                        </div>
                                        <div class="mb-2">
                                            <b>Giovedì</b>:
                                            <br>
                                            Giorno {{$opendays->giovedi_giorno == 1 ? 'Aperto':'Chiuso'}}
                                            <br>
                                            Sera {{$opendays->giovedi_sera == 1 ? 'Aperto':'Chiuso'}}
                                        </div>
                                        <div class="mb-2">
                                            <b>Venerdì</b>:
                                            <br>
                                            Giorno {{$opendays->venerdi_giorno == 1 ? 'Aperto':'Chiuso'}}
                                            <br>
                                            Sera {{$opendays->venerdi_sera == 1 ? 'Aperto':'Chiuso'}}
                                        </div>
                                        <div class="mb-2">
                                            <b>Sabato</b>:
                                            <br>Giorno {{$opendays->sabato_giorno == 1 ? 'Aperto':'Chiuso'}}
                                            <br>
                                            Sera {{$opendays->sabato_sera == 1 ? 'Aperto':'Chiuso'}}
                                        </div>
                                        <div class="mb-2">
                                            <b>Domenica</b>:
                                            <br>Giorno {{$opendays->domenica_giorno == 1 ? 'Aperto':'Chiuso'}}
                                            <br>
                                            Sera {{$opendays->domenica_sera == 1 ? 'Aperto':'Chiuso'}}
                                        </div>
                                    </div>
                                    <a class="btn btn-primary" href="{{url('cms/configurations/edit_open_days',$shop->id)}}">
                                        modifica
                                    </a>
                                @else
                                    <br>
                                    <a class="btn btn-primary" href="{{url('cms/configurations/edit_open_days',$shop->id)}}">
                                        configura
                                    </a>
                                @endif
                            </div>
                        </div>
                        <div class="row mb-2 pb-2 border-bottom">
                            <div class="col-md-12">
                                <h3>DESCRIZIONE</h3>
                            </div>
                            <div class="col-md-6">
                                <form action="" method="POST" id="{{ $form_description }}">
                                    {{ csrf_field() }}
                                    <textarea name="delivery_desc" id="delivery_desc" class="form-control mb-2">{{($description)? $description->desc : ''}}</textarea>
                                    <button class="btn btn-primary btn-lg w-100" type="submit">
                                        <i class="fa fa-dot-circle-o"></i> SALVA
                                    </button>
                                </form>
                            </div>
                        </div>
                        <div class="row mb-2 pb-2 border-bottom">
                            <div class="col-md-12">
                                <h3>MAX QUANTITA' ORDINABILE</h3>
                            </div>
                            <div class="col-md-4">
                                <form action="" method="POST" id="{{ $form_maxqty }}">
                                    {{ csrf_field() }}
                                    <input type="number" min="1" class="form-control mb-2" name="max_qty" id="max_qty" value="{{($maxqty) ? $maxqty->qty : ''}}" />
                                    <button class="btn btn-primary btn-lg w-100" type="submit">
                                        <i class="fa fa-dot-circle-o"></i> SALVA
                                    </button>
                                </form>
                            </div>
                        </div>
                        <div class="row mb-2 pb-2 border-bottom">
                            <div class="col-md-12">
                                <h3>ENTRO QUANTI MINUTI PRIMA SI PUO' ORDINARE</h3>
                            </div>
                            <div class="col-md-6">
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
                        <div class="row mb-2 pb-2 border-bottom">
                            <div class="col-md-12">
                                <h3>EMAIL PAYPAL</h3>
                            </div>
                            <div class="col-md-4">
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
