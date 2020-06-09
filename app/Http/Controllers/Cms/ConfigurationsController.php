<?php
namespace App\Http\Controllers\Cms;

use App\Model\DeliveryAvailableTime;
use App\Model\DeliveryDescription;
use App\Model\DeliveryHour;
use App\Model\DeliveryMaxQuantity;
use App\Model\DeliveryMin;
use App\Model\DeliveryMunic;
use App\Model\DeliveryOpenDay;
use App\Model\DeliveryPaypal;
use App\Model\DeliveryShippingCost;
use App\Model\DeliveryStep;
use App\Model\DeliveryString;
use App\Model\File;
use App\Model\Shop;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;

class ConfigurationsController extends Controller
{
    public function index()
    {
        $user = \Auth::user('cms');

        if($user->role_id == 1)
        {
            $shops = Shop::all();
            $params = [
                'title_page' => 'Attività',
                'shops' => $shops
            ];

            return view('cms.configurations.shop_list',$params);
        }
        else
        {
            $shop = Shop::find($user->shop_id);
            $logo = File::where('fileable_id',$shop->id)->where('fileable_type','App\Model\Shop')->first();
            $comuni = DeliveryMunic::where('shop_id',$shop->id)->get();
            $hours = DeliveryHour::where('shop_id',$shop->id)->first();
            $step = DeliveryStep::where('shop_id',$shop->id)->first();
            $min = DeliveryMin::where('shop_id',$shop->id)->first();
            $ship_cost = DeliveryShippingCost::where('shop_id',$shop->id)->first();
            $opendays = DeliveryOpenDay::where('shop_id',$shop->id)->first();
            $availabletime = DeliveryAvailableTime::where('shop_id',$shop->id)->first();
            $description = DeliveryDescription::where('shop_id',$shop->id)->first();
            $maxqty = DeliveryMaxQuantity::where('shop_id',$shop->id)->first();
            $paypal = DeliveryPaypal::where('shop_id',$shop->id)->first();
            $label_for_ingredients = DeliveryString::where('shop_id',$shop->id)->where('for','ingredients')->first();
            $label_for_variants = DeliveryString::where('shop_id',$shop->id)->where('for','variants')->first();
            $label_for_gratis = DeliveryString::where('shop_id',$shop->id)->where('for','gratis')->first();
            $label_for_omaggio = DeliveryString::where('shop_id',$shop->id)->where('for','omaggio')->first();

            $params = [
                'title_page' => 'Configurazioni negozio',
                'logo' => $logo,
                'comuni' => $comuni,
                'hours' => $hours,
                'shop' => $shop,
                'step' => $step,
                'form_step' => 'form_step',
                'min' => $min,
                'form_minimo' => 'form_minimo',
                'ship_cost' => $ship_cost,
                'form_ship' => 'form_ship',
                'opendays' => $opendays,
                'availabletime' => $availabletime,
                'form_time' => 'form_time',
                'description' => $description,
                'form_description' => 'form_description',
                'maxqty' => $maxqty,
                'form_maxqty' => 'form_maxqty',
                'paypal'=> $paypal,
                'form_paypal' => 'form_paypal',
                'label_for_ingredients' => $label_for_ingredients,
                'label_for_variants' => $label_for_variants,
                'label_for_gratis' => $label_for_gratis,
                'label_for_omaggio' => $label_for_omaggio,
                'form_labels' => 'form_labels'
            ];

            return view('cms.configurations.index',$params);
        }
    }

    public function shop_config(Request $request,$id)
    {
        $user = \Auth::user('cms');
        if($user->role_id != 1)
        {
            return redirect('cms/configurations');
        }

        $shop = Shop::find($id);
        if(!$shop)
        {
            return back()->with('error','Errore! Negozio non trovato');
        }
        $logo = File::where('fileable_id',$shop->id)->where('fileable_type','App\Model\Shop')->first();
        $comuni = DeliveryMunic::where('shop_id',$shop->id)->get();
        $hours = DeliveryHour::where('shop_id',$shop->id)->first();
        $step = DeliveryStep::where('shop_id',$shop->id)->first();
        $min = DeliveryMin::where('shop_id',$shop->id)->first();
        $ship_cost = DeliveryShippingCost::where('shop_id',$shop->id)->first();
        $opendays = DeliveryOpenDay::where('shop_id',$shop->id)->first();
        $availabletime = DeliveryAvailableTime::where('shop_id',$shop->id)->first();
        $description = DeliveryDescription::where('shop_id',$shop->id)->first();
        $maxqty = DeliveryMaxQuantity::where('shop_id',$shop->id)->first();
        $paypal = DeliveryPaypal::where('shop_id',$shop->id)->first();
        $label_for_ingredients = DeliveryString::where('shop_id',$shop->id)->where('for','ingredients')->first();
        $label_for_variants = DeliveryString::where('shop_id',$shop->id)->where('for','variants')->first();
        $label_for_gratis = DeliveryString::where('shop_id',$shop->id)->where('for','gratis')->first();
        $label_for_omaggio = DeliveryString::where('shop_id',$shop->id)->where('for','omaggio')->first();

        $params = [
            'title_page' => 'Configurazioni '.$shop->insegna,
            'logo' => $logo,
            'comuni' => $comuni,
            'hours' => $hours,
            'shop' => $shop,
            'step' => $step,
            'form_step' => 'form_step',
            'min' => $min,
            'form_minimo' => 'form_minimo',
            'ship_cost' => $ship_cost,
            'form_ship' => 'form_ship',
            'opendays' => $opendays,
            'availabletime' => $availabletime,
            'form_time' => 'form_time',
            'description' => $description,
            'form_description' => 'form_description',
            'maxqty' => $maxqty,
            'form_maxqty' => 'form_maxqty',
            'paypal'=> $paypal,
            'form_paypal' => 'form_paypal',
            'label_for_ingredients' => $label_for_ingredients,
            'label_for_variants' => $label_for_variants,
            'label_for_gratis' => $label_for_gratis,
            'label_for_omaggio' => $label_for_omaggio,
            'form_labels' => 'form_labels'
        ];

        return view('cms.configurations.index',$params);

    }

    public function update_time(Request $request,$id)
    {
        $shop = Shop::find($id);


        //controllo che l'utente editore non configuri il negozio di un altro
        $user = \Auth::user('cms');
        if($user->role_id != 1)
        {
            $shop_user = Shop::find($user->shop_id);
            if($shop_user->id != $shop->id)
            {
                return redirect('/cms');
            }
        }

        $old_times = DeliveryAvailableTime::where('shop_id',$shop->id)->get();

        if($old_times->count() > 0)
        {
            foreach ($old_times as $item)
            {
                $item->delete();
            }
        }

        $time = $request->availabletime;

        //faccio l'inserimento
        try{
            $delivery_time = New DeliveryAvailableTime();
            $delivery_time->shop_id = $shop->id;
            $delivery_time->time = $time;
            $delivery_time->save();
        }
        catch(\Exception $e)
        {
            return ['result' => 0,'msg' => $e->getMessage()];
        }

        if($user->role_id != 1)
        {
            $url = url('cms/configurations');
        }
        else
        {
            $url = url('cms/configurations/shop_config',$shop->id);
        }
        return ['result' => 1,'msg' => 'Tempo richiesto aggiornato con successo!','url'=> $url];

    }

    public function update_maxqty(Request $request,$id)
    {
        $shop = Shop::find($id);

        //controllo che l'utente editore non configuri il negozio di un altro
        $user = \Auth::user('cms');
        if($user->role_id != 1)
        {
            $shop_user = Shop::find($user->shop_id);
            if($shop_user->id != $shop->id)
            {
                return redirect('/cms');
            }
        }

        $old_qty = DeliveryMaxQuantity::where('shop_id',$shop->id)->get();

        if($old_qty->count() > 0)
        {
            foreach ($old_qty as $item)
            {
                $item->delete();
            }
        }

        $max_qty = $request->max_qty;

        //faccio l'inserimento
        try{
            $delivery_max_qty = New DeliveryMaxQuantity();
            $delivery_max_qty->shop_id = $shop->id;
            $delivery_max_qty->qty = $max_qty;
            $delivery_max_qty->save();
        }
        catch(\Exception $e)
        {
            return ['result' => 0,'msg' => $e->getMessage()];
        }

        if($user->role_id != 1)
        {
            $url = url('cms/configurations');
        }
        else
        {
            $url = url('cms/configurations/shop_config',$shop->id);
        }
        return ['result' => 1,'msg' => 'Max quantità ordinabile aggiornata con successo!','url'=> $url];

    }

    public function update_labels(Request $request,$id)
    {
        $shop = Shop::find($id);

        //controllo che l'utente editore non configuri il negozio di un altro
        $user = \Auth::user('cms');
        if($user->role_id != 1)
        {
            $shop_user = Shop::find($user->shop_id);
            if($shop_user->id != $shop->id)
            {
                return redirect('/cms');
            }
        }

        $old_labels = DeliveryString::where('shop_id',$shop->id)->get();

        if($old_labels)
        {
            foreach ($old_labels as $item)
            {
                $item->delete();
            }
        }

        $label_for_ingredients = $request->label_for_ingredients;
        $label_for_variants = $request->label_for_variants;
        $label_for_gratis = $request->label_for_gratis;
        $label_for_omaggio = $request->label_for_omaggio;

        //faccio l'inserimento di ogni label
        try{
            $label = New DeliveryString();
            $label->shop_id = $shop->id;
            $label->for = 'ingredients';
            $label->text = $label_for_ingredients;
            $label->save();
        }
        catch(\Exception $e)
        {
            return ['result' => 0,'msg' => $e->getMessage()];
        }

        try{
            $label = New DeliveryString();
            $label->shop_id = $shop->id;
            $label->for = 'variants';
            $label->text = $label_for_variants;
            $label->save();
        }
        catch(\Exception $e)
        {
            return ['result' => 0,'msg' => $e->getMessage()];
        }

        try{
            $label = New DeliveryString();
            $label->shop_id = $shop->id;
            $label->for = 'gratis';
            $label->text = $label_for_gratis;
            $label->save();
        }
        catch(\Exception $e)
        {
            return ['result' => 0,'msg' => $e->getMessage()];
        }

        try{
            $label = New DeliveryString();
            $label->shop_id = $shop->id;
            $label->for = 'omaggio';
            $label->text = $label_for_omaggio;
            $label->save();
        }
        catch(\Exception $e)
        {
            return ['result' => 0,'msg' => $e->getMessage()];
        }

        if($user->role_id != 1)
        {
            $url = url('cms/configurations');
        }
        else
        {
            $url = url('cms/configurations/shop_config',$shop->id);
        }
        return ['result' => 1,'msg' => 'Labels aggiornate con successo!','url'=> $url];

    }

    public function update_desc(Request $request,$id)
    {
        $shop = Shop::find($id);

        //controllo che l'utente editore non configuri il negozio di un altro
        $user = \Auth::user('cms');
        if($user->role_id != 1)
        {
            $shop_user = Shop::find($user->shop_id);
            if($shop_user->id != $shop->id)
            {
                return redirect('/cms');
            }
        }

        $old_desc = DeliveryDescription::where('shop_id',$shop->id)->get();

        if($old_desc->count() > 0)
        {
            foreach ($old_desc as $item)
            {
                $item->delete();
            }
        }

        $desc = $request->delivery_desc;

        //faccio l'inserimento
        try{
            $delivery_desc = New DeliveryDescription();
            $delivery_desc->shop_id = $shop->id;
            $delivery_desc->desc = $desc;
            $delivery_desc->save();
        }
        catch(\Exception $e)
        {
            return ['result' => 0,'msg' => $e->getMessage()];
        }

        if($user->role_id != 1)
        {
            $url = url('cms/configurations');
        }
        else
        {
            $url = url('cms/configurations/shop_config',$shop->id);
        }
        return ['result' => 1,'msg' => 'Descrizione aggiornata con successo!','url'=> $url];

    }

    public function update_paypal(Request $request,$id)
    {
        $shop = Shop::find($id);

        //controllo che l'utente editore non configuri il negozio di un altro
        $user = \Auth::user('cms');
        if($user->role_id != 1)
        {
            $shop_user = Shop::find($user->shop_id);
            if($shop_user->id != $shop->id)
            {
                return redirect('/cms');
            }
        }

        $olds = DeliveryPaypal::where('shop_id',$shop->id)->get();

        if($olds->count() > 0)
        {
            foreach ($olds as $item)
            {
                $item->delete();
            }
        }

        $email = $request->email_paypal;

        //faccio l'inserimento
        try{
            $delivery_paypal = New DeliveryPaypal();
            $delivery_paypal->shop_id = $shop->id;
            $delivery_paypal->email = $email;
            $delivery_paypal->save();
        }
        catch(\Exception $e)
        {
            return ['result' => 0,'msg' => $e->getMessage()];
        }

        if($user->role_id != 1)
        {
            $url = url('cms/configurations');
        }
        else
        {
            $url = url('cms/configurations/shop_config',$shop->id);
        }
        return ['result' => 1,'msg' => 'Email paypal aggiornata con successo!','url'=> $url];
    }

    public function edit_open_days(Request $request,$id)
    {
        $shop = Shop::find($id);

        //controllo che l'utente editore non configuri il negozio di un altro
        $user = \Auth::user('cms');
        if($user->role_id != 1)
        {
            $shop_user = Shop::find($user->shop_id);
            if($shop_user->id != $shop->id)
            {
                return redirect('/cms');
            }
        }

        $old_days = DeliveryOpenDay::where('shop_id',$shop->id)->first();

        $params = [
            'title_page' => 'Configura i Giorni in cui il servizio è attivo',
            'old_days' => $old_days,
            'shop' => $shop,
            'form_name' => 'form_edit_open_days',
        ];

        return view('cms.configurations.edit_open_days',$params);
    }

    public function update_open_days(Request $request,$id)
    {
        $shop = Shop::find($id);

        //controllo che l'utente editore non configuri il negozio di un altro
        $user = \Auth::user('cms');
        if($user->role_id != 1)
        {
            $shop_user = Shop::find($user->shop_id);
            if($shop_user->id != $shop->id)
            {
                return redirect('/cms');
            }
        }

        $old_days = DeliveryOpenDay::where('shop_id',$shop->id)->get();

        if($old_days->count() > 0)
        {
            foreach ($old_days as $item)
            {
                $item->delete();
            }
        }

        //faccio l'inserimento
        try{
            $delivery_days = New DeliveryOpenDay();
            $delivery_days->shop_id = $shop->id;
            $delivery_days->lunedi_giorno = $request->lunedi_giorno;
            $delivery_days->lunedi_sera = $request->lunedi_sera;
            $delivery_days->martedi_giorno = $request->martedi_giorno;
            $delivery_days->martedi_sera = $request->martedi_sera;
            $delivery_days->mercoledi_giorno = $request->mercoledi_giorno;
            $delivery_days->mercoledi_sera = $request->mercoledi_sera;
            $delivery_days->giovedi_giorno = $request->giovedi_giorno;
            $delivery_days->giovedi_sera = $request->giovedi_sera;
            $delivery_days->venerdi_giorno = $request->venerdi_giorno;
            $delivery_days->venerdi_sera = $request->venerdi_sera;
            $delivery_days->sabato_giorno = $request->sabato_giorno;
            $delivery_days->sabato_sera = $request->sabato_sera;
            $delivery_days->domenica_giorno = $request->domenica_giorno;
            $delivery_days->domenica_sera = $request->domenica_sera;
            $delivery_days->save();
        }
        catch(\Exception $e)
        {
            return ['result' => 0,'msg' => $e->getMessage()];
        }

        if($user->role_id != 1)
        {
            $url = url('cms/configurations');
        }
        else
        {
            $url = url('cms/configurations/shop_config',$shop->id);
        }
        return ['result' => 1,'msg' => 'Giorni apertura chiusura aggiornati con successo!','url'=> $url];
    }

    public function update_shipping_cost(Request $request,$id)
    {
        $shop = Shop::find($id);

        //controllo che l'utente editore non configuri il negozio di un altro
        $user = \Auth::user('cms');
        if($user->role_id != 1)
        {
            $shop_user = Shop::find($user->shop_id);
            if($shop_user->id != $shop->id)
            {
                return redirect('/cms');
            }
        }

        $cost = trim(str_replace(",",".",$request->input('delivery_ship_cost',null)));
        $to = trim(str_replace(",",".",$request->input('delivery_ship_to',null)));

        if($cost == null)
        {
            return ['result' => 0,'msg' => 'valore non valido'];
        }

        if(!is_float($cost) && !is_numeric($cost))
        {
            return ['result' => 0,'msg' => 'valore formato non valido'];
        }

        if($to == '')
        {
            $to = null;
        }
        if($to != null && !is_float($to) && !is_numeric($to))
        {
            return ['result' => 0,'msg' => 'valore -fino a- formato non valido'];
        }

        $old_costs = DeliveryShippingCost::where('shop_id',$shop->id)->get();

        if($old_costs->count() > 0)
        {
            foreach ($old_costs as $item)
            {
                $item->delete();
            }
        }

        //faccio l'inserimento
        try{
            $delivery_cost = New DeliveryShippingCost();
            $delivery_cost->shop_id = $shop->id;
            $delivery_cost->cost = $cost;
            $delivery_cost->to = $to;
            $delivery_cost->save();
        }
        catch(\Exception $e)
        {
            return ['result' => 0,'msg' => $e->getMessage()];
        }

        if($user->role_id != 1)
        {
            $url = url('cms/configurations');
        }
        else
        {
            $url = url('cms/configurations/shop_config',$shop->id);
        }
        return ['result' => 1,'msg' => 'Costi spedizione aggiornati con successo!','url'=> $url];
    }

    public function update_min(Request $request,$id)
    {
        $shop = Shop::find($id);

        //controllo che l'utente editore non configuri il negozio di un altro
        $user = \Auth::user('cms');
        if($user->role_id != 1)
        {
            $shop_user = Shop::find($user->shop_id);
            if($shop_user->id != $shop->id)
            {
                return redirect('/cms');
            }
        }

        $min = trim(str_replace(",",".",$request->input('delivery_min',null)));

        if($min == null)
        {
            return ['result' => 0,'msg' => 'valore non valido'];
        }

        if(!is_float($min) && !is_numeric($min))
        {
            return ['result' => 0,'msg' => 'valore formato non valido'];
        }

        $old_mins = DeliveryMin::where('shop_id',$shop->id)->get();

        if($old_mins->count() > 0)
        {
            foreach ($old_mins as $item)
            {
                $item->delete();
            }
        }

        //faccio l'inserimento
        try{
            $delivery_min = New DeliveryMin();
            $delivery_min->shop_id = $shop->id;
            $delivery_min->min = $min;
            $delivery_min->save();
        }
        catch(\Exception $e)
        {
            return ['result' => 0,'msg' => $e->getMessage()];
        }

        if($user->role_id != 1)
        {
            $url = url('cms/configurations');
        }
        else
        {
            $url = url('cms/configurations/shop_config',$shop->id);
        }
        return ['result' => 1,'msg' => 'Step aggiornato con successo!','url'=> $url];
    }

    public function update_step(Request $request,$id)
    {
        $shop = Shop::find($id);

        //controllo che l'utente editore non configuri il negozio di un altro
        $user = \Auth::user('cms');
        if($user->role_id != 1)
        {
            $shop_user = Shop::find($user->shop_id);
            if($shop_user->id != $shop->id)
            {
                return redirect('/cms');
            }
        }

        $old_steps = DeliveryStep::where('shop_id',$shop->id)->get();

        if($old_steps->count() > 0)
        {
            foreach ($old_steps as $item)
            {
                $item->delete();
            }
        }

        $step = $request->delivery_step;

        //faccio l'inserimento
        try{
            $delivery_step = New DeliveryStep();
            $delivery_step->shop_id = $shop->id;
            $delivery_step->step = $step;
            $delivery_step->save();
        }
        catch(\Exception $e)
        {
            return ['result' => 0,'msg' => $e->getMessage()];
        }

        if($user->role_id != 1)
        {
            $url = url('cms/configurations');
        }
        else
        {
            $url = url('cms/configurations/shop_config',$shop->id);
        }
        return ['result' => 1,'msg' => 'Step aggiornato con successo!','url'=> $url];

    }

    public function edit_hours(Request $request,$id)
    {
        $shop = Shop::find($id);

        //controllo che l'utente editore non configuri il negozio di un altro
        $user = \Auth::user('cms');
        if($user->role_id != 1)
        {
            $shop_user = Shop::find($user->shop_id);
            if($shop_user->id != $shop->id)
            {
                return redirect('/cms');
            }
        }

        $old_hours = DeliveryHour::where('shop_id',$shop->id)->first();

        $params = [
            'title_page' => 'Configura gli intervalli orario si effettuano le consegne',
            'old_hours' => $old_hours,
            'shop' => $shop,
            'form_name' => 'form_edit_hours',
        ];

        return view('cms.configurations.edit_hours',$params);

    }

    public function update_hours(Request $request,$id)
    {
        $shop = Shop::find($id);

        //controllo che l'utente editore non configuri il negozio di un altro
        $user = \Auth::user('cms');
        if($user->role_id != 1)
        {
            $shop_user = Shop::find($user->shop_id);
            if($shop_user->id != $shop->id)
            {
                return redirect('/cms');
            }
        }

        $start_morning = $request->start_morning;
        $end_morning = $request->end_morning;
        $start_afternoon = $request->start_afternoon;
        $end_afternoon = $request->end_afternoon;

        $sm_arr = explode(':',$start_morning);
        $em_arr = explode(':',$end_morning);
        $sa_arr = explode(':',$start_afternoon);
        $ea_arr = explode(':',$end_afternoon);
        $carbon1 = Carbon::createFromTime($sm_arr[0],$sm_arr[1],$sm_arr[2]);
        $carbon2 = Carbon::createFromTime($em_arr[0],$em_arr[1],$em_arr[2]);
        $carbon3 = Carbon::createFromTime($sa_arr[0],$sa_arr[1],$sa_arr[2]);
        $carbon4 = Carbon::createFromTime($ea_arr[0],$ea_arr[1],$ea_arr[2]);

        if($carbon1->greaterThan($carbon2))
        {
            return ['result' => 0,'msg' => 'Errore! date incongruenti'];
        }

        if($carbon3->greaterThan($carbon4))
        {
            return ['result' => 0,'msg' => 'Errore! date incongruenti'];
        }


        //prima di tutti elimino eventuale orari vecchi impostati
        $old_hours = DeliveryHour::where('shop_id',$shop->id)->get();
        if($old_hours->count() > 0)
        {
            foreach ($old_hours as $item)
            {
                $item->delete();
            }
        }

        //faccio l'inserimento
        try{
            $delivery_hours = New DeliveryHour();
            $delivery_hours->shop_id = $shop->id;
            $delivery_hours->start_morning = $start_morning;
            $delivery_hours->end_morning = $end_morning;
            $delivery_hours->start_afternoon = $start_afternoon;
            $delivery_hours->end_afternoon = $end_afternoon;
            $delivery_hours->save();
        }
        catch(\Exception $e)
        {
            return ['result' => 0,'msg' => $e->getMessage()];
        }

        if($user->role_id != 1)
        {
            $url = url('cms/configurations');
        }
        else
        {
            $url = url('cms/configurations/shop_config',$shop->id);
        }
        return ['result' => 1,'msg' => 'Orari aggiornati con successo!','url'=> $url];
    }

    public function edit_comuni(Request $request,$id)
    {
        $shop = Shop::find($id);

        //controllo che l'utente editore non configuri il negozio di un altro
        $user = \Auth::user('cms');
        if($user->role_id != 1)
        {
            $shop_user = Shop::find($user->shop_id);
            if($shop_user->id != $shop->id)
            {
                return redirect('/cms');
            }
        }

        $old_comuni = DeliveryMunic::where('shop_id',$shop->id)->get();
        $selected = [];
        if($old_comuni->count() > 0)
        {
            foreach($old_comuni as $item)
            {
                $selected[] = $item->comune;
            }

        }

        $url = $_SERVER['DOCUMENT_ROOT'].'/json/italy_munic.json';
        $datos = file_get_contents($url);
        $data = json_decode($datos, true);
        $comuni = collect($data)->where('regione','Toscana')->sortBy('comune')->all();

        $params = [
            'title_page' => 'Configura i Comuni per la consegna a domicilio',
            'selected' => $selected,
            'comuni' => $comuni,
            'shop' => $shop,
            'user' => $user,
            'form_name' => 'form_edit_comuni',
        ];

        return view('cms.configurations.edit_comuni',$params);
    }

    public function update_comuni(Request $request,$id)
    {
        $shop = Shop::find($id);

        //controllo che l'utente editore non configuri il negozio di un altro
        $user = \Auth::user('cms');
        if($user->role_id != 1)
        {
            $shop_user = Shop::find($user->shop_id);
            if($shop_user->id != $shop->id)
            {
                return redirect('/cms');
            }
        }

        $comuni = $request->comuni;

        //prima di tutti elimino eventuali comuni vecchi impostati
        $old_comuni = DeliveryMunic::where('shop_id',$shop->id)->get();
        if($old_comuni->count() > 0)
        {
            foreach ($old_comuni as $item)
            {
                $item->delete();
            }
        }

        //faccio l'inserimento
        foreach($comuni as $comune)
        {
            try{
                $delivery_munic = New DeliveryMunic();
                $delivery_munic->shop_id = $shop->id;
                $delivery_munic->comune = $comune;
                $delivery_munic->save();
            }
            catch(\Exception $e)
            {
                return ['result' => 0,'msg' => $e->getMessage()];
            }

        }

        if($user->role_id != 1)
        {
            $url = url('cms/configurations');
        }
        else
        {
            $url = url('cms/configurations/shop_config',$shop->id);
        }
        return ['result' => 1,'msg' => 'Comuni aggiornati con successo!','url'=> $url];
    }

    public function edit_logo(Request $request,$id)
    {
        $shop = Shop::find($id);

        //controllo che l'utente editore non configuri il negozio di un altro
        $user = \Auth::user('cms');
        if($user->role_id != 1)
        {
            $shop_user = Shop::find($user->shop_id);
            if($shop_user->id != $shop->id)
            {
                return redirect('/cms');
            }
        }

        $logo = File::where('fileable_id',$id)->where('fileable_type','App\Model\Shop')->first();

        $params = [
            'title_page' => 'Logo per '.$shop->ragione_sociale,
            'user' => $user,
            'logo' => $logo,
            'shop' => $shop,
            'max_file_size' => '2',
            'extensions'=> '.png,.jpg,.jpeg,.JPG',
            'file_restanti' => 1,
            'limit_max_file' => false,
            'logo' => $logo

        ];
        return view('cms.configurations.logo',$params);
    }

    public function upload_logo(Request $request)
    {
        $fileable_id = $request->fileable_id;
        $fileable_type = 'App\Model\Shop';

        //prima di tutto cancello il vecchi logo se c'è
        $vecchi = File::where('fileable_id',$fileable_id)->where('fileable_type','App\Model\Shop')->get();
        if($vecchi->count() > 0)
        {
            foreach($vecchi as $item)
            {
                $item->delete();
            }
        }

        $uploadedFile = $request->file('file');
        $filename = time().$uploadedFile->getClientOriginalName();

        try{
            \Storage::disk('file')->putFileAs('', $uploadedFile, $filename);
        }
        catch(\Exception $e){

            return ['result' => 0,'msg' => $e->getMessage()];
        }

        $resizes = [400,800];

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

        $url = url('cms/configurations/edit_logo',$fileable_id);
        return ['result' => 1,'msg' => 'File caricato con successo!','url' => $url];
    }
}