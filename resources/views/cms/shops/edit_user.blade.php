<div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Modifica Utente</h4>
        </div>
        <div class="modal-body">
            <form action="" method="POST" id="{{ $form_name }}">
                {{ csrf_field() }}
                <div class="form-group">
                    <label class="d-block">
                        Name*
                    </label>
                    <input type="text" name="name" id="name" value="{{$user->name}}" class="form-control mb-2" />
                </div>
                <div class="form-group">
                    <label class="d-block">
                        Email*
                    </label>
                    <input type="text" name="email" id="email" value="{{$user->email}}" class="form-control mb-2" />
                </div>

                <div class="form-group">
                    <label class="d-block">
                        Password*
                    </label>
                    <input type="text" name="password" id="password" value="{{$user->clear_pwd->password}}" class="form-control mb-2" />
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
        rules: {
            name:{required:true},
            email:{required:true},
            password:{required:true},
        },
        messages: {
            name:{required:'Questo campo è obbligatorio'},
            email:{required:'Questo campo è obbligatorio'},
            password:{required:'Questo campo è obbligatorio'},
        },
        submitHandler: function (form)
        {
            $.ajax({
                type: "POST",
                url: "{{url('cms/shops/update_user',$user->id)}}",
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