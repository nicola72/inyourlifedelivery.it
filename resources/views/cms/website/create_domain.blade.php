<div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Nuovo Dominio</h4>
        </div>
        <div class="modal-body">
            <form action="" method="POST" id="{{ $form_name }}">
                {{ csrf_field() }}
                <div class="form-group">
                    <label>Locale*</label>
                    <select id="lang" name="lang" class="form-control" >
                        @foreach($langs as $lingua)
                            <option value="{{$lingua}}">{{$lingua}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Nome* <small>(senza il www)</small></label>
                    <input type="text" name="nome" id="nome" class="form-control" />
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
        rules: { nome:{required:true}, locale:{required:true} },
        messages: { nome:{required:"Campo Obbligatorio"}, locale: {required: "Campo Obbligatorio"}},
        submitHandler: function (form)
        {
            $.ajax({
                type: "POST",
                url: "{{url('cms/website/store_domain')}}",
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