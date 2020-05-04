@extends('layouts.cms_login')

@section('content')
    <div class="middle-box text-center loginscreen animated fadeInDown">
        <div>
            <div><h1 class="logo-name">IYL</h1></div>
            <h3>Benvenuto nel CMS Inyourlife</h3>

            <form class="m-t" role="form" method="POST" action="{{ route('cms.login') }}">
                {{ csrf_field() }}
                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    <input type="email" class="form-control" placeholder="E-Mail" name="email"
                           value="{{ old('email') }}" required autofocus>
                    @if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                    <input type="password" class="form-control" placeholder="Password" name="password" required>
                    @if ($errors->has('password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>
                <button type="submit" class="btn btn-primary block full-width m-b">Login</button>
                <a href="{{ route('cms.password.request') }}"><small>Recupera password?</small></a>
                <p class="text-muted text-center">
                    <small>Non hai un account?</small>
                </p>
                <a class="btn btn-sm btn-white btn-block" href="{{ route('cms.register') }}">Crea un account</a>
            </form>
            <p class="m-t">
                <small>Cms InYourLife &copy; {{ date('Y') }}</small>
            </p>
        </div>
    </div>
@endsection
