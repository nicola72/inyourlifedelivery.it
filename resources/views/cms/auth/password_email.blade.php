@extends('layouts.cms_login')

@section('content')
    <div class="passwordBox animated fadeInDown">
        <div class="row">
            <div class="col-md-12">
                <div class="ibox-content">
                    <h2 class="font-bold">Richiesta password</h2>
                    <p>Inserisci il tuo indirizzo email e ti sarà inviata una nuova password</p>
                    <div class="row">
                        <div class="col-lg-12">
                            <form class="m-t" role="form" method="POST" action="{{ route('password.email') }}">
                                {{ csrf_field() }}
                                <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
                                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Email address" required>
                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary block full-width m-b">Invia nuova password</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr/>
        <div class="row">
            <div class="col-md-12 text-right">
                <small>CMS Iyl © {{  DATE('Y') }}</small>
            </div>
        </div>
    </div>
@endsection
