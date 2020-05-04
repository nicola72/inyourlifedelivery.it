<div class="footer clearfix">
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-xs-12" style="margin-bottom: 20px;">
                <div class="footerLink" style="color: #fff;">

                    <strong>Marsili's Company</strong>
                    <br /> Via Borgo S. Jacopo, 23/r
                    <br />
                    50125 @lang('msg.firenze') <br /> @lang('msg.toscana') - @lang('msg.italia')<br>
                    @lang('msg.piva') 05184760485

                </div>
            </div>
            <div class="col-md-4 col-xs-12" style="margin-bottom: 20px;">
                <div class="footerLink" style="color: #fff;">

                    <strong>Info</strong><br />  Marco Marsili: <i class="fa fa-phone"></i>
                    +39 328 0090798<br />
                    Tommaso Marsili: <i class="fa fa-phone"></i>
                    +39 329 8797021<br />
                    <i class="fa fa-envelope"></i>
                    <a href="mailto:info@chess-store.it?subject=Richiesta inviata da www.chess-store.it">
                        info@chess-store.it
                    </a>

                </div>
            </div>
            <div class="col-md-4 col-xs-12" style="margin-bottom: 20px;">
                <div class="footerLink" style="color: #fff;">
                    <ul>

                        <li>
                            -
                            <a href="{{$pages->where('nome','azienda')->first()->url()}}">
                                {{$pages->where('nome','azienda')->first()->label()}}
                            </a>
                        </li>
                        <li>
                            -
                            <a href="{{$pages->where('nome','dove_siamo')->first()->url()}}">
                                {{$pages->where('nome','dove_siamo')->first()->label()}}
                            </a>
                        </li>
                        <li>
                            -
                            <a href="{{$pages->where('nome','modalita_pagamento')->first()->url()}}">
                                {{$pages->where('nome','modalita_pagamento')->first()->label()}}
                            </a>
                        </li>
                        <li>
                            -
                            <a href="{{$pages->where('nome','modalita_spedizione')->first()->url()}}">
                                {{$pages->where('nome','modalita_spedizione')->first()->label()}}
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- COPY RIGHT -->
<div class="copyRight clearfix">
    <div class="container">
        <div class="row">
            <div class="col-sm-7 col-xs-12">
                <p>Copyright {{date("Y",time())}} - @lang('msg.tutti_i_diritti_riservati') - <a
                            href="http://www.inyourlife.info" target="_blank">@lang('msg.siti_internet')</a>
                    by <a href="http://www.inyourlife.it" target="_blank">InYourLife</a>
                </p>
            </div>
            <div class="col-sm-5 col-xs-12">
                <ul class="list-inline">

                    <li><a href="https://www.facebook.com/Marsilis-Company-316915328512344/" target="_blank"><i class="fa fa-facebook"></i></a></li>
                    <li><a id="scroll-top" href="#top" title="Top">Top<i class="fa fa-arrow-up"></i></a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
