@extends('layouts.website')
@section('content')

    <!-- titolo step 1 -->
    <a name="ordina"></a>
    <section id="reviews" style="background-color:#ececec;padding-top:140px;">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb10 m-auto wow zoomInDown" data-wow-delay=".1s">
                    <div class="client-reviews-card-active due">
                        <div class="client-reviews-author ">
                            <h4 class="text-center active-step">Scegli l'orario di consegna</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--  -->

    <div id="main-page" class="col-md-12" style="background-color:#fff;">
        <form id="form_ordinazione" method="post" >
            @if(!$aperto_il_giorno && !$aperto_la_sera)
                <div class="row pb50 pt50">
                    <div class="col-md-12 text-center">
                        La nostra attività oggi è chiusa...<br>
                        Non possiamo accettare ordinazioni<br>
                        Torna presto a trovarci.
                    </div>
                </div>
            @elseif(!$possibile_ordinare_il_giorno && !$possibile_ordinare_la_sera)
                <div class="row pb50 pt50">
                    <div class="col-md-12 text-center">
                        Spiacente...<br>
                        In questo orario non possiamo più accettare ordinazioni.<br>
                        Torna presto a trovarci.
                    </div>
                </div>
            @else
                <div class="row">
                    @if($possibile_ordinare_il_giorno && $aperto_il_giorno)
                        <div class="col-md-12 pt20">
                            <div class="form-group row">
                                <div class="col-sm-4 col-md-2 m-auto">
                                    <label class="d-block">PER IL GIORNO</label>
                                    <div class="input-group input-append">
                                        <input id="timepicker1" name="orario_mattina" type="text" class="form-control" placeholder="Scegli">
                                        <span class="input-group-prepend last add-on">
                                            <span class="input-group-text">
                                                <i class="icon-clock"></i>
                                            </span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                </div>

                <div class="row">
                    @if($possibile_ordinare_la_sera && $aperto_la_sera)
                        <div class="col-md-12 pt20">
                            <div class="form-group row">
                                <div class="col-sm-4 col-md-2 m-auto">
                                    <label class="d-block">PER LA SERA</label>
                                    <div class="input-group input-append">
                                        <input id="timepicker2" name="orario_sera" type="text" class="form-control" placeholder="Scegli">
                                        <span class="input-group-prepend last add-on">
                                            <span class="input-group-text">
                                                <i class="icon-clock"></i>
                                            </span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                </div>
            @endif
        </form>
        <!-- -->
    </div>

@endsection
@section('js_script')
    <script>
        $(document).ready(function(){
            $('#timepicker1').timepicker({
                timeFormat: 'HH:mm',
                interval:'{{$shop->deliveryStep->step}}',
                minTime: '{{$orario_partenza_giorno}}',
                maxTime: '{{$shop->deliveryHour->end_morning}}'
            });
        });

        $(document).ready(function(){
            $('#timepicker2').timepicker({
                timeFormat: 'HH:mm',
                interval:'{{$shop->deliveryStep->step}}',
                minTime: '{{$now}}',
                maxTime: '{{$shop->deliveryHour->end_afternoon}}'
            });
        });

        function validateHhMm(inputField)
        {
            var isValid = /^([0-9]|0[0-9]|1[0-9]|2[0-3]):[0-5][0-9]$/.test(inputField.value);

            return isValid;
        }
    </script>
@stop