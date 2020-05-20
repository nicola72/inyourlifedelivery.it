@if ($message = Session::get('success'))
    <div id="flash_modal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <h4>Successo!</h4>
                    <strong>{{ $message }}</strong>
                </div>
                <div class="modal-footer no-padding">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Chiudi</button>
                </div>
            </div>
        </div>
    </div>
    @section('js_flash')
        <script>
            $("#flash_modal").modal();
        </script>
    @stop
@endif


@if ($message = Session::get('error'))
    <div id="flash_modal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <h4>Errore!</h4>
                    <strong>{{ $message }}</strong>
                </div>
                <div class="modal-footer no-padding">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Chiudi</button>
                </div>
            </div>
        </div>
    </div>
    @section('js_flash')
        <script>
            $("#flash_modal").modal();
        </script>
    @stop
@endif


@if ($message = Session::get('warning'))
    <div id="flash_modal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <h4>Attenzione!</h4>
                    <strong>{{ $message }}</strong>
                </div>
                <div class="modal-footer no-padding">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Chiudi</button>
                </div>
            </div>
        </div>
    </div>
    @section('js_flash')
        <script>
            $("#flash_modal").modal();
        </script>
    @stop
@endif


@if ($message = Session::get('info'))
    <div id="flash_modal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <h4>Info!</h4>
                    <strong>{{ $message }}</strong>
                </div>
                <div class="modal-footer no-padding">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Chiudi</button>
                </div>
            </div>
        </div>
    </div>
    @section('js_flash')
        <script>
            $("#flash_modal").modal();
        </script>
    @stop
@endif


@if ($errors->any())

@endif