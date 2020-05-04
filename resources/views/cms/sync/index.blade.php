@extends('layouts.cms')
@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox">

                    <div class="ibox-content">
                        <div class="row pt-2 pb-2 mb-4 border-top border-bottom">
                            <div class="col-md-12">
                                <em>Azzera la tabella categories e la sincronizza con la vecchia tabella tb_categorie</em>
                                <br>
                                <a href="{{url('cms/sync/sync_categorie')}}" class="btn btn-w-m btn-primary">
                                    Sincronizza Categorie
                                </a>
                            </div>
                        </div>
                        <div class="row pt-2 pb-2 mb-4 border-top border-bottom">
                            <div class="col-md-12">
                                <em>Elimina dalla tabella urls tutte le urls delle categorie e crea per ogni categoria e per ogni alias una nuova url</em>
                                <br>
                                <a href="{{url('cms/sync/sync_url_categorie')}}" class="btn btn-w-m btn-primary">
                                    Crea urls Categorie
                                </a>
                            </div>
                        </div>
                        <div class="row pt-2 pb-2 mb-4 border-top border-bottom">
                            <div class="col-md-12">
                                <em>Azzera la tabella products e la sincronizza con la vecchia tabella tb_prodotti</em>
                                <br>
                                <a href="{{url('cms/sync/sync_prodotti')}}" class="btn btn-w-m btn-primary">
                                    Sincronizza Prodotti
                                </a>
                            </div>
                        </div>
                        <div class="row pt-2 pb-2 mb-4 border-top border-bottom">
                            <div class="col-md-12">
                                <em>Elimina dalla tabella files i records dei prodotti e sincronizza con la tabella tb_prodotti</em>
                                <br>
                                <a href="{{url('cms/sync/sync_file_prodotti')}}" class="btn btn-w-m btn-primary">
                                    Sincronizza Immagini Prodotti
                                </a>
                            </div>
                        </div>
                        <div class="row pt-2 pb-2 mb-4 border-top border-bottom">
                            <div class="col-md-12">
                                <em>Elimina dalla tabella urls tutte le urls dai prodotti e crea per ogni prodotti e per ogni alias una nuova url</em>
                                <br>
                                <a href="{{url('cms/sync/sync_url_prodotti')}}" class="btn btn-w-m btn-primary">
                                    Crea urls Prodotti
                                </a>
                            </div>
                        </div>
                        <div class="row pt-2 pb-2 mb-4 border-top border-bottom">
                            <div class="col-md-12">
                                <em>Azzera la tabella pairings e la sincronizza con la vecchia tabella tb_abbinamenti</em>
                                <br>
                                <a href="{{url('cms/sync/sync_abbinamenti')}}" class="btn btn-w-m btn-primary">
                                    Sincronizza Abbinamenti
                                </a>
                            </div>
                        </div>
                        <div class="row pt-2 pb-2 mb-4 border-top border-bottom">
                            <div class="col-md-12">
                                <em>Elimina dalla tabella files i records degli abbinamenti e sincronizza con la tabella tb_abbinamenti</em>
                                <br>
                                <a href="{{url('cms/sync/sync_file_abbinamenti')}}" class="btn btn-w-m btn-primary">
                                    Sincronizza Immagini Abbinamenti
                                </a>
                            </div>
                        </div>
                        <div class="row pt-2 pb-2 mb-4 border-top border-bottom">
                            <div class="col-md-12">
                                <em>Elimina dalla tabella urls tutte le urls  e crea per ogni abbinamento e per ogni alias una nuova url</em>
                                <br>
                                <a href="{{url('cms/sync/sync_url_abbinamenti')}}" class="btn btn-w-m btn-primary">
                                    Crea urls Abbinamenti
                                </a>
                            </div>
                        </div>
                        <div class="row pt-2 pb-2 mb-4 border-top border-bottom">
                            <div class="col-md-12">
                                <em>Di tutte le immagini crea le thumb big e small</em>
                                <br>
                                <a href="{{url('cms/sync/create_thumbs')}}" class="btn btn-w-m btn-primary">
                                    Crea le thumb
                                </a>
                            </div>
                        </div>
                        <div class="row pt-2 pb-2 mb-4 border-top border-bottom">
                            <div class="col-md-12">
                                <em>Crea le watermark italfama delle immagini da configurare nella funzione</em>
                                <br>
                                <a href="{{url('cms/sync/create_watermarks')}}" class="btn btn-w-m btn-primary">
                                    Crea le watermark Italfama
                                </a>
                            </div>
                        </div>
                        <div class="row pt-2 pb-2 mb-4 border-top border-bottom">
                            <div class="col-md-12">
                                <em>Crea le watermark chess delle immagini da configurare nella funzione</em>
                                <br>
                                <a href="{{url('cms/sync/create_watermarks_ital')}}" class="btn btn-w-m btn-primary">
                                    Crea le watermark Chess
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js_script')

@stop