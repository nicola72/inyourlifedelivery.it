<div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Nuova News</h4>
        </div>
        <div class="modal-body">
            <form action="" method="POST" id="{{ $form_name }}">
                {{ csrf_field() }}
                <div class="form-group">
                    @foreach($langs as $lang)
                        <label class="d-block">
                            <img class="lang-icon" src="/img/cms/{{$lang}}.png" alt=""> Nome {{$lang}}*
                        </label>
                        <input type="text" name="nome_{{$lang}}" id="nome_{{$lang}}" class="form-control mb-2" />
                    @endforeach
                </div>
                <div class="form-group">
                    @foreach($langs as $lang)
                        <label class="d-block">
                            <img class="lang-icon" src="/img/cms/{{$lang}}.png" alt=""> Descrizione {{$lang}}
                        </label>
                        <textarea id="desc_{{$lang}}" style="min-height: 100px;" name="desc_{{$lang}}" class="form-control summernote mb-2"  ></textarea>
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
    //per l'editor delle textarea
    $(document).ready(function(){$('.summernote').summernote({height:100});});

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
                url: "{{url('cms/news')}}",
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