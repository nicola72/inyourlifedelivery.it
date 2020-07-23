<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" style="padding-left:0px;">
            <li class="nav-header">
                <div class="dropdown profile-element">
                    <span>
                        <img alt="image" class="img-circle" src="/img/cms/logo_cms.png" />
                    </span>
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                        <span class="clear">
                            <span class="block m-t-xs">
                                <strong class="font-bold">{{ config('cms.name') }}</strong>
                            </span>
                            <span class="text-muted text-xs block">
                                {{ Auth::user()->name }}<b class="caret"></b>
                            </span>
                        </span>
                    </a>
                    <ul class="dropdown-menu animated fadeInRight m-t-xs">
                        <li>
                            <a href="{{ route('cms.logout') }}">Logout</a>
                        </li>
                    </ul>
                </div>
                <div class="logo-element">
                    IN+
                </div>
            </li>
        </ul>
        @section('sidebar-menu')
        <ul class="nav metismenu" id="side-menu" style="padding-left:0px;">
            <li class="{{ (Route::currentRouteName() == 'cms.dashboard') ? "active" : "" }}">
                <a href="{{route('cms.dashboard')}}">
                    <i class="fa fa-th-large"></i>
                    <span class="nav-label">DASHBOARD</span>
                </a>
            </li>

            @if(Auth::user()->role->id == 1)
                <li class="{{ (Route::currentRouteName() == 'cms.settings') ? "active" : "" }}">
                    <a href="{{route('cms.settings')}}">
                        <i class="fa fa-cogs"></i>
                        <span class="nav-label">MODULI</span>
                    </a>
                </li>
            @endif

            @if(Auth::user()->role->id == 1)
                <li class="{{ (Route::currentRouteName() == 'cms.shops') ? "active" : "" }}">
                    <a href="{{route('cms.shops')}}">
                        <i class="fa fa-cogs"></i>
                        <span class="nav-label">SHOPS</span>
                    </a>
                </li>
            @endif

            @foreach($cms_modules->sortBy('order') as $modulo)
                @if(($modulo->role_id >= Auth::user()->role->id) && $modulo->stato)
                <li class="{{ (Route::currentRouteName() == 'cms.'.$modulo->nome) ? "active" : "" }}">
                    <a href="{{route('cms.'.$modulo->nome)}}">
                        <i class="fa {{$modulo->icon}}"></i>
                        <span class="nav-label text-uppercase">
                            @if(Auth::user()->role->id == 2)
                                {{($modulo->{'label_'.Auth::user()->shop->tipo_attivita} != '') ? $modulo->{'label_'.Auth::user()->shop->tipo_attivita} :$modulo->label}}
                            @else
                                {{$modulo->label}}
                            @endif
                        </span>
                    </a>
                </li>
                @endif
            @endforeach
            
            <li>
                <a href="http://webmail.inyourlife.info/" target="_blank">
                    <i class="fa fa-envelope-o"></i>
                    <span class="nav-label">WEBMAIL</span>
                </a>
            </li>
        </ul>
        @show
    </div>
</nav>