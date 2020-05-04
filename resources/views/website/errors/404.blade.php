@extends('layouts.website')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            Errore 404!
            La pagina che cercavi non esiste.
            <a href="{{url('/')}}">clicca qui per tornare alla homepage</a>
        </div>
    </div>
</div>
@endsection