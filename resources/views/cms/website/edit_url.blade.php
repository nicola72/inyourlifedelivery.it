<div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Modifica Dominio</h4>
        </div>
        <div class="modal-body">
            <form action="" method="POST" id="{{ $form_name }}">
                {{ csrf_field() }}
                <div class="form-group">
                    <label>Dominio</label>
                    <select name="domain_id" id="domain_id" class="form-control">
                        @foreach($domains as $domain)
                            @if($domain->id == $url->domain_id)
                                <option value="{{$domain->id}}" selected>{{$domain->nome}}</option>
                            @else
                                <option value="{{$domain->id}}">{{$domain->nome}}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Tipo</label>
                    <input type="text" value="{{$url->urlable_type}}" disabled class="form-control" />
                </div>
                <div class="form-group">
                    <label>Locale*</label>
                    <select id="lang" name="lang" class="form-control" >
                        @foreach($langs as $lingua)
                            @if($lingua == $url->locale)
                                <option value="{{$lingua}}" selected>{{$lingua}}</option>
                            @else
                                <option value="{{$lingua}}">{{$lingua}}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Slug*</label>
                    <input type="text" name="slug" id="nome" value="{{$url->slug}}" class="form-control" />
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
        rules: { slug:{required:true}, locale:{required:true} },
        messages: { slug:{required:"Campo Obbligatorio"}, locale: {required: "Campo Obbligatorio"}},
        submitHandler: function (form)
        {
            $.ajax({
                type: "POST",
                url: "{{url('cms/website/update_url',[$url->id])}}",
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