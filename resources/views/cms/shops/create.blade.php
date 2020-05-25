<div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Nuovo Negozio</h4>
        </div>
        <div class="modal-body">
            <form action="" method="POST" id="{{ $form_name }}">
                {{ csrf_field() }}
                <div class="form-group">
                    <label class="d-block">
                        Insegna*
                    </label>
                    <input type="text" name="insegna" id="insegna" class="form-control mb-2" />
                </div>
                <div class="form-group">
                    <label class="d-block">
                        Ragione Sociale*
                    </label>
                    <input type="text" name="rag_soc" id="rag_soc" class="form-control mb-2" />
                </div>

                <div class="form-group">
                    <label class="d-block">
                        Dominio* <small>(senza il www)</small>
                    </label>
                    <input type="text" name="domain" id="domain" class="form-control mb-2" />
                </div>

                <div class="form-group">
                    <label class="d-block">
                        Email*
                    </label>
                    <input type="text" name="email" id="email" class="form-control mb-2" />
                </div>

                <div class="form-group">
                    <label class="d-block">
                        Telefono*
                    </label>
                    <input type="text" name="tel" id="tel" class="form-control mb-2" />
                </div>

                <div class="form-group">
                    <label class="d-block">
                        P.Iva*
                    </label>
                    <input type="text" name="p_iva" id="p_iva" class="form-control mb-2" />
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-9">
                            <label class="d-block">
                                Indirizzo
                            </label>
                            <input type="text" name="indirizzo" id="indirizzo" class="form-control mb-2" />
                        </div>
                        <div class="col-md-3">
                            <label class="d-block">
                                N.civico
                            </label>
                            <input type="text" name="nr_civico" id="nr_civico" class="form-control mb-2" />
                        </div>
                    </div>

                </div>

                <div class="form-group">
                    <label class="d-block">
                        Cap*
                    </label>
                    <input type="text" name="cap" id="cap" class="form-control mb-2" />
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-8">
                            <label class="d-block">
                                Città*
                            </label>
                            <input type="text" name="citta" id="citta" class="form-control mb-2" />
                        </div>
                        <div class="col-md-4">
                            <label class="d-block">
                                Prov.*
                            </label>
                            <input type="text" name="provincia" id="provincia" class="form-control mb-2" />
                        </div>
                    </div>

                </div>
                <div class="form-group">
                    <div class="form-group">
                        <label class="d-block">
                            Sede legale*
                        </label>
                        <textarea name="sede_legale" id="sede_legale" class="form-control mb-2"></textarea>
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
        rules: {
            insegna:{required:true},
            rag_soc:{required:true},
            domain:{required:true},
            email:{required:true},
            tel:{required:true},
            cap:{required:true},
            p_iva:{required:true},
            citta:{required:true},
            provincia:{required:true},
            indirizzo:{required:true},
            nr_civico:{required:true},
            sede_legale:{required:true},
        },
        messages: {
            insegna:{required:'Questo campo è obbligatorio'},
            rag_soc:{required:'Questo campo è obbligatorio'},
            domain:{required:'Questo campo è obbligatorio'},
            email:{required:'Questo campo è obbligatorio'},
            tel:{required:'Questo campo è obbligatorio'},
            cap:{required:'Questo campo è obbligatorio'},
            p_iva:{required:'Questo campo è obbligatorio'},
            citta:{required:'Questo campo è obbligatorio'},
            provincia:{required:'Questo campo è obbligatorio'},
            indirizzo:{required:'Questo campo è obbligatorio'},
            nr_civico:{required:'Questo campo è obbligatorio'},
            sede_legale:{required:'Questo campo è obbligatorio'},
        },
        submitHandler: function (form)
        {
            $.ajax({
                type: "POST",
                url: "{{url('cms/shops/store')}}",
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