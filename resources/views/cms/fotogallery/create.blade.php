<div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Nuova Galleria </h4>
        </div>
        <div class="modal-body">
            <form action="" method="POST" id="<?= $this->form?>">

                <?php if($this->cm['con_categorie']): ?>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-6">
                            <!-- Categorie -->
                            <label>Categorie*</label>
                            <select name="id_categorie[]" id="id_categorie" data-placeholder="Seleziona" class="chosen-select" multiple style="width:350px;" tabindex="4" >
                                <!-- nel caso ci sia un solo tipo attributo lo metto già selezionato -->
                                <?php if(count($this->categorie) == 1):?>
                                <option value="<?= $this->categorie[0]->id?>" selected><?= $this->categorie[0]->nome?></option>
                                <?php else:?>
                                <option value="">Seleziona</option>
                                <?php foreach($this->categorie as $item): ?>
                                <option value="<?= $item->id?>"><?= $item->nome?></option>
                                <?php endforeach;?>
                                <?php endif;?>
                            </select>
                            <!-- -->
                        </div>
                    </div>
                </div>
                <?php endif;?>

            <!-- CAMPI IN LINGUA -->
                <?php foreach ($this->langs as $l): ?>

            <!-- NOME FOTOGALLERY -->
                <div class="form-group">
                    <label><img class="lang-icon" src="<?= $this->app::FOLDER . $l->icona_cms ?>" alt=""> Nome* </label>
                    <input id="nome_<?= $l->sigla ?>" name="nome_<?= $l->sigla ?>" value="" type="text" class="form-control" />
                </div>
                <!--  -->

                <!-- DESCRIZIONE PRODOTTO -->
                <?php if ($this->cm['desc']): ?>
                <div class="form-group">
                    <label>
                        <img class="lang-icon" src="<?= $this->app::FOLDER . $l->icona_cms ?>" alt="">
                        Descrizione <?=($this->cm['desc_required'])?'*':'';?>
                    </label>
                    <?php $editor = ($this->cm['desc_summernote']) ? 'summernote' : '' ?>
                    <textarea id="desc_<?= $l->sigla ?>" style="min-height: 100px;" name="desc_<?= $l->sigla ?>" class="form-control <?= $editor ?>"  ></textarea>
                </div>
            <?php endif; ?>
            <!--  -->


            <?php endforeach;?>
            <!-- FINE CAMPI IN LINGUA -->


                <div class="form-group">
                    <span>* campi obbligatori</span>
                    <br><br>
                    <button class="btn btn-primary btn-lg mt-3 w-100" type="submit">
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
    /* editor delle textarea */
    /* ATTENZIONE !!! ho modificato il file summernote-bs4.js con il valore emptyPara: "" per non far comparire il tag p*/
    $(document).ready(function(){$('.summernote').summernote({height:100});});

    //per la multiselect
    $('.chosen-select').chosen({width: "100%"});
</script>
<script>

    // fine
    $("#<?= $this->form?>").validate({
        rules: {
            <?php foreach ($this->langs as $l): ?>
            nome_<?= $l->sigla?>:{required:true},
            <?php if($this->cm['desc_required']):?>
            desc_<?=$l->sigla?>:{required:true},
            <?php endif; ?>
                <?php endforeach; ?>
                <?php if($this->cm['con_categorie']): ?>
            id_categorie:{required:true},
            <?php endif; ?>
        },
        messages: {
            <?php foreach ($this->langs as $l): ?>
            nome_<?=$l->sigla?>:{required:"Campo Obbligatorio"},
            desc_<?=$l->sigla?>:{required:"Campo Obbligatorio"},
            <?php endforeach; ?>
            id_categorie: {required: "Campo Obbligatorio"},
        },
        submitHandler: function (form)
        {

            $.ajax({
                type: "POST",
                url: "<?= $this->form_action?>",
                data: $("#<?= $this->form?>").serialize(),
                dataType: "json",
                success: function (data)
                {
                    if (data.result === 1)
                    {
                        $(location).attr('href', data.url);
                    }
                    else
                    {
                        alert(data.msg);
                    }
                },
                error: function ()
                {
                    alert("Si è verificato un errore! Riprova!");
                }
            });
        }
    });
</script>