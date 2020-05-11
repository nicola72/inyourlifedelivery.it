<?php
namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Controller;
use App\Model\Cms\ClearcmsPassword;
use App\Model\Cms\UserCms;
use http\Client\Curl\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Model\Shop;

class ShopsController extends Controller
{
    public function index()
    {
        $shops = Shop::all();
        $params = [
            'title_page' => 'Negozi affiliati',
            'shops' => $shops
        ];

        return view('cms.shops.index',$params);
    }

    public function create()
    {
        $params = [
            'title_page' => 'Nuovo Negozio',
            'form_name' => 'form_add_shop',
        ];

        return view('cms.shops.create',$params);
    }

    public function store(Request $request)
    {
        try{
            $shop = new Shop();
            $shop->insegna = $request->insegna;
            $shop->ragione_sociale = $request->rag_soc;
            $shop->p_iva = $request->p_iva;
            $shop->domain = $request->domain;
            $shop->citta = $request->citta;
            $shop->indirizzo = $request->indirizzo;
            $shop->nr_civico = $request->nr_civico;
            $shop->provincia = $request->provincia;
            $shop->cap = $request->cap;
            $shop->email = $request->email;
            $shop->sede_legale = $request->sede_legale;

            $shop->save();
        }
        catch(\Exception $e){

            return ['result' => 0,'msg' => $e->getMessage()];
        }

        $url = url('/cms/shops');
        return ['result' => 1,'msg' => 'Elemento inserito con successo!','url' => $url];
    }

    public function users()
    {
        $users = UserCms::where('role_id',2)->where('shop_id','!=',null)->get();

        $params = [
            'title_page' => 'Utenti Negozio',
            'users' => $users,
        ];

        return view('cms.shops.users',$params);
    }

    public function edit_user(Request $request,$id)
    {
        $user = UserCms::find($id);

        $params = [
            'title_page' => 'Modifica Utente '.$user->name,
            'form_name' => 'form_edit_user',
            'user' => $user
        ];

        return view('cms.shops.edit_user',$params);
    }

    public function update_user(Request $request,$id)
    {
        try{

            $user = UserCms::find($id);
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->save();
        }
        catch(\Exception $e){

            return ['result' => 0,'msg' => $e->getMessage()];
        }

        $clear_pwd = ClearcmsPassword::where('user_cms_id',$user->id)->first();
        $clear_pwd->password = $request->password;
        $clear_pwd->save();

        $url = url('/cms/shops/users');
        return ['result' => 1,'msg' => 'Elemento aggiornato con successo!','url' => $url];
    }

    public function destroy_user(Request $request,$id)
    {
        $user = UserCms::find($id);
        $user->delete();

        return back()->with('success','Elemento eliminato con successo!');
    }

    public function edit(Request $request, $id)
    {
        $shop = Shop::find($id);

        $params = [
            'shop' => $shop,
            'title_page' => 'Modifica Negozio '.$shop->ragione_sociale,
            'form_name' => 'form_edit_shop',
        ];

        return view('cms.shops.edit',$params);
    }

    public function update(Request $request, $id)
    {
        try{

            $shop = Shop::find($id);
            $shop->insegna = $request->insegna;
            $shop->ragione_sociale = $request->rag_soc;
            $shop->p_iva = $request->p_iva;
            $shop->domain = $request->domain;
            $shop->citta = $request->citta;
            $shop->indirizzo = $request->indirizzo;
            $shop->nr_civico = $request->nr_civico;
            $shop->provincia = $request->provincia;
            $shop->cap = $request->cap;
            $shop->email = $request->email;
            $shop->sede_legale = $request->sede_legale;

            $shop->save();
        }
        catch(\Exception $e){

            return ['result' => 0,'msg' => $e->getMessage()];
        }

        $url = url('/cms/shops');
        return ['result' => 1,'msg' => 'Elemento aggiornato con successo!','url' => $url];
    }

    public function destroy(Request $request,$id)
    {
        $shop = Shop::find($id);

        //cancello prima tutti gli utenti legati a quel negozio
        $users = UserCms::where('shop_id',$shop->id)->get();
        if($users)
        {
            foreach($users as $user)
            {
                $user->delete();
            }
        }

        $shop->delete();

        return back()->with('success','Elemento eliminato con successo!');
    }
}