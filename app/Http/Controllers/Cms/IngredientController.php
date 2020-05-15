<?php

namespace App\Http\Controllers\Cms;

use App\Model\Category;
use App\Model\Domain;
use App\Model\Ingredient;
use App\Model\Macrocategory;
use App\Model\Module;
use App\Model\ModuleConfig;
use App\Model\Product;
use App\Model\Shop;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;


class IngredientController extends Controller
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
            $ingredients = Ingredient::all();
            $params = [
                'title_page' => 'Ingredienti',
                'ingredients' => $ingredients,
                'user' => $user
            ];
            return view('cms.ingredient.all_index',$params);
        }
        else
        {
            $shop = Shop::find($user->shop_id);
            $ingredients = Ingredient::where('shop_id',$shop->id)->get();
            $params = [
                'title_page' => 'Ingredienti '.$shop->insegna,
                'ingredients' => $ingredients,
                'user' => $user
            ];
        }

        return view('cms.ingredient.index',$params);
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
            return redirect('/cms/ingredient');
        }

        $shop = Shop::find($user->shop_id);
        if(!$shop)
        {
            return redirect('/cms/ingredient');
        }
        $categorie = Category::where('shop_id',$shop->id)->get();
        $params = [
            'form_name' => 'form_create_ingredient',
            'title_page'=> 'Nuovo Ingrediente',
            'shop' => $shop,
            'categorie' => $categorie,
        ];
        return view('cms.ingredient.create',$params);
    }


    public function store(Request $request)
    {
        $user = \Auth::user('cms');
        if($user->role_id == 1)
        {
            return redirect('/cms/ingredient');
        }

        $shop = Shop::find($user->shop_id);
        if($shop->id != $request->shop_id)
        {
            return redirect('/cms/ingredient');
        }

        try{
            $ingredient = new Ingredient();
            $ingredient->shop_id = $shop->id;
            $ingredient->category_id = $request->category_id;
            $ingredient->prezzo = str_replace(',','.',$request->prezzo);
            $ingredient->nome_it = $request->nome_it;

            $ingredient->save();

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


        $url = route('cms.ingredienti');
        return ['result' => 1,'msg' => 'Elemento creato con successo!','url' => $url];
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
            return redirect('/cms/ingredient');
        }

        $ingredient = Ingredient::find($id);

        $shop = Shop::find($user->shop_id);
        if($shop->id != $ingredient->shop_id)
        {
            return redirect('/cms/ingredient');
        }

        $categorie = Category::where('shop_id',$shop->id)->get();

        $params = [
            'title_page' => 'Modifica Ingrediente '.$ingredient->nome_it,
            'ingredient' => $ingredient,
            'categorie' => $categorie,
            'form_name' => 'form_edit_ingredient',
            'shop' => $shop,
        ];

        return view('cms.ingredient.edit',$params);
    }


    public function update(Request $request, $id)
    {
        $user = \Auth::user('cms');
        if($user->role_id == 1)
        {
            return redirect('/cms/ingredient');
        }


        $shop = Shop::find($user->shop_id);
        if($shop->id != $request->shop_id)
        {
            return redirect('/cms/ingredient');
        }

        $ingredient = Ingredient::find($id);
        if(!$ingredient)
        {
            return ['result' => 0,'msg' => 'Errore! Ingrediente non trovato'];
        }

        try{

            $ingredient->category_id = $request->category_id;
            $ingredient->shop_id = $shop->id;
            $ingredient->nome_it = $request->nome_it;
            $ingredient->prezzo = str_replace(',','.',$request->prezzo);
            $ingredient->save();

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

        $url = route('cms.ingredienti');
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
        $ingredient = Ingredient::find($id);
        if($ingredient->products->count() > 0)
        {
            return back()->with('errore','Errore! Questo ingrdiente non può essere cancellato perchè associato ad almeno un prodotto');
        }
        $ingredient->delete();

        return back()->with('success','Elemento cancellato!');
    }


    public function switch_visibility(Request $request)
    {
        $id = $request->id;
        $stato = $request->stato;

        try{
            $item = Ingredient::find($id);
            $item->visibile = $stato;
            $item->save();
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
        return ['result' => 1,'msg' => 'Elemento aggiornato con successo!'];

    }





}