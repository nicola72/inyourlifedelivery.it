<div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Nuova Configurazione per {{$modulo->nome}}</h4>
        </div>
        <div class="modal-body">
            <form action="" method="POST" id="{{ $form_name }}">
                {{ csrf_field() }}
                <input type="hidden" name="module_id" value="{{$modulo->id}}" />
                <div class="form-group">
                    <label>Tipo*</label>
                    <select id="type" name="type" class="form-control" >
                        <option value="boolean">booleano</option>
                        <option value="string">string</option>
                        <option value="json">json</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Nome*</label>
                    <input type="text" name="nome" id="nome" class="form-control" />
                </div>
                <div class="form-group">
                    <label>Descrizione</label>
                    <input type="text" name="desc" id="desc" class="form-control" />
                </div>
                <div class="form-group">
                    <label>Valore* <small>(se boolean 1:sì 0:no)</small></label>
                    <textarea name="value" rows="7" id="value" class="form-control"></textarea>
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
        rules: { nome:{required:true}, type:{required:true}, value:{required:true} },
        messages: { nome:{required:"Campo Obbligatorio"}, type: {required: "Campo Obbligatorio"}, value: {required: "Campo Obbligatorio"}},
        submitHandler: function (form)
        {
            $.ajax({
                type: "POST",
                url: "{{url('cms/settings/store_config_module')}}",
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