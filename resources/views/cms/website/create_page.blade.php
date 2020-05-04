<div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Nuova Pagina</h4>
        </div>
        <div class="modal-body">
            <form action="" method="POST" id="{{ $form_name }}">
                {{ csrf_field() }}
                <div class="form-group">
                    <label>Nome*</label>
                    <input type="text" name="nome" id="nome" class="form-control" />
                </div>
                <div class="form-group">
                    <div class="row">
                        @foreach($langs as $lang)
                            <div class="col-md-6">
                                <label class="d-block">
                                    <img class="lang-icon" src="/img/cms/{{$lang}}.png" alt=""> Label {{$lang}}
                                </label>
                                <input type="text" name="label_{{$lang}}" id="label_{{$lang}}" class="form-control mb-2" />
                            </div>
                        @endforeach
                    </div>
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
        rules: { nome:{required:true} },
        messages: { nome:{required:"Campo Obbligatorio"}},
        submitHandler: function (form)
        {
            $.ajax({
                type: "POST",
                url: "{{url('cms/website/store_page')}}",
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