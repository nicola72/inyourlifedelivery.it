<div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Nuovo Materiale</h4>
        </div>
        <div class="modal-body">
            <form action="" method="POST" id="{{ $form_name }}">
                {{ csrf_field() }}
                <div class="form-group">
                    <select name="category_id[]" id="category_id" data-placeholder="Seleziona" class="chosen-select" multiple style="width:350px;" tabindex="4" >
                        <option value="">seleziona</option>
                        @foreach($categorie as $cat)
                            <option value="{{$cat->id}}">{{$cat->id}}-{{$cat->nome_it}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Per</label>
                    <select name="per" id="per" class="form-control">
                        <option value="scacchi">Scacchi</option>
                        <option value="scacchiera">Scacchiera</option>
                    </select>
                </div>
                <div class="form-group">
                    @foreach($langs as $lang)
                        <label class="d-block">
                            <img class="lang-icon" src="/img/cms/{{$lang}}.png" alt=""> Nome {{$lang}}*
                        </label>
                        <input type="text" name="nome_{{$lang}}" id="nome_{{$lang}}" class="form-control mb-2" />
                    @endforeach
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
    //per la multiselect
    $('.chosen-select').chosen({width: "100%"});

    $("#{{$form_name}}").validate({
        rules: {
            @foreach($langs as $lang)
                nome_{{$lang}}:{required:true},
            @endforeach
        },
        messages: {
            @foreach($langs as $lang)
            nome_{{$lang}}:{required:'Questo campo è obbligatorio'},
            @endforeach
        },
        submitHandler: function (form)
        {
            $.ajax({
                type: "POST",
                url: "{{url('cms/material')}}",
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