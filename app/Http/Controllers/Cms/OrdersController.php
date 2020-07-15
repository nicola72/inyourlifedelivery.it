<?php

namespace App\Http\Controllers\Cms;

use App\Model\Category;
use App\Model\Ingredient;
use App\Model\Module;
use App\Model\ModuleConfig;
use App\Model\Order;
use App\Model\OrderDetail;
use App\Model\OrderShipping;
use App\Model\Product;
use App\Model\Shop;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class OrdersController extends Controller
{
    public function index()
    {
        $user = \Auth::user('cms');

        if($user->role_id == 1)
        {
            $orders = Order::all();
            $params = [
                'title_page' => 'Ordini',
                'orders' => $orders,
                'user' => $user
            ];

            return view('cms.orders.all_index',$params);
        }
        else
        {
            $shop = Shop::find($user->shop_id);
            $orders = Order::where('shop_id',$shop->id)->get();
            $params = [
                'title_page' => 'Ordini '.$shop->insegna,
                'orders' => $orders,
                'user' => $user
            ];
        }

        return view('cms.orders.index',$params);
    }

    public function order_details(Request $request, $id)
    {
        $user = \Auth::user('cms');
        if($user->role_id == 1)
        {
            return redirect('/cms/orders');
        }

        $shop = Shop::find($user->shop_id);
        if(!$shop)
        {
            return redirect('/cms/orders');
        }
        $order = Order::find($id);

        $params = [

            'shop' => $shop,
            'order' => $order,
        ];
        return view('cms.orders.order_details',$params);
    }

    public function order_print(Request $request, $id)
    {
        $user = \Auth::user('cms');
        if($user->role_id == 1)
        {
            return back()->with('error','Non hai il permesso di eseguire questa operazione!');
        }

        $shop = Shop::find($user->shop_id);
        if(!$shop)
        {
            return back()->with('error','Non hai il permesso di eseguire questa operazione!');
        }


        $order = Order::find($id);

        if($order->shop_id != $shop->id)
        {
            return back()->with('error','Non hai il permesso di eseguire questa operazione!');
        }

        $params = [

            'shop' => $shop,
            'order' => $order,
        ];
        return view('cms.orders.print',$params);
    }

    public function print_no_evasion()
    {
        $user = \Auth::user('cms');
        if($user->role_id == 1)
        {
            return back()->with('error','Non hai il permesso di eseguire questa operazione!');
        }

        $shop = Shop::find($user->shop_id);
        if(!$shop)
        {
            return back()->with('error','Non hai il permesso di eseguire questa operazione!');
        }

        $orders = Order::where('shop_id',$shop->id)->where('evaso',0)->get();

        $params = [

            'shop' => $shop,
            'orders' => $orders,
        ];
        return view('cms.orders.print_no_evasion',$params);
    }

    public function destroy(Request $request)
    {
        $user = \Auth::user('cms');
        if($user->role_id == 1)
        {
            return back()->with('error','Non hai il permesso di eseguire questa operazione 901!');
        }

        $shop = Shop::find($user->shop_id);
        if(!$shop)
        {
            return back()->with('error','Non hai il permesso di eseguire questa operazione 902!');
        }

        $order = Order::find($request->id);

        if($order->shop_id != $shop->id)
        {
            return back()->with('error','Non hai il permesso di eseguire questa operazione 903!');
        }

        //cancello i dettagli ordine
        $orderDetails = OrderDetail::where('order_id',$order->id)->where('shop_id',$shop->id)->get();
        foreach($orderDetails as $orderDetail)
        {
            $orderDetail->delete();
        }

        //cancello dati spedizione ordine
        $orderShipping = OrderShipping::where('order_id',$order->id)->where('shop_id',$shop->id)->first();
        if($orderShipping)
        {
            $orderShipping->delete();
        }

        //infine cancello l'ordine
        $order->delete();
        return back()->with('success','Elemento cancellato!');

    }

    public function switch_evaso(Request $request)
    {
        $id = $request->id;
        $stato = $request->stato;

        try{
            $item = Order::find($id);
            $item->evaso = $stato;
            $item->save();
        }
        catch(\Exception $e){

            return ['result' => 0,'msg' => $e->getMessage()];
        }
        return ['result' => 1,'msg' => 'Elemento aggiornato con successo!'];
    }
}
