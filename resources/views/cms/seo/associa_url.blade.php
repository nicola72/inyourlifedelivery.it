<div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Associazione Seo ad Url</h4>
        </div>
        <div class="modal-body">
            <form action="" method="POST" id="{{ $form_name }}">
                {{ csrf_field() }}
                <input type="hidden" name="seo_id" value="{{$seo->id}}" id="seo_id" />
                <div class="form-group">
                    <label>Tipo di Url</label>
                    <select name="url_type" id="url_type" onchange="get_urls()" class="form-control">
                        <option value="">seleziona</option>
                        @foreach($urlable_types as $type)
                            <option value="{{$type}}">{{$type}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <select name="url_id" id="url_id" class="form-control" >

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
    function get_urls()
    {
        var url_type = $('#url_type').val();
        if(url_type === '')
        {
            alert('seleziona un tipo valido');
            return;
        }
        $.ajax({
            type: "GET",
            url: "{{url('cms/seo/get_urls_by_type')}}",
            data: {url_type:url_type},
            dataType: "html",
            success: function (data)
            {
                $('#url_id').html(data);
            },
            error: function (){ alert("Si è verificato un errore! Riprova!"); }
        });
    }

    $("#{{$form_name}}").validate({
        rules: {
            url_id:{required:true},
        },
        messages: {
            url_id:{required:'Questo campo è obbligatorio'},
        },
        submitHandler: function (form)
        {
            $.ajax({
                type: "POST",
                url: "{{url('cms/seo/store_associazione_url')}}",
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