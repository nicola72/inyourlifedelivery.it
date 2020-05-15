<?php

namespace App\Http\Controllers\Cms;

use App\Model\Category;
use App\Model\Domain;
use App\Model\File;
use App\Model\Macrocategory;
use App\Model\Module;
use App\Model\ModuleConfig;
use App\Model\Product;
use App\Model\Shop;
use App\Model\Url;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class CategoryController extends Controller
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
            $categorie = Category::orderBy('order', 'desc')->get();
            $params = [
                'title_page' => 'Categorie',
                'categorie' => $categorie,
                'user' => $user
            ];

            return view('cms.category.all_index',$params);
        }
        else
        {
            $shop = Shop::find($user->shop_id);

            $categorie = Category::where('shop_id',$shop->id)->orderBy('order', 'desc')->get();
            $params = [
                'title_page' => 'Categorie',
                'categorie' => $categorie,
                'user' => $user
            ];
        }

        return view('cms.category.index',$params);
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
            return redirect('/cms/category');
        }

        $shop = Shop::find($user->shop_id);
        if(!$shop)
        {
            return redirect('/cms/category');
        }

        $macro = Macrocategory::all()->first();

        $params = [
            'form_name' => 'form_create_category',
            'macro' => $macro,
            'shop' => $shop,
        ];
        return view('cms.category.create',$params);
    }


    public function store(Request $request)
    {
        $user = \Auth::user('cms');
        if($user->role_id == 1)
        {
            return redirect('/cms/category');
        }

        $shop = Shop::find($user->shop_id);
        if($shop->id != $request->shop_id)
        {
            return redirect('/cms/category');
        }

        $langs = \Config::get('langs');

        try{
            $categoria = new Category();
            $categoria->shop_id = $request->shop_id;
            $categoria->macrocategory_id = $request->macrocategory_id;
            foreach ($langs as $lang)
            {
                $categoria->{'nome_'.$lang} = $request->{'nome_'.$lang};
            }
            $categoria->save();
            $categoria_id = $categoria->id;

        }
        catch(\Exception $e){

            if(\App::environment() == 'develop')
            {
                return ['result' => 0,'msg' => $e->getMessage()];
            }
            else
            {
                return ['result' => 0,'msg' => 'Errore db'];
            }
        }

        $macro = Macrocategory::find($categoria->macrocategory_id);

        //1# Creo una url di default per ogni lingua
        foreach ($langs as $lang)
        {
            $domain = Domain::where('locale',$lang)->first();
            try{
                $url = new Url();
                $url->domain_id = $domain->id;
                $url->locale = $lang;
                $url->slug = Str::slug( $macro->{'nome_'.$lang}.'-'.$macro->id.'-'.$categoria->id, '-');
                $url->urlable_id = $categoria_id;
                $url->urlable_type = 'App\Model\Category';
                $url->save();
            }
            catch(\Exception $e)
            {
                if(\App::environment() == 'develop')
                {
                    return ['result' => 0,'msg' => $e->getMessage()];
                }
                else
                {
                    return ['result' => 0,'msg' => 'Errore db'];
                }
            }
        }
        //1# Fine

        $url = url('/cms/category');
        return ['result' => 1,'msg' => 'Elemento inserito con successo!','url' => $url];
    }

    public function move_up(Request $request,$id)
    {
        $cat = Category::find($id);
        $cat->moveOrderUp();
        return back();
    }

    public function move_down(Request $request,$id)
    {
        $cat = Category::find($id);
        $cat->moveOrderDown();
        return back();
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
        $user = \Auth::user('cms');
        if($user->role_id == 1)
        {
            return redirect('/cms/category');
        }

        $categoria = Category::find($id);

        $user_shop = Shop::find($user->shop_id);
        if($user_shop->id != $categoria->shop_id)
        {
            return redirect('/cms/category');
        }

        $params = [
            'categoria' => $categoria,
            'form_name' => 'form_edit_categoria'
        ];

        return view('cms.category.edit',$params);
    }


    public function update(Request $request, $id)
    {
        $user = \Auth::user('cms');
        if($user->role_id == 1)
        {
            return ['result' => 0,'msg' => 'Errore db'];
        }

        $shop = Shop::find($user->shop_id);
        $categoria = Category::find($id);

        if($categoria->shop_id != $shop->id)
        {
            return ['result' => 0,'msg' => 'Errore db'];
        }

        $langs = \Config::get('langs');

        try{

            foreach ($langs as $lang)
            {
                $categoria->{'nome_'.$lang} = $request->{'nome_'.$lang};
            }
            $categoria->save();

        }
        catch(\Exception $e){

            if(\App::environment() == 'develop')
            {
                return ['result' => 0,'msg' => $e->getMessage()];
            }
            else
            {
                return ['result' => 0,'msg' => 'Errore db'];
            }
        }

        $url = route('cms.categorie');
        return ['result' => 1,'msg' => 'Elemento aggiornato con successo!','url' => $url];
    }

    public function images(Request $request, $id)
    {
        $category = Category::find($id);

        $images = File::where('fileable_id',$id)->where('fileable_type','App\Model\Category')->orderBy('order')->get();

        //prendo il file di configurazione del modulo Product
        $categoryModule = Module::where('nome','categorie')->first();
        $moduleConfigs = ModuleConfig::where('module_id',$categoryModule->id)->get();
        $uploadImgConfig = $moduleConfigs->where('nome','upload_image')->first();
        $upload_config = json_decode($uploadImgConfig->value);
        //---//

        $file_restanti = $upload_config->max_numero_file - $images->count();
        $limit_max_file = ($file_restanti > 0) ? false : true;

        $params = [
            'title_page' => 'Immagini Categoria '.$category->nome_it,
            'images' => $images,
            'category' => $category,
            'limit_max_file' =>$limit_max_file,
            'max_numero_file'=> $upload_config->max_numero_file,
            'max_file_size' => $upload_config->max_file_size,
            'file_restanti' => $file_restanti,
            'extensions'=>$upload_config->extensions,

        ];
        return view('cms.category.images',$params);
    }

    public function upload_images(Request $request)
    {
        //prendo il file di configurazione del modulo Product
        $categoryModule = Module::where('nome','categorie')->first();
        $moduleConfigs = ModuleConfig::where('module_id',$categoryModule->id)->get();
        $uploadImgConfig = $moduleConfigs->where('nome','upload_image')->first();
        $upload_config = json_decode($uploadImgConfig->value);
        //---//

        $fileable_id = $request->fileable_id;
        $fileable_type = 'App\Model\Category';

        $uploadedFile = $request->file('file');
        $filename = time().$uploadedFile->getClientOriginalName();

        try{
            \Storage::disk('file')->putFileAs('', $uploadedFile, $filename);
        }
        catch(\Exception $e){

            if(\App::environment() == 'develop')
            {
                return ['result' => 0,'msg' => $e->getMessage()];
            }
            else
            {
                return ['result' => 0,'msg' => 'Errore db'];
            }
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

            if(\App::environment() == 'develop')
            {
                return ['result' => 0,'msg' => $e->getMessage()];
            }
            else
            {
                return ['result' => 0,'msg' => 'Errore db'];
            }
        }
        //---//

        $url = route('cms.categorie');
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
        $user = \Auth::user('cms');
        if($user->role_id == 1)
        {
            return back()->with('error','Non hai il permesso di eseguire questa operazione!');
        }

        //return back()->with('error','Devo fare controllo prodotti presenti!');
        $categoria = Category::find($id);
        if(!$categoria)
        {
            return back()->with('error','Errore! categoria non trovata');
        }

        $user_shop = Shop::find($user->shop_id);
        if($user_shop->id != $categoria->shop_id)
        {
            return back()->with('error','Non hai il permesso di eseguire questa operazione!');
        }

        //controllo che non ci siano prodotti associati
        if($categoria->products->count() > 0)
        {
            return back()->with('error','Non puoi eliminare questa categoria perche ci sono prodotti associati!');
        }

        //controllo che non ci siano varianti associate
        if($categoria->variants->count() > 0)
        {
            return back()->with('error','Non puoi eliminare questa categoria perche ci sono varianti associate!');
        }

        //controllo che non ci siano ingredienti associati
        if($categoria->ingredients->count() > 0)
        {
            return back()->with('error','Non puoi eliminare questa categoria perche ci sono ingredienti associati!');
        }

        $categoria->delete();

        return back()->with('success','Elemento cancellato!');
    }

    public function switch_stato(Request $request)
    {
        $id = $request->id;
        $stato = $request->stato;

        try{
            $item = Category::find($id);
            $item->stato = $stato;
            $item->save();
        }
        catch(\Exception $e){

            return ['result' => 0,'msg' => $e->getMessage()];
        }
        return ['result' => 1,'msg' => 'Elemento aggiornato con successo!'];

    }
}
