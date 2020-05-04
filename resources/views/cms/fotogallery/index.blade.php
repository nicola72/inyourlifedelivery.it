@extends('layouts.cms')
@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">

                <!-- header del box -->
                <div class="ibox-title">

                    <!-- NUOVO -->
                    <a href="javascript:void(0)" onclick="get_modal('{{url('cms/fotogallery/create')}}')" class="btn btn-w-m btn-primary">Aggiungi</a>
                    <!-- fine pulsante nuovo -->

                    <!-- CATEGORIE -->
                    <a href="{{url('cms/fotogallery/categories')}}"  class="btn btn-w-m btn-primary" >Categorie</a>
                    <!-- fine pulsante Categorie -->


                    <div class="ibox-tools">
                        <a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </div>
                </div>
                <!-- fine header -->

                <div class="ibox-content">
                    <table id="table-fotogallery" style="font-size:12px" class="table table-striped table-bordered">
                        <thead>
                        <tr>
                            <th>Nome</th>
                            <th style="max-width: 300px;">Desc</th>
                            <th>Categorie</th>
                            <th data-orderable="false">Visibile</th>
                            <th data-orderable="false">Azioni</th>
                            <th data-orderable="false">Foto</th>
                        </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection