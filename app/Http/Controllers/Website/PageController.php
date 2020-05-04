<?php

namespace App\Http\Controllers\Website;

use App\Mail\Contact;
use App\Model\Domain;
use App\Model\File;
use App\Model\Macrocategory;
use App\Model\Newsitem;
use App\Model\Page;
use App\Model\Pairing;
use App\Model\Product;
use App\Model\Seo;
use App\Model\Slider;
use Illuminate\Http\Request;
use App\Model\Url;
use App\Http\Controllers\Controller;
use App\Service\GoogleRecaptcha;

class PageController extends Controller
{
    public function __construct()
    {
    }

    public function index(Request $request)
    {
        //per stabilire la lingua dobbiamo basarci sul dominio/alias
        $domain = $request->getHttpHost();
        $domain = str_replace("www","",$domain);
        $domain = Domain::where('nome',$domain)->first();
        $locale = $domain->locale;
        \App::setLocale($locale);

        $seo = Seo::where('locale',$locale)->where('homepage',1)->first();
        $slider = Slider::where('visibile',1)->first();
        $macrocategorie = Macrocategory::where('stato',1)->orderBy('order')->get();
        $prodotti_novita = Product::where('visibile',1)->where('availability_id','!=',2)->where('novita',1)->get();
        $abbinamenti_novita = Pairing::where('visibile',1)->where('novita',1)->get();
        $prodotti_offerta = Product::where('visibile',1)->where('availability_id','!=',2)->where('offerta',1)->get();
        $abbinamenti_offerta = Pairing::where('visibile',1)->where('offerta',1)->get();
        $popup = Newsitem::where('visibile',1)->where('popup',1)->first();


        $params = [
            'seo' => $seo,
            'slider' => $slider,
            'macrocategorie' => $macrocategorie,
            'macro_request' => null, //paramtero necessario per stabilire il collapse del menu a sinistra
            'prodotti_novita' => $prodotti_novita,
            'abbinamenti_novita' => $abbinamenti_novita,
            'prodotti_offerta' => $prodotti_offerta,
            'abbinamenti_offerta' => $abbinamenti_offerta,
            'popup'=> $popup
        ];
        return view('website.page.index',$params);
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


    public function page(Request $request)
    {
        $slug = $request->segment(2);

        //prendo la url con quello slug e con la lingua
        $url = Url::where('slug',$slug)->first();

        if($url)
        {
            //se non siamo sul dominio giusto faccio il redirect
            if($url->domain->nome != $_SERVER['HTTP_HOST'] && "www.".$url->domain->nome != $_SERVER['HTTP_HOST'])
            {
                header("HTTP/1.1 301 Moved Permanently");
                header("Location: https://www.".$url->domain->nome."/".$url->locale."/".$url->slug);
                exit();
            }

            switch ($url->urlable_type) {
                case 'App\Model\Page':
                    return $this->simplePage($request,$url);
                    break;
                case 'App\Model\Category':
                    return $this->categoryPage($request,$url);
                    break;
                case 'App\Model\Product':
                    return $this->productPage($request,$url);
                    break;
                case 'App\Model\Pairing':
                    return $this->pairingPage($request,$url);
                    break;
                default:
                    return view('website.errors.404');
            }
        }
        else
        {
            return view('website.errors.404');
        }
    }

    protected function simplePage(Request $request,$url)
    {
        $page = Page::find($url->urlable_id);
        if(method_exists($this,$page->nome))
        {
            return $this->{$page->nome}($request,$url);
        }
        else
        {
            return view('website.errors.not_found_method',['method'=>$page->nome]);
        }
    }

    protected function categoryPage(Request $request,$url)
    {

    }

    protected function productPage(Request $request,$url)
    {

    }

    protected function pairingPage(Request $request,$url)
    {

    }

    protected function azienda(Request $request,$url)
    {
        $seo = $url->seo;
        $macrocategorie = Macrocategory::where('stato',1)->orderBy('order')->get();

        $params = [
            'seo' => $seo,
            'macrocategorie' => $macrocategorie,
            'macro_request' => null, //paramtero necessario per stabilire il collapse del menu a sinistra
        ];
        return view('website.page.azienda',$params);
    }

    protected function dove_siamo(Request $request,$url)
    {
        $seo = $url->seo;
        $macrocategorie = Macrocategory::where('stato',1)->orderBy('order')->get();

        $params = [
            'seo' => $seo,
            'macrocategorie' => $macrocategorie,
            'macro_request' => null, //paramtero necessario per stabilire il collapse del menu a sinistra
        ];
        return view('website.page.dove_siamo',$params);
    }

    protected function contatti(Request $request,$url)
    {
        $seo = $url->seo;
        $macrocategorie = Macrocategory::where('stato',1)->orderBy('order')->get();

        $params = [
            'seo' => $seo,
            'macrocategorie' => $macrocategorie,
            'form_action' => route('invia_formcontatti',app()->getLocale()),
            'form_name' => 'form_contatti',
            'macro_request' => null, //paramtero necessario per stabilire il collapse del menu a sinistra
        ];
        return view('website.page.contatti',$params);
    }
}
