@extends('layouts.website_errors')

@section('content')
    <div class="middle-box text-center animated fadeInDown">
        <h1>404</h1>
        <h3 class="font-bold">Oops! {{ class_basename($exception->getPrevious() ? : $exception) }}</h3>

        <div class="error-desc">
            {{ $exception->getPrevious() ? $exception->getPrevious()->getMessage() : $exception->getMessage() }}
            <a href="{{ url('/') }}" class="btn btn-default">Home</a>
        </div>
    </div>
@endsection
