<?php

namespace App\Http\Controllers\Cms;

use App\Model\Category;
use App\Model\File;
use App\Model\Module;
use App\Model\ModuleConfig;
use App\Model\Pairing;
use App\Model\Product;
use App\Model\Style;
use App\Model\Url;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;

class PairingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::all();
        $pairings = Pairing::all();
        $params = [
            'title_page' => 'Abbinamenti',
            'products' => $products,
            'pairings' => $pairings
        ];
        return view('cms.pairing.index',$params);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //prendo le categorie con la macro Set Completi
        $categorie = Category::where('macrocategory_id',22)->get();
        $styles = Style::all();
        $products = Product::all();
        $params = [
            'form_name' => 'form_create_pairing',
            'title_page'=> 'Nuovo Abbinamento',
            'categorie' => $categorie,
            'products' => $products,
            'styles' => $styles,
        ];
        return view('cms.pairing.create',$params);
    }

    public function store(Request $request)
    {
        $langs = \Config::get('langs');
        //$product1 = Product::find($request->product1_id);
        //$product2 = Product::find($request->product2_id);

        try{
            $pairing = new Pairing();
            $pairing->category_id = $request->category_id;
            $pairing->style_id = $request->style_id;
            $pairing->product1_id = $request->product1_id;
            $pairing->product2_id = $request->product2_id;
            $pairing->novita = $request->novita;
            $pairing->offerta = $request->offerta;
            $pairing->visibile = $request->visibile;
            $pairing->italfama = $request->italfama;
            foreach ($langs as $lang)
            {
                $pairing->{'nome_'.$lang} = $request->{'nome_'.$lang};
                $pairing->{'desc_'.$lang} = $request->{'desc_'.$lang};
            }
            $pairing->save();
            $pairing_id = $pairing->id;

        }
        catch(\Exception $e){

            return ['result' => 0,'msg' => $e->getMessage()];
        }

        $url = route('cms.abbinamenti');
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
    public function edit($id)
    {
        $categorie = Category::where('macrocategory_id',22)->get();
        $styles = Style::all();
        $products = Product::all();

        $pairing = Pairing::find($id);
        $params = [
            'title_page' => 'Modifica Abbinamento '.$pairing->nome_it,
            'pairing' => $pairing,
            'categorie' => $categorie,
            'products' => $products,
            'styles' => $styles,
            'form_name' => 'form_edit_pairing'
        ];

        return view('cms.pairing.edit',$params);
    }

    public function update(Request $request, $id)
    {
        $pairing = Pairing::find($id);

        $langs = \Config::get('langs');

        try{

            $pairing->category_id = $request->category_id;
            $pairing->style_id = $request->style_id;
            $pairing->product1_id = $request->product1_id;
            $pairing->product2_id = $request->product2_id;
            foreach ($langs as $lang)
            {
                $pairing->{'nome_'.$lang} = $request->{'nome_'.$lang};
                $pairing->{'desc_'.$lang} = $request->{'desc_'.$lang};
                $pairing->{'desc_breve_'.$lang} = $request->{'desc_breve_'.$lang};
            }
            $pairing->save();

        }
        catch(\Exception $e){

            return ['result' => 0,'msg' => $e->getMessage()];
        }

        $url = route('cms.abbinamenti');
        return ['result' => 1,'msg' => 'Elemento aggiornato con successo!','url' => $url];
    }

    public function images(Request $request, $id)
    {
        $pairing = Pairing::find($id);

        $images = File::where('fileable_id',$id)->where('fileable_type','App\Model\Pairing')->orderBy('order')->get();

        //prendo il file di configurazione del modulo Product
        $productModule = Module::where('nome','abbinamenti')->first();
        $moduleConfigs = ModuleConfig::where('module_id',$productModule->id)->get();
        $uploadImgConfig = $moduleConfigs->where('nome','upload_image')->first();
        $upload_config = json_decode($uploadImgConfig->value);
        //---//

        $file_restanti = $upload_config->max_numero_file - $images->count();
        $limit_max_file = ($file_restanti > 0) ? false : true;

        $params = [
            'title_page' => 'Immagini Abbinamento '.$pairing->nome_it,
            'images' => $images,
            'pairing' => $pairing,
            'limit_max_file' =>$limit_max_file,
            'max_numero_file'=> $upload_config->max_numero_file,
            'max_file_size' => $upload_config->max_file_size,
            'file_restanti' => $file_restanti,
            'extensions'=>$upload_config->extensions,

        ];

        return view('cms.pairing.images',$params);
    }

    public function upload_images(Request $request)
    {
        //prendo il file di configurazione del modulo Product
        $productModule = Module::where('nome','abbinamenti')->first();
        $moduleConfigs = ModuleConfig::where('module_id',$productModule->id)->get();
        $uploadImgConfig = $moduleConfigs->where('nome','upload_image')->first();
        $upload_config = json_decode($uploadImgConfig->value);
        //---//

        $fileable_id = $request->fileable_id;
        $fileable_type = 'App\Model\Pairing';

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

            //creo anche le watermarks per chess
            $img = Image::make($_SERVER['DOCUMENT_ROOT'].'/file/small/'.$filename);
            $img->insert($_SERVER['DOCUMENT_ROOT'].'/img/watermark2_small.png', 'bottom-right', 50, 50);
            $img->save($_SERVER['DOCUMENT_ROOT'].'/file/wmi/small/'.$filename);
            $img = Image::make($_SERVER['DOCUMENT_ROOT'].'/file/big/'.$filename);
            $img->insert($_SERVER['DOCUMENT_ROOT'].'/img/watermark2_small.png', 'bottom-right', 50, 50);
            $img->save($_SERVER['DOCUMENT_ROOT'].'/file/wmi/big/'.$filename);

            //crea anche le watermarks per italfama
            $img = Image::make($_SERVER['DOCUMENT_ROOT'].'/file/small/'.$filename);
            $img->insert($_SERVER['DOCUMENT_ROOT'].'/img/watermark_small.png', 'bottom-right', 50, 50);
            $img->save($_SERVER['DOCUMENT_ROOT'].'/file/wmc/small/'.$filename);
            $img = Image::make($_SERVER['DOCUMENT_ROOT'].'/file/big/'.$filename);
            $img->insert($_SERVER['DOCUMENT_ROOT'].'/img/watermark_small.png', 'bottom-right', 50, 50);
            $img->save($_SERVER['DOCUMENT_ROOT'].'/file/wmc/big/'.$filename);
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

        $url = route('cms.abbinamenti');
        return ['result' => 1,'msg' => 'File caricato con successo!','url' => $url];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pairing = Pairing::find($id);
        $pairing->delete();

        //elimino anche le url associate al prodotto
        $urls = Url::where('urlable_id',$pairing->id)->where('urlable_type','App\Model\Pairing')->get();
        foreach ($urls as $url)
        {
            $url->delete();
        }

        //elimino anche i file associati al prodotto
        $files = File::where('fileable_id',$pairing->id)->where('fileable_type','App\Model\Product')->get();
        foreach ($files as $file)
        {
            $file->delete();
        }

        return back()->with('success','Elemento cancellato!');
    }
}
