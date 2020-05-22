<!--   barra di navigazione-->
<nav class="navbar navbar-expand-lg navbar-light navbar-transparent bg-faded nav-sticky" style="background-color:#000; padding-top:5px; padding-bottom:5px;">

    <div class="container">
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon icona_menu_mobile" ></span>
        </button>

        <a class="navbar-brand" href="/">
            <img class='logo logo-dark' src="/file/{{$shop->logo()}}" alt=""style="max-width:180px;max-height: 70px;">
            <img class='logo logo-light hidden-md-down' src="/file/{{$shop->logo()}}" alt=""style="max-width:180px;max-height: 70px;">
        </a>

        <div  id="navbarNavDropdown" class="navbar-collapse collapse">
            <ul class="navbar-nav ml-auto">
                @if(\Route::currentRouteName() == 'website.home')
                    <li class="nav-item">
                        <a class="nav-link "  href="#ordina">SCEGLI QUELLO CHE VUOI</a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link "  href="#orario_ancor">SCEGLI L'ORARIO</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link "  href="#consegna">SCEGLI IL TIPO DI CONSEGNA</a>
                    </li>
                @elseif(\Route::currentRouteName() == 'website.cart_resume')
                    <li class="nav-item">
                        <a class="nav-link " href="#ordina">RIEPILOGO ORDINAZIONE</a>
                    </li>
                @elseif(\Route::currentRouteName() == 'website.esito_ordinazione')
                    <li class="nav-item">
                        <a class="nav-link " href="#ordina">CONFERMA ORDINAZIONE</a>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link " href="#ordina">&nbsp;</a>
                    </li>
                @endif
            </ul>
        </div>

        <div class=" navbar-right-elements">
            <ul class="list-inline">
                <li class="list-inline-item">
                    <a href="javascript:void(0)" class=" menu-btn" style="font-size:150%;">
                        <i class="ti-shopping-cart"></i>
                        <span id="cart_count" class="badge badge-default">{{$carts->sum('qta')}}</span>
                    </a>
                </li>
            </ul>
        </div><!--right nav icons-->
    </div>
</nav>
<!--   fine barra di navigazione     -->