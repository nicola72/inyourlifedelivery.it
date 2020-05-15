<div class="form-group">
    <div class="row">
        @if($ingredients->count() > 0)
        <div class="col-md-6">
            <label>Ingredienti <small>(quelli già presenti nel prodotto)</small></label>
            <select name="ingredients[]" id="ingredients" class="chosen-select" data-placeholder="Seleziona" multiple style="width:350px;">
                @foreach($ingredients as $ingredient)
                    <option value="{{$ingredient->id}}">{{$ingredient->nome_it}}</option>
                @endforeach
            </select>
        </div>
        @endif
        @if($variants->count() > 0)
        <div class="col-md-4">
            <label>Varianti <small>(stabilisci le varianti da poter scegliere)</small></label>
            <select name="variants[]" id="variants" class="chosen-select" data-placeholder="Seleziona" multiple style="width:350px;">
                @foreach($variants as $variant)
                    <option value="{{$variant->id}}">{{$variant->nome_it}}</option>
                @endforeach
            </select>
        </div>
        @endif
    </div>
</div>
<script>
    //per la multiselect
    $('.chosen-select').chosen({width: "100%"});
</script>