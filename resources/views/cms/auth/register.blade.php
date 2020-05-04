@extends('layouts.cms_login')

@section('content')
    <div class="middle-box text-center loginscreen   animated fadeInDown">
        <div>
            <div> <h1 class="logo-name">IYL</h1></div>
            <h3>Registrazione CMS</h3>
            <form class="m-t" role="form"  method="POST" action="{{ route('cms.register') }}">
                {{ csrf_field() }}

                <div class="form-group">
                    <select name="role_id" class="form-control" required autofocus>
                        @foreach($roles as $role)
                            <option value="{{$role->id}}">{{$role->description}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                    <input type="text" class="form-control" placeholder="Nome" name="name" value="{{ old('name') }}" required >
                    @if ($errors->has('name'))
                        <span class="help-block">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    <input type="email" class="form-control" placeholder="Email" name="email" value="{{ old('email') }}" required>
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
                <div class="form-group">
                    <input type="password" class="form-control" placeholder="Conferma Password" name="password_confirmation" required>
                </div>
                <button type="submit" class="btn btn-primary block full-width m-b">Registrati</button>

                <p class="text-muted text-center"><small>Hai già un account?</small></p>
                <a class="btn btn-sm btn-white btn-block" href="{{ route('cms.login') }}">Login</a>
            </form>
            <p class="m-t"> <small>Cms InYourLife &copy; {{ date('Y') }}</small> </p>
        </div>
    </div>
@endsection
