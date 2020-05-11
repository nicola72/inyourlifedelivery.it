<?php
namespace App\Http\Controllers\Cms;

use App\Model\File;
use App\Model\Shop;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ConfigurationsController extends Controller
{
    public function index()
    {
        $user = \Auth::user('cms');

        if($user->role_id == 1)
        {
            $shops = Shop::all();
            $params = [
                'title_page' => 'Configurazioni negozio',
                'shops' => $shops
            ];

            return view('cms.configurations.shop_list',$params);
        }
        else
        {
            $shop = Shop::find($user->shop_id);
            $params = [
                'title_page' => 'Configurazioni negozio',
                'shop' => $shop
            ];

            return view('cms.configurations.index',$params);
        }


    }

    public function edit_logo(Request $request,$id)
    {
        $shop = Shop::find($id);

        $logo = File::where('fileable_id',$id)->where('fileable_type','App\Model\Shop')->first();

        $params = [
            'title_page' => 'Logo per '.$shop->ragione_sociale,
            'logo' => $logo,
            'shop' => $shop,
            'max_file_size' => '2',
            'extensions'=> '.png,.jpg,.jpeg,.JPG',

        ];
        return view('cms.product.images',$params);
    }
}