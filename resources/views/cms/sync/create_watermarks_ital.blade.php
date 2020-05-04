@extends('layouts.cms')
@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox">

                    <div class="ibox-content">
                        Creiamo watermarks<br>
                        Pagine:{{$pagine}}<br>
                        Files: {{$numero_files}}<br>
                        Pagina: {{$page}}<br>
                        Create: {{($page * 10)}}<br>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js_script')
    @if($page <= $pagine)
    <script>
        $(document).ready(function(){
            setTimeout(goto, 1000);
        });

        function goto()
        {
            var url = '/cms/sync/create_watermarks_ital/{{($page + 1)}}';
            location.assign(url);
        }
    </script>
    @endif
@stop