@extends('layouts.cms')
@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox">

                    <!-- header del box -->
                    <div class="ibox-title">

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
                                <th>Nome</th>
                                <th>Categoria</th>
                                <th>Prezzo</th>
                                <th>Scontato</th>
                                <th data-orderable="false">Foto</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($products as $product)
                                <tr>
                                    <td>{{$product->id}}</td>
                                    <td>{{$product->nome_it}}</td>
                                    <td>{{$product->category->nome_it}}</td>
                                    <td>@money($product->prezzo)</td>
                                    <td>@money($product->prezzo_scontato)</td>

                                    <td>
                                        @if($product->cover($product->shop_id))
                                            <img src="/file/{{$product->cover($product->shop_id)}}" alt="" class="img-fluid" style="max-width:100px"/>
                                        @endif
                                    </td>
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
                order: [[ 0, "desc" ]], //order in base a order
                language:{ "url": "/cms_assets/js/plugins/dataTables/dataTable.ita.lang.json" }
            });

        });

    </script>
@stop
