<?php

namespace App\Http\Controllers\Cms;

use App\Model\Category;
use App\Model\Material;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $materials = Material::all();
        $params = [
            'title_page' => 'Materiali',
            'materials' => $materials,
        ];
        return view('cms.material.index',$params);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categorie = Category::all();

        $params = [
            'form_name' => 'form_create_material',
            'categorie' => $categorie
        ];
        return view('cms.material.create',$params);
    }


    public function store(Request $request)
    {
        $langs = \Config::get('langs');
        try{
            $material = new Material();
            $category_ids = $request->category_id;
            if(!is_array($category_ids))
            {
                return ['result' => 0,'msg' => 'Errore! Attenzione non hai associato nessuna categoria a questo materiale'];
            }

            //$categoria->macrocategory_id = $request->macrocategory_id;
            foreach ($langs as $lang)
            {
                $material->{'nome_'.$lang} = $request->{'nome_'.$lang};
            }
            $material->per = $request->per;
            $material->save();
            $material_id = $material->id;

            if(count($category_ids) > 0)
            {
                foreach ($category_ids as $category_id)
                {
                    $material->categories()->attach($category_id);
                }
            }

        }
        catch(\Exception $e){

            return ['result' => 0,'msg' => $e->getMessage()];
        }

        $url = url('/cms/material');
        return ['result' => 1,'msg' => 'Elemento inserito con successo!','url' => $url];
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
        $material = Material::find($id);
        $categorie = Category::all();
        $params = [
            'material' => $material,
            'categorie'=> $categorie,
            'form_name' => 'form_edit_material'
        ];

        return view('cms.material.edit',$params);
    }

    public function update(Request $request, $id)
    {
        $langs = \Config::get('langs');
        try{
            $category_ids = $request->category_id;
            if(!is_array($category_ids))
            {
                return ['result' => 0,'msg' => 'Errore! Attenzione non hai associato nessuna categoria a questo materiale'];
            }

            $material = Material::find($id);
            if($material->categories())
            {
                $material->categories()->detach();
            }

            //$categoria->macrocategory_id = $request->macrocategory_id;
            foreach ($langs as $lang)
            {
                $material->{'nome_'.$lang} = $request->{'nome_'.$lang};
            }
            $material->per = $request->per;
            $material->save();
            $material_id = $material->id;

            if(count($category_ids) > 0)
            {
                foreach ($category_ids as $category_id)
                {
                    $material->categories()->attach($category_id);
                }
            }


        }
        catch(\Exception $e){

            return ['result' => 0,'msg' => $e->getMessage()];
        }

        $url = url('/cms/material');
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
        //
    }

    public function move_up(Request $request,$id)
    {
        $cat = Material::find($id);
        $cat->moveOrderUp();
        return back();
    }

    public function move_down(Request $request,$id)
    {
        $cat = Material::find($id);
        $cat->moveOrderDown();
        return back();
    }

    public function switch_stato(Request $request)
    {
        $id = $request->id;
        $stato = $request->stato;

        try{
            $item = Material::find($id);
            $item->stato = $stato;
            $item->save();
        }
        catch(\Exception $e){

            return ['result' => 0,'msg' => $e->getMessage()];
        }
        return ['result' => 1,'msg' => 'Elemento aggiornato con successo!'];

    }
}
