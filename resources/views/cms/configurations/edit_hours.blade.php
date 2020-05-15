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
                                        <h5>Giorno</h5>
                                    </div>
                                    <div class="col-md-6">
                                        <label>Ora inizio</label>
                                        <select name="start_morning" id="start_morning" class="form-control" data-placeholder="Seleziona">
                                            @if($old_hours)
                                                <option value="11:00:00" {{($old_hours->start_morning == '11:00:00') ? 'selected' : ''}}>11:00</option>
                                                <option value="11:30:00" {{($old_hours->start_morning == '11:30:00') ? 'selected' : ''}}>11:30</option>
                                                <option value="12:00:00" {{($old_hours->start_morning == '12:00:00') ? 'selected' : ''}}>12:00</option>
                                                <option value="12:30:00" {{($old_hours->start_morning == '12:30:00') ? 'selected' : ''}}>12:30</option>
                                                <option value="13:00:00" {{($old_hours->start_morning == '13:00:00') ? 'selected' : ''}}>13:00</option>
                                                <option value="13:30:00" {{($old_hours->start_morning == '13:30:00') ? 'selected' : ''}}>13:30</option>
                                                <option value="14:00:00" {{($old_hours->start_morning == '14:00:00') ? 'selected' : ''}}>14:00</option>
                                                <option value="14:30:00" {{($old_hours->start_morning == '14:30:00') ? 'selected' : ''}}>14:30</option>
                                                <option value="15:00:00" {{($old_hours->start_morning == '15:00:00') ? 'selected' : ''}}>15:00</option>
                                                <option value="15:30:00" {{($old_hours->start_morning == '15:30:00') ? 'selected' : ''}}>15:30</option>
                                            @else
                                                <option value="11:00:00">11:00</option>
                                                <option value="11:30:00">11:30</option>
                                                <option value="12:00:00">12:00</option>
                                                <option value="12:30:00">12:30</option>
                                                <option value="13:00:00">13:00</option>
                                                <option value="13:30:00">13:30</option>
                                                <option value="14:00:00">14:00</option>
                                                <option value="14:30:00">14:30</option>
                                                <option value="15:00:00">15:00</option>
                                                <option value="15:30:00">15:30</option>
                                            @endif

                                        </select>
                                        <label>Ora fine</label>
                                        <select name="end_morning" id="end_morning" class="form-control" data-placeholder="Seleziona">
                                            @if($old_hours)
                                                <option value="12:00:00" {{($old_hours->end_morning == '12:00:00') ? 'selected' : ''}}>12:00</option>
                                                <option value="12:30:00" {{($old_hours->end_morning == '12:30:00') ? 'selected' : ''}}>12:30</option>
                                                <option value="13:00:00" {{($old_hours->end_morning == '13:00:00') ? 'selected' : ''}}>13:00</option>
                                                <option value="13:30:00" {{($old_hours->end_morning == '13:30:00') ? 'selected' : ''}}>13:30</option>
                                                <option value="14:00:00" {{($old_hours->end_morning == '14:00:00') ? 'selected' : ''}}>14:00</option>
                                                <option value="14:30:00" {{($old_hours->end_morning == '14:30:00') ? 'selected' : ''}}>14:30</option>
                                                <option value="15:00:00" {{($old_hours->end_morning == '15:00:00') ? 'selected' : ''}}>15:00</option>
                                                <option value="15:30:00" {{($old_hours->end_morning == '15:30:00') ? 'selected' : ''}}>15:30</option>
                                                <option value="16:00:00" {{($old_hours->end_morning == '16:00:00') ? 'selected' : ''}}>16:00</option>
                                                <option value="16:30:00" {{($old_hours->end_morning == '16:30:00') ? 'selected' : ''}}>16:30</option>
                                            @else
                                                <option value="12:00:00">12:00</option>
                                                <option value="12:30:00">12:30</option>
                                                <option value="13:00:00">13:00</option>
                                                <option value="13:30:00">13:30</option>
                                                <option value="14:00:00">14:00</option>
                                                <option value="14:30:00">14:30</option>
                                                <option value="15:00:00">15:00</option>
                                                <option value="15:30:00">15:30</option>
                                                <option value="16:00:00">16:00</option>
                                                <option value="16:30:00">16:30</option>
                                            @endif

                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h5>Sera</h5>
                                    </div>
                                    <div class="col-md-6">
                                        <label>Ora inizio</label>
                                        <select name="start_afternoon" id="start_afternoon" class="form-control" data-placeholder="Seleziona">
                                            @if($old_hours)
                                                <option value="17:00:00" {{($old_hours->start_afternoon == '17:00:00') ? 'selected' : ''}}>17:00</option>
                                                <option value="17:30:00" {{($old_hours->start_afternoon == '17:30:00') ? 'selected' : ''}}>17:30</option>
                                                <option value="18:00:00" {{($old_hours->start_afternoon == '18:00:00') ? 'selected' : ''}}>18:00</option>
                                                <option value="18:30:00" {{($old_hours->start_afternoon == '18:30:00') ? 'selected' : ''}}>18:30</option>
                                                <option value="19:00:00" {{($old_hours->start_afternoon == '19:00:00') ? 'selected' : ''}}>19:00</option>
                                                <option value="19:30:00" {{($old_hours->start_afternoon == '19:30:00') ? 'selected' : ''}}>19:30</option>
                                                <option value="20:00:00" {{($old_hours->start_afternoon == '20:00:00') ? 'selected' : ''}}>20:00</option>
                                                <option value="20:30:00" {{($old_hours->start_afternoon == '20:30:00') ? 'selected' : ''}}>20:30</option>
                                                <option value="21:00:00" {{($old_hours->start_afternoon == '21:00:00') ? 'selected' : ''}}>21:00</option>
                                                <option value="21:30:00" {{($old_hours->start_afternoon == '21:30:00') ? 'selected' : ''}}>21:30</option>
                                            @else
                                                <option value="17:00:00">17:00</option>
                                                <option value="17:30:00">17:30</option>
                                                <option value="18:00:00">18:00</option>
                                                <option value="18:30:00">18:30</option>
                                                <option value="19:00:00">19:00</option>
                                                <option value="19:30:00">19:30</option>
                                                <option value="20:00:00">20:00</option>
                                                <option value="20:30:00">20:30</option>
                                                <option value="21:00:00">21:00</option>
                                                <option value="21:30:00">21:30</option>
                                            @endif

                                        </select>
                                        <label>Ora fine</label>
                                        <select name="end_afternoon" id="end_afternoon" class="form-control" data-placeholder="Seleziona">
                                            @if($old_hours)
                                                <option value="18:00:00" {{($old_hours->end_afternoon == '18:00:00') ? 'selected' : ''}}>18:00</option>
                                                <option value="18:30:00" {{($old_hours->end_afternoon == '18:30:00') ? 'selected' : ''}}>18:30</option>
                                                <option value="19:00:00" {{($old_hours->end_afternoon == '19:00:00') ? 'selected' : ''}}>19:00</option>
                                                <option value="19:30:00" {{($old_hours->end_afternoon == '19:30:00') ? 'selected' : ''}}>19:30</option>
                                                <option value="20:00:00" {{($old_hours->end_afternoon == '20:00:00') ? 'selected' : ''}}>20:00</option>
                                                <option value="20:30:00" {{($old_hours->end_afternoon == '20:30:00') ? 'selected' : ''}}>20:30</option>
                                                <option value="21:00:00" {{($old_hours->end_afternoon == '21:00:00') ? 'selected' : ''}}>21:00</option>
                                                <option value="21:30:00" {{($old_hours->end_afternoon == '21:30:00') ? 'selected' : ''}}>21:30</option>
                                                <option value="22:00:00" {{($old_hours->end_afternoon == '22:00:00') ? 'selected' : ''}}>22:00</option>
                                                <option value="22:30:00" {{($old_hours->end_afternoon == '22:30:00') ? 'selected' : ''}}>22:30</option>
                                                <option value="23:00:00" {{($old_hours->end_afternoon == '23:00:00') ? 'selected' : ''}}>23:00</option>
                                                <option value="23:30:00" {{($old_hours->end_afternoon == '23:30:00') ? 'selected' : ''}}>23:30</option>
                                            @else
                                                <option value="18:00:00">18:00</option>
                                                <option value="18:30:00">18:30</option>
                                                <option value="19:00:00">19:00</option>
                                                <option value="19:30:00">19:30</option>
                                                <option value="20:00:00">20:00</option>
                                                <option value="20:30:00">20:30</option>
                                                <option value="21:00:00">21:00</option>
                                                <option value="21:30:00">21:30</option>
                                                <option value="22:00:00">22:00</option>
                                                <option value="22:30:00">22:30</option>
                                                <option value="23:00:00">23:00</option>
                                                <option value="23:30:00">23:30</option>
                                            @endif

                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <span>* campi obbligatori</span>
                                        <br><br>
                                        <button class="btn btn-primary btn-lg w-100" type="submit">
                                            <i class="fa fa-dot-circle-o"></i> SALVA
                                        </button>
                                    </div>
                                </div>

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
                    url: "{{url('cms/configurations/update_hours',[$shop->id])}}",
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