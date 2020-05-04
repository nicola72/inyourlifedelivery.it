<?php

namespace App\Http\Controllers\Cms;

use App\Model\Category;
use App\Model\Domain;
use App\Model\File;
use App\Model\Module;
use App\Model\ModuleConfig;
use App\Model\Pairing;
use App\Model\Product;
use App\Model\Url;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class SyncController extends Controller
{
    public function index()
    {
        $params = ['title_page' => 'Operazioni'];
        return view('cms.sync.index',$params);
    }

    public function sync_categorie()
    {
        \DB::table('categories')->truncate();

        $vecchie = \DB::table('tb_categorie')->get();
        foreach ($vecchie as $item)
        {
            $category = new Category();
            $category->id = $item->id;
            $category->macrocategory_id = $item->id_categoria_liv1;
            $category->nome_it = $item->nome_it;
            $category->nome_en = $item->nome_en;
            $category->desc_it = $item->descrizione_it;
            $category->desc_en = $item->descrizione_en;
            $category->order = $item->ordine;
            $category->save();
        }

        return back()->with('success','Categorie sincronizzate!');
    }

    public function sync_url_categorie()
    {
        $urls = Url::where('urlable_type','App\Model\Category')->delete();

        $categories = Category::all();
        $langs = \Config::get('langs');
        foreach ($categories as $cat)
        {

            foreach ($langs as $lang)
            {
                $domain = Domain::where('locale',$lang)->first();
                try{
                    $url = new Url();
                    $url->domain_id = $domain->id;
                    $url->locale = $lang;
                    $url->slug = Str::slug( $cat->macrocategory->{'nome_'.$lang}.'-'.$cat->macrocategory->id.'-'.$cat->id, '-');
                    $url->urlable_id = $cat->id;
                    $url->urlable_type = 'App\Model\Category';
                    $url->save();
                }
                catch(\Exception $e)
                {
                    return back()->with('error',$e->getMessage());
                }
            }
        }

        return back()->with('success','Urls create con successo!');
    }

    public function sync_prodotti()
    {
        \DB::table('products')->truncate();

        $vecchi = \DB::table('tb_prodotti')->get();
        foreach ($vecchi as $item)
        {
            $product = new Product();
            $product->id = $item->id;
            $product->category_id = $item->id_categoria;
            $product->codice = $item->codice;
            $product->prezzo = $item->prezzo;
            $product->prezzo_scontato = $item->prezzo_scontato;
            $product->acquistabile = $item->acquistabile;
            $product->stock = $item->qta_stock;
            if($item->disponibilita == 'disponibile')
            {
                $product->availability_id = 1;
            }
            elseif($item->disponibilita == 'non_disponibile')
            {
                $product->availability_id = 2;
            }
            elseif($item->disponibilita == 'disponibile_a_breve')
            {
                $product->availability_id = 3;
            }
            else
            {
                $product->availability_id = 4;
            }
            $product->nome_it = $item->nome_it;
            $product->nome_en = $item->nome_en;
            $product->desc_it = ltrim(strip_tags($item->descrizione_it));
            $product->desc_en = ltrim(strip_tags($item->descrizione_en));
            $product->desc_breve_it = ltrim(strip_tags($item->descrizione_breve_it));
            $product->desc_breve_en = ltrim(strip_tags($item->descrizione_breve_en));
            $product->misure_it = ltrim(strip_tags($item->dimensioni_it));
            $product->misure_en = ltrim(strip_tags($item->dimensioni_en));
            $product->peso = $item->peso;

            $product->visibile = ($item->visibile == 'si') ? 1:0;
            $product->italfama = ($item->visibile_su_italfama == 'si') ? 1:0;
            $product->novita = ($item->novita == 'si') ? 1:0;
            $product->offerta = ($item->offerta == 'si') ?1:0;
            $product->save();

        }
        return back()->with('success','Prodotti sincronizzati!');
    }

    public function sync_url_prodotti()
    {
        $urls = Url::where('urlable_type','App\Model\Product')->delete();

        $products = Product::all();
        $langs = \Config::get('langs');
        foreach ($products as $product)
        {

            foreach ($langs as $lang)
            {
                $domain = Domain::where('locale',$lang)->first();
                try{
                    $url = new Url();
                    $url->domain_id = $domain->id;
                    $url->locale = $lang;
                    $url->slug = trans('msg.dettaglio',[],$lang).'-'.$product->id;
                    $url->urlable_id = $product->id;
                    $url->urlable_type = 'App\Model\Product';
                    $url->save();
                }
                catch(\Exception $e)
                {
                    return back()->with('error',$e->getMessage());
                }
            }
        }

        return back()->with('success','Urls create con successo!');
    }

    public function sync_file_prodotti()
    {
        $files = File::where('fileable_type','App\Model\Product')->delete();
        $vecchi = \DB::table('tb_prodotti')->get();
        foreach ($vecchi as $item)
        {
            if($item->img_1 != '')
            {
                $file = new File();
                $file->path = $item->img_1;
                $file->fileable_id = $item->id;
                $file->fileable_type = 'App\Model\Product';
                $file->save();
            }
            if($item->img_2 != '')
            {
                $file = new File();
                $file->path = $item->img_2;
                $file->fileable_id = $item->id;
                $file->fileable_type = 'App\Model\Product';
                $file->save();
            }
            if($item->img_3 != '')
            {
                $file = new File();
                $file->path = $item->img_3;
                $file->fileable_id = $item->id;
                $file->fileable_type = 'App\Model\Product';
                $file->save();
            }
            if($item->img_4 != '')
            {
                $file = new File();
                $file->path = $item->img_4;
                $file->fileable_id = $item->id;
                $file->fileable_type = 'App\Model\Product';
                $file->save();
            }
            if($item->img_5 != '')
            {
                $file = new File();
                $file->path = $item->img_5;
                $file->fileable_id = $item->id;
                $file->fileable_type = 'App\Model\Product';
                $file->save();
            }
        }
        return back()->with('success','Immagini Prodotti sincronizzati!');
    }

    public function sync_abbinamenti()
    {
        \DB::table('pairings')->truncate();
        $vecchi = \DB::table('tb_abbinamenti')->get();
        foreach ($vecchi as $item)
        {
            $pairing = new Pairing();
            $pairing->id = $item->id;
            $pairing->category_id = $item->id_tipologia;
            $pairing->product1_id = $item->id_prodotto1;
            $pairing->product2_id = $item->id_prodotto2;
            if($item->stile_per_filtro == 'Set Tradizionali da Gioco' )
            {
                $pairing->style_id = 1;
            }
            elseif ($item->stile_per_filtro == 'Set Classici')
            {
                $pairing->style_id = 2;
            }
            elseif ($item->stile_per_filtro == 'Set Moderni')
            {
                $pairing->style_id = 3;
            }
            else
            {
                $pairing->style_id = 3;
            }
            $pairing->nome_it = $item->titolo;
            $pairing->nome_en = $item->titolo_en;
            $pairing->desc_it = ltrim(strip_tags($item->descrizione));
            $pairing->desc_en = ltrim(strip_tags($item->descrizione_en));
            $pairing->visibile = ($item->visibile == 'si') ? 1:0;
            $pairing->italfama = ($item->visibile_su_italfama == 'si') ? 1:0;
            $pairing->novita = ($item->novita == 'si') ? 1:0;
            $pairing->offerta = ($item->offerta == 'si') ?1:0;
            $pairing->save();

        }
        return back()->with('success','Abbinamenti sincronizzati!');
    }

    public function sync_file_abbinamenti()
    {
        $files = File::where('fileable_type','App\Model\Pairing')->delete();
        $vecchi = \DB::table('tb_abbinamenti')->get();
        foreach ($vecchi as $item)
        {
            if($item->img != '')
            {
                $file = new File();
                $file->path = $item->img;
                $file->fileable_id = $item->id;
                $file->fileable_type = 'App\Model\Pairing';
                $file->save();
            }
            if($item->img_2 != '')
            {
                $file = new File();
                $file->path = $item->img_2;
                $file->fileable_id = $item->id;
                $file->fileable_type = 'App\Model\Pairing';
                $file->save();
            }
            if($item->img_3 != '')
            {
                $file = new File();
                $file->path = $item->img_3;
                $file->fileable_id = $item->id;
                $file->fileable_type = 'App\Model\Pairing';
                $file->save();
            }
            if($item->img_4 != '')
            {
                $file = new File();
                $file->path = $item->img_4;
                $file->fileable_id = $item->id;
                $file->fileable_type = 'App\Model\Pairing';
                $file->save();
            }

        }
        return back()->with('success','Immagini Abbinamenti sincronizzati!');
    }

    public function sync_url_abbinamenti()
    {
        $urls = Url::where('urlable_type','App\Model\Pairing')->delete();

        $pairings = Pairing::all();
        $langs = \Config::get('langs');
        foreach ($pairings as $pairing)
        {

            foreach ($langs as $lang)
            {
                $domain = Domain::where('locale',$lang)->first();
                try{
                    $url = new Url();
                    $url->domain_id = $domain->id;
                    $url->locale = $lang;
                    $url->slug = trans('msg.dettaglio_abbinamento',[],$lang).'-'.$pairing->id;
                    $url->urlable_id = $pairing->id;
                    $url->urlable_type = 'App\Model\Pairing';
                    $url->save();
                }
                catch(\Exception $e)
                {
                    return back()->with('error',$e->getMessage());
                }
            }
        }

        return back()->with('success','Urls create con successo!');
    }

    public function create_thumbs(Request $request)
    {
        $per_page = 10;
        $page = ($request->page) ? $request->page : 1;
        $offset = $per_page * $page;

        //$allfiles = File::where('fileable_type','App\Model\Product')->get();
        $allfiles = File::where('fileable_type','App\Model\Pairing')->get();
        $numero_files = $allfiles->count();
        $pagine = ceil($numero_files/$per_page);

        //$files = File::where('fileable_type','App\Model\Product')->offset($offset)->limit($per_page)->get();
        $files = File::where('fileable_type','App\Model\Pairing')->offset($offset)->limit($per_page)->get();

        foreach ($files as $file)
        {
            //prendo il file di configurazione del modulo Product
            $productModule = Module::where('nome','prodotti')->first();
            $moduleConfigs = ModuleConfig::where('module_id',$productModule->id)->get();
            $uploadImgConfig = $moduleConfigs->where('nome','upload_image')->first();
            $upload_config = json_decode($uploadImgConfig->value);
            //---//

            $resizes = explode(',',$upload_config->resize);

            //faccio 2 resize come il vecchio sito e le chiamo big e small
            $small = $resizes[0];
            $big = $resizes[1];

            //la small
            $img = Image::make($_SERVER['DOCUMENT_ROOT'].'/file/'.$file->path);
            $path = $_SERVER['DOCUMENT_ROOT'].'/file/small/'.$file->path;
            $img->resize($small, null, function ($constraint) {$constraint->aspectRatio();});
            $img->save($path);

            //la big
            $img = Image::make($_SERVER['DOCUMENT_ROOT'].'/file/'.$file->path);
            $path = $_SERVER['DOCUMENT_ROOT'].'/file/big/'.$file->path;
            $img->resize($big, null, function ($constraint) {$constraint->aspectRatio();});
            $img->save($path);
        }

        $params = [
            'page'=>$page,
            'per_page'=>$per_page,
            'numero_files'=>$numero_files,
            'title_page' => 'Crea Thumbs',
            'pagine' => $pagine,
        ];
        return view('cms.sync.create_thumb',$params);
    }

    public function create_watermarks(Request $request)
    {
        $per_page = 10;
        $page = ($request->page) ? $request->page : 1;
        $offset = $per_page * $page;

        //$allfiles = File::where('fileable_type','App\Model\Product')->get();
        $allfiles = File::where('fileable_type','App\Model\Pairing')->get();
        $numero_files = $allfiles->count();
        $pagine = ceil($numero_files/$per_page);

        //$files = File::where('fileable_type','App\Model\Product')->offset($offset)->limit($per_page)->get();
        $files = File::where('fileable_type','App\Model\Pairing')->offset($offset)->limit($per_page)->get();

        foreach ($files as $file)
        {
            if(file_exists($_SERVER['DOCUMENT_ROOT'].'/file/small/'.$file->path))
            {
                $img = Image::make($_SERVER['DOCUMENT_ROOT'].'/file/small/'.$file->path);

                /* insert watermark at bottom-right corner with 10px offset */
                $img->insert($_SERVER['DOCUMENT_ROOT'].'/img/watermark_small.png', 'bottom-right', 50, 50);

                $img->save($_SERVER['DOCUMENT_ROOT'].'/file/wmc/small/'.$file->path);
            }

        }

        $params = [
            'page'=>$page,
            'per_page'=>$per_page,
            'numero_files'=>$numero_files,
            'title_page' => 'Crea Watermark',
            'pagine' => $pagine,
        ];
        return view('cms.sync.create_watermarks',$params);
    }

    public function create_watermarks_ital(Request $request)
    {
        $per_page = 5;
        $page = ($request->page) ? $request->page : 1;
        $offset = $per_page * $page;

        //$allfiles = File::where('fileable_type','App\Model\Product')->get();
        $allfiles = File::where('fileable_type','App\Model\Pairing')->get();
        $numero_files = $allfiles->count();
        $pagine = ceil($numero_files/$per_page);

        //$files = File::where('fileable_type','App\Model\Product')->offset($offset)->limit($per_page)->get();
        $files = File::where('fileable_type','App\Model\Pairing')->offset($offset)->limit($per_page)->get();

        foreach ($files as $file)
        {
            if(file_exists($_SERVER['DOCUMENT_ROOT'].'/file/small/'.$file->path))
            {
                $img = Image::make($_SERVER['DOCUMENT_ROOT'].'/file/small/'.$file->path);

                /* insert watermark at bottom-right corner with 10px offset */
                $img->insert($_SERVER['DOCUMENT_ROOT'].'/img/watermark2_small.png', 'bottom-right', 50, 50);

                $img->save($_SERVER['DOCUMENT_ROOT'].'/file/wmi/small/'.$file->path);
            }

        }

        $params = [
            'page'=>$page,
            'per_page'=>$per_page,
            'numero_files'=>$numero_files,
            'title_page' => 'Crea Watermark',
            'pagine' => $pagine,
        ];
        return view('cms.sync.create_watermarks_ital',$params);
    }
}
