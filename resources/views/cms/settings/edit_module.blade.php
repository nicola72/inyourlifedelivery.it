<div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Modifica Modulo</h4>
        </div>
        <div class="modal-body">
            <form action="" method="POST" id="{{ $form_name }}">
                {{ csrf_field() }}
                <div class="form-group">
                    <label>Ruolo</label>
                    <select id="role_id" name="role_id" class="form-control" >
                        @foreach($roles as $role)
                            <option value="{{$role->id}}" {{ ($role->id == $modulo->role_id) ? "selected":""}} >
                                {{$role->description}}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Modulo genitore</label>
                    <select id="parent_id" name="parent_id" class="form-control" >
                        <option value="">nessuno</option>
                        @foreach($modules as $module)
                            <option value="{{$module->id}}" {{ ($module->id == $modulo->parent_id) ? "selected":""}}>
                                {{$module->nome}}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Nome</label>
                    <input type="text" value="{{$modulo->nome}}" name="nome" id="nome" class="form-control" />
                </div>
                <div class="form-group">
                    <label>Icon</label>
                    <input type="text" value="{{$modulo->icon}}" name="icon" id="icon" class="form-control" />
                </div>
                <div class="form-group">
                    <label>Label</label>
                    <input type="text" value="{{$modulo->label}}" name="label" id="label" class="form-control" />
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
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
    </div>

</div>
<script>

    // fine
    $("#{{$form_name}}").validate({
        rules: {
            nome:{required:true},
            role_id:{required:true}
        },
        messages: {
            nome:{required:"Campo Obbligatorio"},
            role_id: {required: "Campo Obbligatorio"}
        },
        submitHandler: function (form)
        {
            $.ajax({
                type: "POST",
                url: "{{url('/cms/settings/update_module',[$modulo->id])}}",
                data: $("#{{$form_name}}").serialize(),
                dataType: "json",
                success: function (data)
                {
                    if (data.result === 1)
                    {
                        alert(data.msg);
                        $(location).attr('href', data.url);
                    }
                    else{ alert(data.msg); }
                },
                error: function (){ alert("Si è verificato un errore! Riprova!");}
            });
        }
    });
</script>