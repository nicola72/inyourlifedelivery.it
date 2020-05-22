<?php

namespace App\Http\Controllers\Cms;

use App\Model\Category;
use App\Model\Ingredient;
use App\Model\Module;
use App\Model\ModuleConfig;
use App\Model\Order;
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
}