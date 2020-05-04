@extends('layouts.website')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                Errore Grave!
                Il metodo {{ $method }} non esite...
                <a href="{{url('/')}}">clicca qui per tornare alla homepage</a>
            </div>
        </div>
    </div>
@endsection