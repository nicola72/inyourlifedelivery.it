<div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Associa Seo ad un Tipo Url</h4>
        </div>
        <div class="modal-body">
            <form action="" method="POST" id="{{ $form_name }}">
                {{ csrf_field() }}
                <input type="hidden" name="seo_id" value="{{$seo->id}}" id="seo_id" />
                <div class="form-group">
                    <label>Tipo di Url</label>
                    <select name="url_type" id="url_type" class="form-control">
                        <option value="">seleziona</option>
                        @foreach($urlable_types as $type)
                            <option value="{{$type}}">{{$type}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <button class="btn btn-primary btn-lg w-100" type="submit">
                        <i class="fa fa-dot-circle-o"></i> ASSOCIA
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
            url_type:{required:true},
        },
        messages: {
            url_type:{required:'Questo campo è obbligatorio'},
        },
        submitHandler: function (form)
        {
            $.ajax({
                type: "POST",
                url: "{{url('cms/seo/store_associazione_model')}}",
                data: $("#{{$form_name}}").serialize(),
                dataType: "json",
                success: function (data)
                {
                    if (data.result === 1)
                    {
                        alert(data.msg);
                        location.replace("{{url('cms/seo')}}");
                    }
                    else{ alert( data.msg ); }
                },
                error: function (){ alert("Si è verificato un errore! Riprova!"); }
            });
        }
    });
</script>