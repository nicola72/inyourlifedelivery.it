<?php

namespace App\Http\Controllers\Cms;

use App\Model\Availability;
use App\Model\Category;
use App\Model\Domain;
use App\Model\File;
use App\Model\Ingredient;
use App\Model\Module;
use App\Model\ModuleConfig;
use App\Model\Product;
use App\Model\Shop;
use App\Model\Url;
use App\Model\Variant;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use Intervention\Image\Facades\Image;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = \Auth::user('cms');

        if($user->role_id == 1)
        {
            $products = Product::all();
            $params = [
                'title_page' => 'Prodotti',
                'products' => $products,
                'user' => $user
            ];

            return view('cms.product.all_index',$params);
        }
        else
        {
            $shop = Shop::find($user->shop_id);
            $products = Product::where('shop_id',$shop->id)->get();
            $params = [
                'title_page' => 'Prodotti '.$shop->insegna,
                'products' => $products,
                'user' => $user
            ];
        }

        return view('cms.product.index',$params);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = \Auth::user('cms');
        if($user->role_id == 1)
        {
            return redirect('/cms/product');
        }

        $shop = Shop::find($user->shop_id);
        if(!$shop)
        {
            return redirect('/cms/product');
        }

        $categorie = Category::where('shop_id',$shop->id)->get();

        $params = [
            'form_name' => 'form_create_product',
            'title_page'=> 'Nuovo Prodotto',
            'shop' => $shop,
            'categorie' => $categorie,
        ];
        return view('cms.product.create',$params);
    }

    public function ingredients_and_variants(Request $request)
    {
        $user = \Auth::user('cms');
        if($user->role_id == 1)
        {
            return ['result' => 0,'msg' => 'Errore'];
        }

        $shop = Shop::find($user->shop_id);
        if(!$shop)
        {
            return ['result' => 0,'msg' => 'Errore'];
        }

        $category_id = $request->query('category_id');

        $ingredients = Ingredient::where('shop_id',$shop->id)->where('category_id',$category_id)->orderBy('nome_it')->get();
        $variants = Variant::where('shop_id',$shop->id)->where('category_id',$category_id)->orderBy('nome_it')->get();

        $html = View::make('cms.variant.ingredients_variants_select',['ingredients' => $ingredients,'variants' => $variants]);
        return ['result' => 1,'msg' => "$html"];
    }


    public function store(Request $request)
    {
        $user = \Auth::user('cms');
        if($user->role_id == 1)
        {
            return redirect('/cms/product');
        }

        $shop = Shop::find($user->shop_id);
        if($shop->id != $request->shop_id)
        {
            return redirect('/cms/product');
        }
        $langs = \Config::get('langs');
        $prezzo_scontato = ($request->prezzo_scontato != '') ? $request->prezzo_scontato : 0;

        $ingredients = $request->ingredients;
        $variants = $request->variants;
        $per_quando = $request->per_quando;
        $per_pranzo = 1;
        $per_cena = 1;
        if($per_quando == 'solo_pranzo')
        {
            $per_cena = 0;
        }
        elseif($per_quando == 'solo_cena')
        {
            $per_pranzo = 0;
        }

        try{
            $product = new Product();
            $product->shop_id = $shop->id;
            $product->category_id = $request->category_id;
            $product->codice = $request->codice;
            $product->prezzo = str_replace(',','.',$request->prezzo);
            $product->prezzo_scontato = str_replace(',','.',$prezzo_scontato);
            $product->con_omaggio = $request->con_omaggio;
            $product->pranzo = $per_pranzo;
            $product->cena = $per_cena;
            $product->novita = $request->novita;
            $product->visibile = $request->visibile;
            $product->omaggio = $request->omaggio;
            $product->max_aggiunte = $request->max_aggiunte;
            foreach ($langs as $lang)
            {
                $product->{'nome_'.$lang} = $request->{'nome_'.$lang};
                $product->{'desc_'.$lang} = $request->{'desc_'.$lang};

            }
            $product->save();

            //faccio gli agganci per gli ingredienti e le varianti
            if(is_array($ingredients) && count($ingredients) > 0)
            {
                foreach($ingredients as $item)
                {
                    $ingredient = Ingredient::find($item);
                    if($ingredient)
                    {
                        $product->ingredients()->attach($ingredient->id);
                    }

                }
            }

            if(is_array($variants) && count($variants) > 0)
            {
                foreach ($variants as $item)
                {
                    $variant = Variant::find($item);
                    if($variant)
                    {
                        $product->variants()->attach($variant->id);
                    }

                }
            }

        }
        catch(\Exception $e){

            return ['result' => 0,'msg' => $e->getMessage()];
        }


        $url = route('cms.prodotti');
        return ['result' => 1,'msg' => 'Elemento creato con successo!','url' => $url];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,$id)
    {
        $user = \Auth::user('cms');
        if($user->role_id == 1)
        {
            return redirect('/cms/product');
        }

        $shop = Shop::find($user->shop_id);
        $product = Product::find($id);

        if($shop->id != $product->shop_id)
        {
            return redirect('/cms/product');
        }

        $categorie = Category::all();
        $ingredients = Ingredient::where('shop_id',$shop->id)->where('category_id',$product->category_id)->orderBy('nome_it')->get();
        $variants = Variant::where('shop_id',$shop->id)->where('category_id',$product->category_id)->orderBy('nome_it')->get();

        $ings = $product->ingredients;
        $ing_selected = [];

        if($ings->count() > 0)
        {
            foreach($ings as $item)
            {
                $ing_selected[] = $item->id;
            }
        }

        $vars = $product->variants;
        $var_selected = [];

        if($vars->count() > 0)
        {
            foreach ($vars as $item)
            {
                $var_selected[] = $item->id;
            }
        }

        $params = [
            'title_page' => 'Modifica Prodotto '.$product->codice,
            'product' => $product,
            'categorie' => $categorie,
            'ingredients' => $ingredients,
            'variants' => $variants,
            'form_name' => 'form_edit_product',
            'var_selected' => $var_selected,
            'ing_selected' => $ing_selected,
        ];

        return view('cms.product.edit',$params);
    }


    public function update(Request $request, $id)
    {
        $product = Product::find($id);

        $user = \Auth::user('cms');
        if($user->role_id == 1)
        {
            return ['result' => 0,'msg' => 'Errore db'];
        }

        $shop = Shop::find($user->shop_id);
        if($product->shop_id != $shop->id)
        {
            return ['result' => 0,'msg' => 'Errore'];
        }

        $prezzo_scontato = ($request->prezzo_scontato != '') ? $request->prezzo_scontato : 0;

        $langs = \Config::get('langs');

        //prima elimino gli agganci con le varianti e gli ingredienti
        $product->variants()->detach();
        $product->ingredients()->detach();

        $ingredients = $request->ingredients;
        $variants = $request->variants;
        $per_quando = $request->per_quando;
        $per_pranzo = 1;
        $per_cena = 1;
        if($per_quando == 'solo_pranzo')
        {
            $per_cena = 0;
        }
        elseif($per_quando == 'solo_cena')
        {
            $per_pranzo = 0;
        }

        try{

            $product->category_id = $request->category_id;
            $product->codice = $request->codice;
            $product->prezzo = str_replace(',','.',$request->prezzo);
            $product->prezzo_scontato = str_replace(',','.',$prezzo_scontato);
            $product->con_omaggio = $request->con_omaggio;
            $product->pranzo = $per_pranzo;
            $product->cena = $per_cena;
            $product->max_aggiunte = $request->max_aggiunte;
            foreach ($langs as $lang)
            {
                $product->{'nome_'.$lang} = $request->{'nome_'.$lang};
                $product->{'desc_'.$lang} = $request->{'desc_'.$lang};
            }
            $product->save();

            //faccio gli agganci per gli ingredienti e le varianti
            if(is_array($ingredients) && count($ingredients) > 0)
            {
                foreach($ingredients as $item)
                {
                    $ingredient = Ingredient::find($item);
                    if($ingredient)
                    {
                        $product->ingredients()->attach($ingredient->id);
                    }

                }
            }

            if(is_array($variants) && count($variants) > 0)
            {
                foreach ($variants as $item)
                {
                    $variant = Variant::find($item);
                    if($variant)
                    {
                        $product->variants()->attach($variant->id);
                    }

                }
            }

        }
        catch(\Exception $e){

            return ['result' => 0,'msg' => $e->getMessage()];
        }

        $url = route('cms.prodotti');
        return ['result' => 1,'msg' => 'Elemento aggiornato con successo!','url' => $url];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::find($id);
        $product->variants()->detach();
        $product->ingredients()->detach();
        $product->delete();


        //elimino anche i file associati al prodotto
        $files = File::where('fileable_id',$product->id)->where('fileable_type','App\Model\Product')->get();
        foreach ($files as $file)
        {
            $file->delete();
        }

        return back()->with('success','Elemento cancellato!');
    }

    public function images(Request $request, $id)
    {
        $product = Product::find($id);

        $images = File::where('fileable_id',$id)->where('fileable_type','App\Model\Product')->orderBy('order')->get();

        //prendo il file di configurazione del modulo Product
        $productModule = Module::where('nome','prodotti')->first();
        $moduleConfigs = ModuleConfig::where('module_id',$productModule->id)->get();
        $uploadImgConfig = $moduleConfigs->where('nome','upload_image')->first();
        $upload_config = json_decode($uploadImgConfig->value);
        //---//

        $file_restanti = $upload_config->max_numero_file - $images->count();
        $limit_max_file = ($file_restanti > 0) ? false : true;

        $params = [
            'title_page' => 'Immagini Prodotto '.$product->codice,
            'images' => $images,
            'product' => $product,
            'limit_max_file' =>$limit_max_file,
            'max_numero_file'=> $upload_config->max_numero_file,
            'max_file_size' => $upload_config->max_file_size,
            'file_restanti' => $file_restanti,
            'extensions'=>$upload_config->extensions,

        ];
        return view('cms.product.images',$params);
    }

    public function upload_images(Request $request)
    {
        //prendo il file di configurazione del modulo Product
        $productModule = Module::where('nome','prodotti')->first();
        $moduleConfigs = ModuleConfig::where('module_id',$productModule->id)->get();
        $uploadImgConfig = $moduleConfigs->where('nome','upload_image')->first();
        $upload_config = json_decode($uploadImgConfig->value);
        //---//

        $fileable_id = $request->fileable_id;
        $fileable_type = 'App\Model\Product';

        $uploadedFile = $request->file('file');
        $filename = time().$uploadedFile->getClientOriginalName();

        try{
            \Storage::disk('file')->putFileAs('', $uploadedFile, $filename);
        }
        catch(\Exception $e){

            return ['result' => 0,'msg' => $e->getMessage()];
        }

        //se CROP configurato
        if(isset($upload_config->crop) && $upload_config->crop)
        {
            $x = $upload_config->default_crop_x;
            $y = $upload_config->default_crop_y;
            $path = $_SERVER['DOCUMENT_ROOT'].'/file/crop/'.$filename;
            $img = Image::make($_SERVER['DOCUMENT_ROOT'].'/file/'.$filename);
            $img->crop($x, $y);
            $img->save($path);
        }
        //---//

        //se configurate RESIZE
        if(isset($upload_config->resize))
        {
            $resizes = explode(',',$upload_config->resize);

            //faccio 2 resize come il vecchio sito e le chiamo big e small
            $small = $resizes[0];
            $big = $resizes[1];

            //la small
            $img = Image::make($_SERVER['DOCUMENT_ROOT'].'/file/'.$filename);
            $path = $_SERVER['DOCUMENT_ROOT'].'/file/small/'.$filename;
            $img->resize($small, null, function ($constraint) {$constraint->aspectRatio();});
            $img->save($path);

            //la big
            $img = Image::make($_SERVER['DOCUMENT_ROOT'].'/file/'.$filename);
            $path = $_SERVER['DOCUMENT_ROOT'].'/file/big/'.$filename;
            $img->resize($big, null, function ($constraint) {$constraint->aspectRatio();});
            $img->save($path);

        }
        //---//

        //inserisco il nome del file nel db
        try{
            $file = new File();
            $file->path = $filename;
            $file->fileable_id = $fileable_id;
            $file->fileable_type = $fileable_type;
            $file->save();
        }
        catch(\Exception $e){

            return ['result' => 0,'msg' => $e->getMessage()];
        }
        //---//

        $url = route('cms.prodotti');
        return ['result' => 1,'msg' => 'File caricato con successo!','url' => $url];
    }

    public function sort_images(Request $request)
    {
        $positions = $request->pos;
        $array_pos = explode(";", $positions);

        foreach ($array_pos as $valore)
        {
            $temp = explode("=", $valore);
            $id = intval($temp[0]);
            $ordine = intval($temp[1]);
            echo 'id='.$id." ordine=".$ordine;
            /*$file = File::find($id);
            $file->order = $ordine;
            $file->save();*/
        }
        return;
    }

    public function switch_visibility(Request $request)
    {
        $id = $request->id;
        $stato = $request->stato;

        try{
            $item = Product::find($id);
            $item->visibile = $stato;
            $item->save();
        }
        catch(\Exception $e){

            return ['result' => 0,'msg' => $e->getMessage()];
        }
        return ['result' => 1,'msg' => 'Elemento aggiornato con successo!'];

    }


    public function switch_omaggio(Request $request)
    {
        $id = $request->id;
        $stato = $request->stato;

        try{
            $item = Product::find($id);
            $item->omaggio = $stato;
            $item->save();
        }
        catch(\Exception $e){

            return ['result' => 0,'msg' => $e->getMessage()];
        }
        return ['result' => 1,'msg' => 'Elemento aggiornato con successo!'];

    }

    public function switch_novita(Request $request)
    {
        $id = $request->id;
        $stato = $request->stato;

        try{
            $item = Product::find($id);
            $item->novita = $stato;
            $item->save();
        }
        catch(\Exception $e){

            return ['result' => 0,'msg' => $e->getMessage()];
        }
        return ['result' => 1,'msg' => 'Elemento aggiornato con successo!'];

    }
}
