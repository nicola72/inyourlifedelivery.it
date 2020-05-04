<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-sm-8">
        <h2 class="text-uppercase">{{ $title_page }}</h2>
        @section('breadcrumbs')
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ url('/cms') }}">Home</a>
                </li>
                <li class="breadcrumb-item">
                    <strong>{{ $title_page }}</strong>
                </li>
            </ol>
        @show
    </div>
</div>