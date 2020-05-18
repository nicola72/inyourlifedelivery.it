<?php

namespace App\Http\Controllers\Website;

use App\Mail\Contact;
use App\Model\Cart;
use App\Model\Category;
use App\Model\Domain;
use App\Model\File;
use App\Model\Ingredient;
use App\Model\Macrocategory;
use App\Model\Newsitem;
use App\Model\Page;
use App\Model\Pairing;
use App\Model\Product;
use App\Model\Seo;
use App\Model\Shop;
use App\Model\Slider;
use App\Model\Variant;
use Illuminate\Http\Request;
use App\Model\Url;
use App\Http\Controllers\Controller;
use App\Service\GoogleRecaptcha;

class PageController extends Controller
{
    protected $shop;

    public function __construct()
    {
        $this->middleware(function($request, $next)
        {
            $domain = $request->getHttpHost();
            $domain = str_replace("www","",$domain);
            $this->shop = Shop::where('domain',$domain)->first();
            return $next($request);
        });

    }

    public function index(Request $request)
    {
        if(!$this->shop)
        {
            return view('website.page.dominio_sbagliato');
        }

        $categories = Category::where('shop_id',$this->shop->id)->where('stato',1)->orderBy('order')->get();

        $first_cat = $categories->first();
        $products = Product::where('category_id',$first_cat->id)->where('visibile',1)->where('omaggio',0)->where('shop_id',$this->shop->id)->get();
        $ingredients = Ingredient::where('category_id',$first_cat->id)->where('shop_id',$this->shop->id)->where('visibile',1)->orderBy('nome_it')->get();
        $variants = Variant::where('category_id',$first_cat->id)->where('shop_id',$this->shop->id)->where('visibile',1)->orderBy('nome_it')->get();

        $params = [
            'shop' => $this->shop,
            'categories' => $categories,
            'products' => $products,
            'ingredients' => $ingredients,
            'variants' => $variants,
        ];
        return view('website.page.index',$params);
    }

    public function add_to_cart(Request $request)
    {
        $product_id = decrypt($request->input('product_id',null));
        $shop_id = decrypt($request->input('shop_id',null));

        \Log::debug('add_to_cart product_id='.$product_id.' shop_id='.$shop_id);

        if($product_id == null || $shop_id == null)
        {
            \Log::error('fallito add_to_cart  con product_id='.$product_id.' e shop_id='.$shop_id);
            return ['result' => 0, 'msg' => 'Errore'];
        }

        $shop = Shop::find($shop_id);
        if(!$shop)
        {
            \Log::error('fallito add_to_cart  non trovato il negozio con id='.$shop_id);
            return ['result' => 0, 'msg' => 'Errore'];
        }

        $product = Product::find($product_id);
        if(!$product)
        {
            \Log::error('fallito add_to_cart  non trovato il prodotto con id='.$shop_id);
            return ['result' => 0, 'msg' => 'Errore'];
        }

        $prezzo = $product->prezzo_vendita();
        $qty = $request->input('qty',1);

        //controllo gli ingredienti eliminati
        $ingredienti_eliminati = "";

        if($product->ingredients->count() > 0)
        {
            foreach($product->ingredients as $ing)
            {
                if(!$request->has('ingredient_'.$ing->id))
                {
                    $ingredienti_eliminati .= $ing->nome_it.",";
                }
            }
            //elimino l'ultima virgola
            if($ingredienti_eliminati != '')
            {
                $ingredienti_eliminati = substr($ingredienti_eliminati, 0, strlen($ingredienti_eliminati) - 1);
            }
        }

        //controllo gli ingredienti aggiunti
        $ingredienti_aggiunti = "";

        if($product->ingredienti_da_aggiungere()->count() > 0)
        {
            foreach($product->ingredienti_da_aggiungere() as $ing)
            {
                if($request->has('ingredient_'.$ing->id))
                {
                    $ingredienti_aggiunti .= $ing->nome_it.",";
                    $prezzo = $prezzo + $ing->prezzo;
                }
            }
            //elimino l'ultima virgola
            if($ingredienti_aggiunti != '')
            {
                $ingredienti_aggiunti = substr($ingredienti_aggiunti, 0, strlen($ingredienti_aggiunti) - 1);
            }
        }


        //controllo se c'è la variante
        $variante = "";

        if($product->variants->count() > 0)
        {
            foreach ($product->variants as $variant)
            {
                if($request->has('variante'))
                {
                    $variant_id = $request->input('variante');
                    $var = Variant::find($variant_id);
                    if($var)
                    {
                        $variante = $var->nome_it;
                        if($var->type == '+')
                        {
                            $prezzo = $prezzo + $var->prezzo;
                        }
                        else
                        {
                            $prezzo = $prezzo - $var->prezzo;
                        }
                    }
                    break;
                }
            }
        }

        try
        {
            $cart = new Cart();
            $cart->product_id = $product_id;
            $cart->shop_id = $shop_id;
            $cart->nome_prodotto = $product->nome_it;
            $cart->ingredienti_aggiunti = $ingredienti_aggiunti;
            $cart->ingredienti_eliminati = $ingredienti_eliminati;
            $cart->variante = $variante;
            $cart->session_id = \Session::getId();
            $cart->qta = $qty;
            $cart->prezzo = $prezzo;
            $cart->totale = $prezzo * $qty;
            $cart->save();
        }
        catch (\Exception $e)
        {
            \Log::error('fallito add_to_cart  errore inserimento '.$e->getMessage() );
            return ['result' => 0,'msg' => 'Errore! impossibile inserire il prodotto selezionato'];
        }

        return ['result' => 1, 'msg' => 'Successo! Prodotto inserito nel carrello'];
    }

    public function invia_formcontatti(Request $request)
    {
        $data = $request->post();
        $config = \Config::get('website_config');
        $secret = $config['recaptcha_secret'];

        if(!GoogleRecaptcha::verifyGoogleRecaptcha($data,$secret))
        {
            return ['result' => 0, 'msg' => trans('msg.il_codice_di_controllo_errato')];
        }

        $to = ($config['in_sviluppo']) ? $config['email_debug'] : $config['email'];

        $mail = new Contact($data);

        try{
            \Mail::to($to)->send($mail);
        }
        catch(\Exception $e)
        {
            return ['result' => 0, 'msg' => $e->getMessage()];
        }

        return ['result' => 1, 'msg' => trans('msg.grazie_per_averci_contattato')];

    }


}
