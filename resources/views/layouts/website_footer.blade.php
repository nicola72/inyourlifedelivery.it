<footer class="footer footer-standard pt50 pb10 ">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-6 mb40">
                <h3>{{$shop->insegna ?? ''}}</h3>
                <p>
                    {{$shop->indirizzo ?? ''}},{{$shop->nr_civico ?? ''}}<br/>
                    {{$shop->cap ?? ''}} {{$shop->citta ?? ''}} ({{$shop->provincia ?? ''}})<br/>
                    Tel. {{$shop->telefono ?? ''}}<br/>
                    Email {{$shop->email ?? ''}}<br/>
                    P.IVA {{$shop->p_iva ?? ''}}

            </div>
            <div class="col-lg-3 col-md-6 mb40">

            </div>
        </div>
    </div>
</footer><!--/footer-->
<div class="footer-bottomAlt">
    <div class="container">
        <div class="row">
            <div class="col-lg-7">
                <div class="clearfix">

                </div>
            </div>
            <div class="col-lg-5">
                <span>&copy; Copyright - Tutti i diritti riservati {{date("Y",time())}}.
                    <a href="https://www.inyourlife.info">Siti Internet by InYourLife</a>
                </span>
            </div>
        </div>
    </div>
</div><!--/footer bottom-->