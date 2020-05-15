@extends('layouts.cms')
@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox">

                    <!-- header del box -->
                    <div class="ibox-title">

                        <!-- NUOVO -->
                        <a href="{{url('cms/ingredient/create')}}" class="btn btn-w-m btn-primary">Aggiungi</a>
                        <!-- fine pulsante nuovo -->

                        <div class="ibox-tools">
                            <a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <!-- fine header -->

                    <div class="ibox-content">
                        <table id="table-products" style="font-size:12px" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>Id</th>
                                <th>Shop</th>
                                <th>Nome</th>
                                <th>Categoria</th>
                                <th>Prezzo</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($ingredients as $ingredient)
                                <tr>
                                    <td>{{$ingredient->id}}</td>
                                    <td>{{$ingredient->shop->insegna}}</td>
                                    <td>{{$ingredient->nome_it}}</td>
                                    <td>{{$ingredient->category->nome_it}}</td>
                                    <td>@money($ingredient->prezzo)</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js_script')
    <script>
        $(document).ready(function ()
        {
            $('#table-products').DataTable({
                responsive: true,
                pageLength: 100,
                order: [[ 1, "asc" ]], //order in base a order
                language:{ "url": "/cms_assets/js/plugins/dataTables/dataTable.ita.lang.json" }
            });

        });


    </script>
@stop
