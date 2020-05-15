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
use App\Model\Variant;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;


class VariantController extends Controller
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
            $variants = Variant::all();
            $params = [
                'title_page' => 'Varianti',
                'variants' => $variants,
                'user' => $user
            ];

            return view('cms.variant.all_index',$params);
        }
        else
        {
            $shop = Shop::find($user->shop_id);
            $variants = Variant::where('shop_id',$shop->id)->get();
            $params = [
                'title_page' => 'Varianti '.$shop->insegna,
                'variants' => $variants,
                'user' => $user
            ];
        }

        return view('cms.variant.index',$params);
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
            return redirect('/cms/variant');
        }

        $shop = Shop::find($user->shop_id);
        if(!$shop)
        {
            return redirect('/cms/variant');
        }
        $categorie = Category::where('shop_id',$shop->id)->get();
        $params = [
            'form_name' => 'form_create_variant',
            'title_page'=> 'Nuovo Variante',
            'shop' => $shop,
            'categorie' => $categorie,
        ];
        return view('cms.variant.create',$params);
    }


    public function store(Request $request)
    {
        $user = \Auth::user('cms');
        if($user->role_id == 1)
        {
            return redirect('/cms/variant');
        }

        $shop = Shop::find($user->shop_id);
        if($shop->id != $request->shop_id)
        {
            return redirect('/cms/variant');
        }

        try{
            $variant = new Variant();
            $variant->shop_id = $shop->id;
            $variant->category_id = $request->category_id;
            $variant->type = $request->type;
            $variant->prezzo = str_replace(',','.',$request->prezzo);
            $variant->nome_it = $request->nome_it;

            $variant->save();

        }
        catch(\Exception $e){

            return ['result' => 0,'msg' => $e->getMessage()];
        }


        $url = route('cms.varianti');
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
            return redirect('/cms/variant');
        }

        $variant = Variant::find($id);

        $shop = Shop::find($user->shop_id);
        if($shop->id != $variant->shop_id)
        {
            return redirect('/cms/variant');
        }

        $categorie = Category::where('shop_id',$shop->id)->get();

        $params = [
            'title_page' => 'Modifica Variante '.$variant->nome_it,
            'variant' => $variant,
            'categorie' => $categorie,
            'form_name' => 'form_edit_variant',
            'shop' => $shop,
        ];

        return view('cms.variant.edit',$params);
    }


    public function update(Request $request, $id)
    {
        $user = \Auth::user('cms');
        if($user->role_id == 1)
        {
            return redirect('/cms/variant');
        }

        $shop = Shop::find($user->shop_id);
        if($shop->id != $request->shop_id)
        {
            return redirect('/cms/variant');
        }
        $variant = Variant::find($id);

        try{

            $variant->category_id = $request->category_id;
            $variant->shop_id = $shop->id;
            $variant->nome_it = $request->nome_it;
            $variant->type = $request->type;
            $variant->prezzo = str_replace(',','.',$request->prezzo);
            $variant->save();

        }
        catch(\Exception $e){

            return ['result' => 0,'msg' => $e->getMessage()];
        }

        $url = route('cms.varianti');
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
        $variant = Variant::find($id);
        if($variant->products->count() > 0)
        {
            return back()->with('error','La variante non può essere eliminata perchè associata ad alcuni prodotti!');
        }
        $variant->delete();

        return back()->with('success','Elemento cancellato!');
    }


    public function switch_visibility(Request $request)
    {
        $id = $request->id;
        $stato = $request->stato;

        try{
            $item = Variant::find($id);
            $item->visibile = $stato;
            $item->save();
        }
        catch(\Exception $e){

            return ['result' => 0,'msg' => $e->getMessage()];
        }
        return ['result' => 1,'msg' => 'Elemento aggiornato con successo!'];

    }
}