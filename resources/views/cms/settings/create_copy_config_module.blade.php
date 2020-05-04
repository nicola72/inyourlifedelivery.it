<div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Seleziona il modulo da cui copiare</h4>
        </div>
        <div class="modal-body">
            <form action="" method="POST" id="{{ $form_name }}">
                {{ csrf_field() }}
                <input type="hidden" name="module_id" value="{{$modulo->id}}" />
                <div class="form-group">
                    <label>Moduli*</label>
                    <select id="id_selected" name="id_selected" class="form-control" >
                        @foreach($modules as $module)
                            <option value="{{$module->id}}">{{$module->nome}}</option>
                        @endforeach

                    </select>
                </div>
                <div class="form-group">
                    <span>* campi obbligatori</span>
                    <br><br>
                    <button class="btn btn-primary btn-lg w-100" type="submit">
                        <i class="fa fa-dot-circle-o"></i> SALVA
                    </button>
                </div>

            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Chiudi</button>
        </div>
    </div>

</div>
<script>
    $("#{{$form_name}}").validate({
        rules: { module_select:{required:true}},
        messages: { module_select:{required:"Campo Obbligatorio"}},
        submitHandler: function (form)
        {
            $.ajax({
                type: "POST",
                url: "{{url('cms/settings/store_copy_config_module')}}",
                data: $("#{{$form_name}}").serialize(),
                dataType: "json",
                success: function (data)
                {
                    if (data.result === 1)
                    {
                        alert(data.msg);
                        $(location).attr('href', data.url);
                    }
                    else{ alert( data.msg ); }
                },
                error: function (){ alert("Si è verificato un errore! Riprova!"); }
            });
        }
    });
</script>