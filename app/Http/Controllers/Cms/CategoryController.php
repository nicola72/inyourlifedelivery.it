<?php

namespace App\Http\Controllers\Cms;

use App\Model\Category;
use App\Model\Domain;
use App\Model\File;
use App\Model\Macrocategory;
use App\Model\Pairing;
use App\Model\Product;
use App\Model\Shop;
use App\Model\Url;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;

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
                $categoria->{'desc_'.$lang} = $request->{'desc_'.$lang};
            }
            $categoria->save();
            $categoria_id = $categoria->id;

        }
        catch(\Exception $e){

            return ['result' => 0,'msg' => $e->getMessage()];
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
                return ['result' => 0,'msg' => $e->getMessage()];
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
        $categoria = Category::find($id);

        $langs = \Config::get('langs');

        try{

            foreach ($langs as $lang)
            {
                $categoria->{'nome_'.$lang} = $request->{'nome_'.$lang};
                $categoria->{'desc_'.$lang} = $request->{'desc_'.$lang};
            }
            $categoria->save();

        }
        catch(\Exception $e){

            return ['result' => 0,'msg' => $e->getMessage()];
        }

        $url = route('cms.categorie');
        return ['result' => 1,'msg' => 'Elemento aggiornato con successo!','url' => $url];
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

        $user_shop = Shop::find($user->shop_id);
        if($user_shop->id != $categoria->shop_id)
        {
            return back()->with('error','Non hai il permesso di eseguire questa operazione!');
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
