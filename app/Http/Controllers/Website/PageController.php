<?php

namespace App\Http\Controllers\Website;

use App\Mail\OrderMail;
use App\Model\Cart;
use App\Model\Category;
use App\Model\DeliveryMin;
use App\Model\DeliveryMunic;
use App\Model\DeliveryShippingCost;
use App\Model\DeliveryString;
use App\Model\Domain;
use App\Model\File;
use App\Model\Ingredient;
use App\Model\Order;
use App\Model\OrderDetail;
use App\Model\OrderShipping;
use App\Model\Product;
use App\Model\Shop;
use App\Model\Variant;
use function GuzzleHttp\Psr7\str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Service\GoogleRecaptcha;
use Carbon\Carbon;
use Stripe\Stripe;
use Stripe\Charge;
use Twilio\Rest\Client;


class PageController extends Controller
{
    //stabilisce su quale negozio ci troviamo (in base al dominio)
    protected $shop;

    public function __construct()
    {
        $stripe_public = 'pk_test_DUbqvChAPFqXmiLRLWYIqp1000144RRWYs';
        $stripe_secret = 'sk_test_0ICo2W8wY3a41qkgTiKHGHY400MRCzLl32';
        $this->middleware(function($request, $next)
        {
            $domain = $request->getHttpHost();
            $domain = str_replace("www.","",$domain);
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

        $carts = Cart::where('shop_id',$this->shop->id)->where('session_id',\Session::getId())->get();

        $categories = Category::where('shop_id',$this->shop->id)->where('stato',1)->orderBy('order')->get();

        $first_cat = $categories->first();
        $products = Product::where('category_id',$first_cat->id)->where('visibile',1)->where('omaggio',0)->where('shop_id',$this->shop->id)->get();
        $ingredients = Ingredient::where('category_id',$first_cat->id)->where('shop_id',$this->shop->id)->where('visibile',1)->orderBy('nome_it')->get();
        $variants = Variant::where('category_id',$first_cat->id)->where('shop_id',$this->shop->id)->where('visibile',1)->orderBy('nome_it')->get();
        $prodotti_omaggio = Product::where('visibile',1)->where('omaggio',1)->where('shop_id',$this->shop->id)->get();
        $minimo_ordine = DeliveryMin::where('shop_id',$this->shop->id)->first();
        $spese_consegna = DeliveryShippingCost::where('shop_id',$this->shop->id)->first();

        $carbon = Carbon::now('Europe/Rome');
        $now = $carbon->toTimeString(); //l'ora di adesso in formato 00:00:00

        //trasformo tutti gli orari in timestamp per confrontarli
        $ora_di_adesso = strtotime($now);
        $prima_ora_del_giorno = strtotime($this->shop->deliveryHour->start_morning);
        $prima_ora_della_sera = strtotime($this->shop->deliveryHour->start_afternoon);
        $ultima_ora_del_giorno = strtotime($this->shop->deliveryHour->end_morning);
        $ultima_ora_della_sera = strtotime($this->shop->deliveryHour->end_afternoon);


        $possibile_ordinare_il_giorno = true;
        $possibile_ordinare_la_sera = true;

        //è troppo tardi non si può più ordinare il giorno
        if($ora_di_adesso >= $ultima_ora_del_giorno)
        {
            $possibile_ordinare_il_giorno = false;
        }

        //è troppo tardi non si può più ordinare (domani si può)
        if($ora_di_adesso >= $ultima_ora_della_sera)
        {
            $possibile_ordinare_la_sera = false;
        }

        //per il timepicker del giorno
        $orario_partenza_giorno = $this->shop->deliveryHour->start_morning;
        if($ora_di_adesso > $prima_ora_del_giorno)
        {
            $orario_partenza_giorno = $now;
        }

        //per il timepicker della sera
        $orario_partenza_sera = $this->shop->deliveryHour->start_afternoon;
        if($ora_di_adesso > $prima_ora_della_sera)
        {
            $orario_partenza_sera = $now;
        }

        $label_ingredienti = DeliveryString::where('shop_id',$this->shop->id)->where('for','ingredients')->first();
        $label_varianti = DeliveryString::where('shop_id',$this->shop->id)->where('for','variants')->first();
        $label_gratis = DeliveryString::where('shop_id',$this->shop->id)->where('for','gratis')->first();
        $label_omaggio = DeliveryString::where('shop_id',$this->shop->id)->where('for','omaggio')->first();


        $params = [
            'shop' => $this->shop,
            'carts' => $carts,
            'category_selected' => $first_cat,
            'categories' => $categories,
            'products' => $products,
            'prodotti_omaggio' => $prodotti_omaggio,
            'ingredients' => $ingredients,
            'variants' => $variants,
            'now' => $now,
            'possibile_ordinare_il_giorno' => $possibile_ordinare_il_giorno,
            'possibile_ordinare_la_sera' => $possibile_ordinare_la_sera,
            'aperto_il_giorno' => $this->aperto_il_giorno(),
            'aperto_la_sera' => $this->aperto_la_sera(),
            'orario_partenza_giorno' => $orario_partenza_giorno,
            'orario_partenza_sera' => $orario_partenza_sera,
            'label_ingredienti' => $label_ingredienti,
            'label_varianti' => $label_varianti,
            'label_gratis' => $label_gratis,
            'label_omaggio' => $label_omaggio,
            'minimo_ordine' => $minimo_ordine,
            'spese_consegna' => $spese_consegna,
        ];
        return view('website.page.index',$params);
    }

    public function category(Request $request, $id)
    {
        $category_id = decrypt($id);

        if(!$this->shop)
        {
            return view('website.page.dominio_sbagliato');
        }

        $carts = Cart::where('shop_id',$this->shop->id)->where('session_id',\Session::getId())->get();

        $categories = Category::where('shop_id',$this->shop->id)->where('stato',1)->orderBy('order')->get();
        $category = Category::find($category_id);

        $products = Product::where('category_id',$category->id)->where('visibile',1)->where('omaggio',0)->where('shop_id',$this->shop->id)->get();
        $ingredients = Ingredient::where('category_id',$category->id)->where('shop_id',$this->shop->id)->where('visibile',1)->orderBy('nome_it')->get();
        $variants = Variant::where('category_id',$category->id)->where('shop_id',$this->shop->id)->where('visibile',1)->orderBy('nome_it')->get();

        $label_ingredienti = DeliveryString::where('shop_id',$this->shop->id)->where('for','ingredients')->first();
        $label_varianti = DeliveryString::where('shop_id',$this->shop->id)->where('for','variants')->first();
        $label_gratis = DeliveryString::where('shop_id',$this->shop->id)->where('for','gratis')->first();
        $label_omaggio = DeliveryString::where('shop_id',$this->shop->id)->where('for','omaggio')->first();

        $params = [
            'shop' => $this->shop,
            'carts' => $carts,
            'categories' => $categories,
            'products' => $products,
            'category_selected' => $category,
            'ingredients' => $ingredients,
            'variants' => $variants,
            'label_ingredienti' => $label_ingredienti,
            'label_varianti' => $label_varianti,
            'label_gratis' => $label_gratis,
            'label_omaggio' => $label_omaggio,
        ];

        $html = \View::make('website.page.partials.product_list',$params);
        return ['result' => 1, 'msg' => '', 'html' => "$html"];
    }

    public function update_price(Request $request)
    {
        if(!$this->shop)
        {
            return ['result' => 0, 'msg' => 'Errore'];
        }

        $product_id = decrypt($request->input('product_id',null));
        $shop_id = decrypt($request->input('shop_id',null));


        if($product_id == null || $shop_id == null)
        {
            \Log::error('fallito update_price con product_id='.$product_id.' e shop_id='.$shop_id);
            return ['result' => 0, 'msg' => 'Errore'];
        }

        $shop = Shop::find($shop_id);
        if(!$shop)
        {
            \Log::error('fallito update_price  non trovato il negozio con id='.$shop_id);
            return ['result' => 0, 'msg' => 'Errore'];
        }

        $product = Product::find($product_id);
        if(!$product)
        {
            \Log::error('fallito update_price  non trovato il prodotto con id='.$shop_id);
            return ['result' => 0, 'msg' => 'Errore'];
        }

        $prezzo = $product->prezzo_vendita();

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
                $ingredienti_eliminati = "senza " . substr($ingredienti_eliminati, 0, strlen($ingredienti_eliminati) - 1);
            }
        }

        //controllo gli ingredienti aggiunti e modifico il prezzo
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
                $ingredienti_aggiunti = "con " . substr($ingredienti_aggiunti, 0, strlen($ingredienti_aggiunti) - 1);
            }
        }

        //controllo se c'è la variante e modifico il prezzo
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

        //ritorna un kson con diversi componenti html per aggiornare la vista
        return [
            'result'=> 1,
            'msg' => 'il prodotto '.$product->nome_it.' è stato aggiornato',
            'prezzo' => 'Prezzo: € ' . number_format($prezzo, 2,',','.'),
            'ingredienti_eliminati' => $ingredienti_eliminati,
            'ingredienti_aggiunti' => $ingredienti_aggiunti,
            'variante' => $variante,
        ];
    }

    public function remove_from_cart(Request $request, $id)
    {
        $cart_id = decrypt($id);
        $cart = Cart::find($cart_id);

        if(!$cart)
        {
            return ['result' => 0, 'msg' => 'Errore! Prodotto non trovato'];
        }

        $shop = Shop::find($cart->shop_id);
        if($shop->id != $this->shop->id)
        {
            \Log::error('fallito remove_from_cart:: lo shop id del carrello non corrisponde a quello del dominio' );
            return ['result' => 0, 'msg' => 'Errore! Prodotto non trovato'];
        }

        $cart->delete();

        $carts = Cart::where('shop_id',$this->shop->id)->where('session_id',\Session::getId())->get();
        $cart_html = \View::make('layouts.website_carrello',['carts' => $carts,'shop'=>$shop]);

        //se far fare il reload della pagina o meno

        return [
            'result' => 1,
            'reload' => 0,
            'msg' => 'Prodotto rimosso dal carrello',
            'cart' => "$cart_html",
            'cart_count' => $carts->sum('qta'),
        ];
    }

    public function add_to_cart(Request $request)
    {
        $product_id = decrypt($request->input('product_id',null));
        $shop_id = decrypt($request->input('shop_id',null));

        //\Log::debug('add_to_cart product_id='.$product_id.' shop_id='.$shop_id);

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


        //controllo che la quantità non superi il limite se c'è
        $carts = Cart::where('shop_id',$this->shop->id)->where('session_id',\Session::getId())->get();
        $max_qty = $this->shop->deliveryMaxQuantity;
        $qty_da_verificare = $carts->sum('qta') + $qty;
        if($max_qty && ($qty_da_verificare > $max_qty->qty))
        {
            return ['result' => 0, 'msg' => 'Non puoi ordinare più di '.$max_qty->qty.' prodotti'];
        }

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

        $carts = Cart::where('shop_id',$this->shop->id)->where('session_id',\Session::getId())->get();
        $cart_html = \View::make('layouts.website_carrello',['carts' => $carts,'shop'=>$shop]);

        return [
            'result' => 1,
            'msg' => '+ '.$qty.' '.$product->nome_it .' nel carrello',
            'cart' => "$cart_html",
            'cart_count' => $carts->sum('qta'),
            ];
    }

    public function cart_resume(Request $request)
    {
        //inserisco i dati nella sessione
        $request->flash();

        if(!$this->shop)
        {
            return view('website.page.dominio_sbagliato');
        }

        $data = $request->post();
        $config = \Config::get('website_config');
        $secret = $config['recaptcha_secret'];
        /*if(!GoogleRecaptcha::verifyGoogleRecaptcha($data,$secret))
        {
            return back()->with('error',trans('msg.il_codice_di_controllo_errato'));
        }*/

        $carts = Cart::where('shop_id',$this->shop->id)->where('session_id',\Session::getId())->get();
        if($carts->count() == 0)
        {
            return back()->with('error','Non hai nessun prodotto nel carrello');
        }

        $orario = $request->input('orario',null);

        if($orario == null)
        {
            return back()->with('error','Non hai specificato l\'orario di consegna/ritiro');
        }

        $orario_html = $orario;
        $orario = $orario.':00'; //aggiungo gli zeri dei secondi per inserirlo nel db

        //controllo il formato dell'orario
        $dateObj = \DateTime::createFromFormat('H:i:s', $orario);
        if(!$dateObj)
        {
            return back()->with('error','L\'orario specificato non è nel giusto formato');
        }

        //controllo che i prodotti siano disponibili per la cena o per il pranzo
        $ora_richiesta = strtotime($orario);
        $pomeriggio = strtotime('17:00:00');
        $tipo_ordinazione = ($ora_richiesta < $pomeriggio) ? 'pranzo' : 'cena';
        foreach ($carts as $cart)
        {
            $product = Product::find($cart->product_id);
            if($product->{$tipo_ordinazione} == 0)
            {
                return back()->with('error','Attenzione! Alcuni prodotti nel tuo carrello non sono disponibili per l\'orario richiesto. Es. '.$product->nome_it);
            }
        }

        //controllo che la quantità non superi il limite se c'è
        $max_qty = $this->shop->deliveryMaxQuantity;
        if($max_qty && ($carts->sum('qta') > $max_qty->qty))
        {
            return back()->with('error','Hai superato il limite di quantità. Per procedere con l\'ordinazione devi togliere alcuni prodotti');
        }

        //controllo il minimo di ordine
        $min_ordine = $this->shop->deliveryMin;
        if($min_ordine && ($carts->sum('totale') < $min_ordine->min ))
        {
            return back()->with('error','L\'ordine deve essere almeno di '.$min_ordine->min.' euro');
        }

        $carbon = Carbon::now('Europe/Rome');
        $now = $carbon->toTimeString(); //l'ora di adesso in formato 00:00:00
        //trasformo in timestamp per confrontarli
        $ora_di_adesso = strtotime($now);
        $ora_richiesta = strtotime($orario);
        $intervallo_min = (($this->shop->deliveryAvailableTime->time) ? $this->shop->deliveryAvailableTime->time : 0) * 60;

        //controllo che l'orario sia sempre valido
        if(($ora_di_adesso + $intervallo_min) > $ora_richiesta)
        {
            return back()->with('error','L\'orario indicato non è più disponible per effettuare l\'ordinazione');
        }

        $nome = $request->input('nome',null);
        $cognome = $request->input('cognome',null);
        $email = $request->input('email',null);
        $tel = $request->input('tel',null);

        if($nome == null || $cognome == null || $email == null || $tel == null)
        {
            return back()->with('error','Alcuni campi obbligatori non sono stati compilati');
        }

        $tipo_ordinazione = $request->input('tipo_ordinazione',null);
        $indirizzo = $request->input('indirizzo',null);
        $nr_civico = $request->input('nr_civico',null);
        $comune_id = $request->input('comune',null);
        $comune = false;

        if($tipo_ordinazione == 'domicilio')
        {
            if($indirizzo == null || $nr_civico == null || $comune_id == null)
            {
                return back()->with('error','Per la consegna a domicilio devi compilare tutti i campi per l\'indirizzo di consegna');
            }
            $comune = DeliveryMunic::find($comune_id);
        }

        $note = $request->input('note',null);
        $tipo_pagamento = $request->input('tipo_pagamento','payapal');
        $prodotto_omaggio = $request->input('prodotto_omaggio',null);

        //imposto le spese di consegna se ci sono
        $impostazioni_spese = DeliveryShippingCost::where('shop_id',$this->shop->id)->first();
        $spese_consegna = '';
        if($impostazioni_spese && $tipo_ordinazione == 'domicilio')
        {
            $totale_carrello = $carts->sum('totale');
            if($impostazioni_spese->to != '')
            {
                if($totale_carrello < $impostazioni_spese->to)
                {
                    $spese_consegna = $impostazioni_spese->cost;
                }
            }
            else
            {
                $spese_consegna = $impostazioni_spese->cost;
            }
        }

        $dati_ordinazione = [
            'nome' => $nome,
            'cognome' => $cognome,
            'email' => $email,
            'tel' => $tel,
            'tipo_ordinazione' => $tipo_ordinazione,
            'indirizzo' => $indirizzo,
            'nr_civico' => $nr_civico,
            'comune' => $comune,
            'note' => $note,
            'tipo_pagamento' => $tipo_pagamento,
            'prodotto_omaggio' => $prodotto_omaggio,
            'orario' => $orario,
            'orario_html' => $orario_html,
            'spese_consegna' => $spese_consegna,
        ];

        \Session::put('dati_ordinazione',$dati_ordinazione);

        return redirect()->route('website.cart_resume');

    }

    public function get_cart_resume(Request $request)
    {
        //inserisco i dati nella sessione
        $request->session()->reflash();

        if(!$this->shop)
        {
            return view('website.page.dominio_sbagliato');
        }

        $dati_ordinazione = \Session::get('dati_ordinazione',false);
        if(!$dati_ordinazione)
        {
            return redirect()->route('website.home');
        }

        $carts = Cart::where('shop_id',$this->shop->id)->where('session_id',\Session::getId())->get();

        //se c'è stripe
        $stripe = $this->shop->deliveryStripe;

        $prodotto_omaggio = ($dati_ordinazione['prodotto_omaggio'] != null) ? Product::find($dati_ordinazione['prodotto_omaggio']) : false;

        $params = [
            'shop' => $this->shop,
            'carts' => $carts,
            'nome' => $dati_ordinazione['nome'],
            'cognome' => $dati_ordinazione['cognome'],
            'email' => $dati_ordinazione['email'],
            'tel' => $dati_ordinazione['tel'],
            'tipo_ordinazione' => $dati_ordinazione['tipo_ordinazione'],
            'indirizzo' => $dati_ordinazione['indirizzo'],
            'nr_civico' => $dati_ordinazione['nr_civico'],
            'comune' => $dati_ordinazione['comune'],
            'note' => $dati_ordinazione['note'],
            'tipo_pagamento' => $dati_ordinazione['tipo_pagamento'],
            'orario' => $dati_ordinazione['orario'],
            'orario_html' => $dati_ordinazione['orario_html'],
            'spese_consegna' => $dati_ordinazione['spese_consegna'],
            'prodotto_omaggio' => $prodotto_omaggio,
            'stripe' => $stripe
        ];
        return view('website.page.cart_resume',$params);
    }

    public function checkout(Request $request)
    {
        if(!$this->shop)
        {
            return view('website.page.dominio_sbagliato');
        }

        //controllo che lo shop del form corrisponda a quello del dominio in cui ci troviamo
        if($this->shop->id != decrypt($request->input('shop_id')))
        {
            return back()->with('error','Errore grave!');
        }

        //tutti dati dell'ordinazione presenti nella sessione
        $dati_ordinazione = \Session::get('dati_ordinazione');

        //controllo che l'orario sia sempre valido
        if(!$this->check_orario_valido($dati_ordinazione['orario']))
        {
            return back()->with('error','L\'orario indicato non è più disponible per effettuare l\'ordinazione');
        }

        //prendo il carrello
        $carts = Cart::where('shop_id',$this->shop->id)->where('session_id',\Session::getId())->get();

        //verifico che il carrello non sia vuoto
        if($carts->count() == 0)
        {
            return back()->with('error','Non hai nessun prodotto nel carrello');
        }

        //inserisco l'ordine nel database
        $order = $this->add_ordine_to_db($dati_ordinazione,'alla_consegna', $carts);
        if(!$order)
        {
            return back()->with('error','Errore! Non è possibile procedere con l\'ordinazione');
        }

        //rimuovo gli articoli dal carrello
        foreach ($carts as $cart)
        {
            $cart->delete();
        }

        //invio l'email dell'ordine
        $this->send_order_email($order);

        //vado alla pagina esito ordine
        return redirect()->route('website.esito_ordinazione', ['id' => encrypt($order->id)]);

    }

    public function checkout_paypal(Request $request)
    {
        if(!$this->shop)
        {
            return view('website.page.dominio_sbagliato');
        }

        //controllo che lo shop del form corrisponda a quello del dominio in cui ci troviamo
        if($this->shop->id != decrypt($request->input('shop_id')))
        {
            return back()->with('error','Errore grave!');
        }

        //tutti dati dell'ordinazione presenti nella sessione
        $dati_ordinazione = \Session::get('dati_ordinazione');

        //controllo che l'orario sia sempre valido
        if(!$this->check_orario_valido($dati_ordinazione['orario']))
        {
            return back()->with('error','L\'orario indicato non è più disponible per effettuare l\'ordinazione');
        }

        //prendo il carrello
        $carts = Cart::where('shop_id',$this->shop->id)->where('session_id',\Session::getId())->get();

        //verifico che il carrello non sia vuoto
        if($carts->count() == 0)
        {
            return back()->with('error','Non hai nessun prodotto nel carrello');
        }

        //inserisco l'ordine nel database
        $order = $this->add_ordine_to_db($dati_ordinazione,'paypal', $carts);
        if(!$order)
        {
            return back()->with('error','Errore! Non è possibile procedere con l\'ordinazione');
        }

        //rimuovo gli articoli dal carrello
        foreach ($carts as $cart)
        {
            $cart->delete();
        }

        //creo l'array dei dati per la query string di paypal
        $data = [];
        $data['cmd']           = '_xclick';
        $data['no_note']       = 0;
        $data['lc']            = 'IT';
        $data['custom']        = $order->id;
        $data['business']      = $this->shop->deliveryPaypal->email;
        $data['item_name']     = "Ordine Numero " . $order->id;
        $data['amount']        = $order->importo;
        $data['rm']            = 2;
        $data['currency_code'] = 'EUR';
        $data['first_name']    = $order->nome;
        $data['last_name']     = $order->cognome;
        $data['payer_email']   = $order->email;
        $data['return']        = 'https://'.$this->shop->domain.'/esito_ordinazione/'.encrypt($order->id);
        $data['cancel_return'] = 'https://'.$this->shop->domain.'/paypal_error';
        $data['notify_url']    = 'https://'.$this->shop->domain.'/paypal_notify';//mettere questa url nelle eccezioni del middleware VerifyCsrfToken

        $queryString = http_build_query($data);

        if(\App::environment() == 'develop')
        {
            $url = 'https://sandbox.paypal.com/cgi-bin/webscr' . "?" . $queryString;
        }
        else
        {
            $url = 'https://www.paypal.com/cgi-bin/webscr' . "?" . $queryString;
        }

        //andiamo su paypal
        return redirect()->to($url);
    }

    public function checkout_stripe(Request $request,$id)
    {
        if(!$this->shop)
        {
            return view('website.page.dominio_sbagliato');
        }

        //controllo che lo shop del form corrisponda a quello del dominio in cui ci troviamo
        if($this->shop->id != decrypt($id))
        {
            return back()->with('error','Errore grave!');
        }

        //tutti dati dell'ordinazione presenti nella sessione
        $dati_ordinazione = \Session::get('dati_ordinazione');

        //controllo che l'orario sia sempre valido
        if(!$this->check_orario_valido($dati_ordinazione['orario']))
        {
            return back()->with('error','L\'orario indicato non è più disponible per effettuare l\'ordinazione');
        }

        //prendo il carrello
        $carts = Cart::where('shop_id',$this->shop->id)->where('session_id',\Session::getId())->get();

        //verifico che il carrello non sia vuoto
        if($carts->count() == 0)
        {
            return back()->with('error','Non hai nessun prodotto nel carrello');
        }

        //inserisco l'ordine nel database
        $order = $this->add_ordine_to_db($dati_ordinazione,'stripe', $carts);
        if(!$order)
        {
            return back()->with('error','Errore! Non è possibile procedere con l\'ordinazione');
        }

        //rimuovo gli articoli dal carrello
        foreach ($carts as $cart)
        {
            $cart->delete();
        }

        if(\App::environment() == 'develop')
        {
            $public_key = env('STRIPE_KEY');
        }
        else
        {
            $public_key = $this->shop->deliveryStripe->public_key;
        }


        $params = [
            'shop' => $this->shop,
            'order' => $order,
            'public_key' => $public_key
        ];

        //faccio vedere la pagina con il form per il pagamento con stripe
        return view('website.page.stripe',$params);
    }

    public function stripePost(Request $request)
    {
        $order_id = decrypt($request->input('order_id'));
        $order = Order::find($order_id);
        if(\App::environment() == 'develop')
        {
            Stripe::setApiKey(env('STRIPE_SECRET'));
        }
        else
        {
            Stripe::setApiKey($this->shop->deliveryStripe->secret_key);
        }

        $charge = Charge::create ([
            "amount" => $order->importo * 100,
            "currency" => "eur",
            "source" => $request->stripeToken,
            "description" => "Pagamento ordinazione ".$this->shop->insegna,
        ]);

        //se il pagamento è andato a buon fine
        if($charge->paid)
        {
            $id_transazione = $charge->id;

            //aggiorno l'ordine nel db con l'id transazione di stripe e stato pagamento a 1
            try{
                $order->stato_pagamento = 1;
                $order->idtranspag = $id_transazione;
                $order->save();
            }
            catch(\Exception $e){

                \Log::error('fallita notifica stripe impossibile aggiornare l\'ordine '.$e->getMessage() );
            }

            //invio l'email dell'ordine
            $this->send_order_email($order);

            \Log::debug('effettuato pagamento con stripe '.$charge->id );

            //vado alla pagina esito ordine
            return redirect()->route('website.esito_ordinazione', ['id' => encrypt($order->id)]);
        }
        else
        {
            \Log::error('fallito transazione con stripe '.$charge->failure_message );
            $params = [
                'shop' => $this->shop,
            ];
            return view('website.page.stripe_error',$params);
        }
    }

    public function paypal_notify(Request $request)
    {
        //verifico che la transazione sia andata a buon fine
        if($this->verifica_transazione())
        {
            $id_ordine = $request->post('custom');
            $id_transazione = $request->post('txn_id');

            //aggiorno l'ordine nel db con l'id di transazione paypal e stato pagamento su 1
            try{
                $order = Order::find($id_ordine);
                $order->stato_pagamento = 1;
                $order->idtranspag = $id_transazione;
                $order->save();
            }
            catch(\Exception $e){

                \Log::error('fallita notifica paypal impossibile aggiornare l\'ordine '.$e->getMessage() );
                return;
            }

            //invio l'email dell'ordine
            $this->send_order_email($order);
        }
        else
        {
            \Log::error('fallito verifica transazione paypal ' );
        }

        return;
    }

    public function paypal_error()
    {
        if(!$this->shop)
        {
            return view('website.page.dominio_sbagliato');
        }

        $params = [
            'shop' => $this->shop,
        ];

        return view('website.page.paypal_error',$params);
    }

    public function esito_ordinazione(Request $request,$id)
    {
        if(!$this->shop)
        {
            return view('website.page.dominio_sbagliato');
        }

        //\Log::debug('esito pagamento'.$this->shop->insegna);
        $order_id = decrypt($id);
        $order = Order::find($order_id);

        $params = [
            'shop' => $this->shop,
            'order' => $order,
        ];

        return view('website.page.esito_ordine',$params);
    }

    public function informativa()
    {
        if(!$this->shop)
        {
            return view('website.page.dominio_sbagliato');
        }
        $params = [
            'shop' => $this->shop
        ];

        return view('website.page.informativa',$params);
    }

    public function cookies_policy()
    {
        if(!$this->shop)
        {
            return view('website.page.dominio_sbagliato');
        }
        $params = [
            'shop' => $this->shop
        ];

        return view('website.page.cookies_policy',$params);
    }

    public function clear_cookies(Request $request)
    {
        $_POST = array_map("trim", $_POST); // se esternamente ad uno switch
        $expiration_date = time() + (10 * 365 * 24 * 60 * 60); // in 10 years => Faccio scadere il cookie in un futuro abbastanza lontano
        setcookie("c_acceptance", "yes", $expiration_date, "/");
    }

    protected function add_ordine_to_db($dati, $modalita_pagamento, $carts)
    {
        //omaggio può essere un oggetto Product oppure null
        $omaggio = ($dati['prodotto_omaggio'] != null) ? Product::find($dati['prodotto_omaggio']) : '';

        try{
            $order = New Order();
            $order->shop_id = $this->shop->id;
            $order->tipo = $dati['tipo_ordinazione'];
            if($dati['spese_consegna'] != '')
            {
                $order->spese_spedizione = $dati['spese_consegna'];
            }
            $order->orario = $dati['orario'];
            $order->nome = $dati['nome'];
            $order->cognome = $dati['cognome'];
            $order->email = $dati['email'];
            $order->telefono = $dati['tel'];
            $order->note = $dati['note'];
            if($omaggio != '')
            {
                $order->omaggio = $omaggio->nome_it;
            }
            $order->modalita_pagamento = $modalita_pagamento;
            if($dati['spese_consegna'] != '')
            {
                $order->importo = $carts->sum('totale') + $dati['spese_consegna'];
            }
            else
            {
                $order->importo = $carts->sum('totale');
            }

            $order->save();

            $order_id = $order->id;

            foreach ($carts as $cart)
            {
                $orderDetail = new OrderDetail();
                $orderDetail->order_id = $order_id;
                $orderDetail->shop_id = $this->shop->id;
                $orderDetail->product_id = $cart->product_id;
                $orderDetail->nome_prodotto = $cart->nome_prodotto;
                $orderDetail->variante = $cart->variante;
                $orderDetail->ingredienti_eliminati = $cart->ingredienti_eliminati;
                $orderDetail->ingredienti_aggiunti = $cart->ingredienti_aggiunti;
                $orderDetail->qta = $cart->qta;
                $orderDetail->prezzo = $cart->prezzo;
                $orderDetail->totale = $cart->totale;
                $orderDetail->save();
            }

            if($dati['tipo_ordinazione'] == 'domicilio')
            {
                $orderShipping = New OrderShipping();
                $orderShipping->order_id = $order_id;
                $orderShipping->shop_id = $this->shop->id;
                $orderShipping->comune = $dati['comune']->comune;
                $orderShipping->indirizzo = $dati['indirizzo'];
                $orderShipping->nr_civico = $dati['nr_civico'];
                $orderShipping->nome = $dati['nome'];
                $orderShipping->cognome = $dati['cognome'];
                $orderShipping->email = $dati['email'];
                $orderShipping->telefono = $dati['tel'];
                $orderShipping->save();
            }
        }
        catch(\Exception $e){

            \Log::error('fallito checkout  errore inserimento ordine '.$e->getMessage() );
            return false;
        }

        return $order;
    }

    protected function send_order_email($order)
    {
        $mail = New OrderMail($order,$this->shop);
        $to = $this->shop->email;

        try{
            \Mail::to($to)->cc($order->email)->send($mail);
            $this->send_whatsapp();
        }
        catch(\Exception $e)
        {
            \Log::error('fallito invio email ordine '.$e->getMessage() );
        }
        return true;
    }

    protected function check_orario_valido($orario)
    {
        $carbon = Carbon::now('Europe/Rome');
        $now = $carbon->toTimeString(); //l'ora di adesso in formato 00:00:00
        //trasformo in timestamp per confrontarli
        $ora_di_adesso = strtotime($now);
        $ora_richiesta = strtotime($orario);
        $intervallo_min = (($this->shop->deliveryAvailableTime->time) ? $this->shop->deliveryAvailableTime->time : 0) * 60;

        //controllo che l'orario sia sempre valido
        if(($ora_di_adesso + $intervallo_min) > $ora_richiesta)
        {
            return false;
        }

        return true;
    }

    protected function verifica_transazione()
    {
        $req = 'cmd=_notify-validate';
        foreach ($_POST as $key => $value)
        {
            $value = urlencode(stripslashes($value));
            $value = preg_replace('/(.*[^%^0^D])(%0A)(.*)/i', '${1}%0D%0A${3}', $value); // IPN fix
            $req .= "&$key=$value";
        }

        //ATTENZIONE la chiamata curl in sandbox non funziona in quanto da errore https, quindi in fase di sviluppo evitare la verifica curl
        if(\App::environment() == 'develop')
        {
            $url_paypal = 'https://sandbox.paypal.com/cgi-bin/webscr';
            return true;
        }
        else
        {
            $url_paypal = 'https://www.paypal.com/cgi-bin/webscr';
        }

        $ch = curl_init($url_paypal);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
        curl_setopt($ch, CURLOPT_SSLVERSION, 6);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: Close'));
        $res = curl_exec($ch);

        if (!$res)
        {
            $errstr = curl_error($ch);
            curl_close($ch);
            \Log::error('fallita verifica transazione paypal '.$errstr );
            return false;
        }

        $info = curl_getinfo($ch);

        // Check the http response
        $httpCode = $info['http_code'];
        if ($httpCode != 200)
        {
            \Log::error('fallita verifica transazione paypal PayPal responded with http cod '.$httpCode );
            return false;
        }

        curl_close($ch);

        return true;
    }

    protected function send_whatsapp()
    {
        if($this->shop->whatsapp != '')
        {
            $sid = $this->shop->twilio_id;
            $token = $this->shop->twilio_token;
            $client = new Client($sid, $token);

            try{
                $client->messages
                    ->create("whatsapp:+39".$this->shop->whatsapp, // to
                        [
                            "from" => "whatsapp:+14155238886",
                            "body" => "Attenzione! hai ricevuto un nuovo ordine."
                        ]
                    );
            }
            catch(\Exception $e){
                \Log::error('impossibile inviare ordine whatsapp');
            }
        }
    }

    public function send_sms(Request $request)
    {

    }

    protected function aperto_il_giorno()
    {
        //il numero del giorno (es.1 lunedì)
        $key = date('N');
        $oggi_in_italiano = [
            1 => 'lunedi',
            2 => 'martedi',
            3 => 'mercoledi',
            4 => 'giovedi',
            5 => 'venerdi',
            6 => 'sabato',
            7 => 'domenica'
        ];


        return $this->shop->deliveryOpenDay->{$oggi_in_italiano[$key].'_giorno'};
    }

    protected function aperto_la_sera()
    {
        //il numero del giorno (es.1 lunedì)
        $key = date('N');
        $oggi_in_italiano = [
            1 => 'lunedi',
            2 => 'martedi',
            3 => 'mercoledi',
            4 => 'giovedi',
            5 => 'venerdi',
            6 => 'sabato',
            7 => 'domenica'
        ];

        return $this->shop->deliveryOpenDay->{$oggi_in_italiano[$key].'_sera'};
    }





    public function send_telegram()
    {
        $token = "1240310975:AAFHV7YrZRkJWABiOHsqSG0YKSewpVOwN_Q";
        $chatid = "1071722501";
        $messaggio = 'nuovo ordine';
        $chat_id = 1071722501;
        // path to the picture,
        $text = 'nuovo ordine';
        // following ones are optional, so could be set as null
        $disable_web_page_preview = null;
        $reply_to_message_id = null;
        $reply_markup = null;

        $data = array(
            'chat_id' => urlencode($chat_id),
            'text' => urlencode($text),
            'disable_web_page_preview' => urlencode($disable_web_page_preview),
            'reply_to_message_id' => urlencode($reply_to_message_id),
            'reply_markup' => urlencode($reply_markup)
        );

        $url = 'https://api.telegram.org/bot1240310975:AAFHV7YrZRkJWABiOHsqSG0YKSewpVOwN_Q/sendMessage';

        //  open connection
        $ch = curl_init();
        //  set the url
        curl_setopt($ch, CURLOPT_URL, $url);
        //  number of POST vars
        curl_setopt($ch, CURLOPT_POST, count($data));
        //  POST data
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        //  To display result of curl
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //  execute post
        $result = curl_exec($ch);
        //  close connection
        curl_close($ch);
        print_r($result);
    }

}
