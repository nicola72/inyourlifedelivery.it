<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class Product extends Model implements Sortable
{
    use SortableTrait;

    public $sortable = [
        'order_column_name' => 'order',
        'sort_when_creating' => true,
    ];

    protected $fillable = [
        'id',
        'shop_id',
        'category_id',
        'codice',
        'omaggio',
        'prezzo',
        'prezzo_scontato',
        'iva',
        'stock',
        'nome_it',
        'nome_en',
        'nome_de',
        'nome_fr',
        'nome_es',
        'nome_ru',
        'desc_it',
        'desc_en',
        'desc_de',
        'desc_fr',
        'desc_es',
        'desc_ru',
        'pranzo',
        'cena',
        'max_aggiunte',
        'con_omaggio',
        'visibile',
        'novita',
        'order',
        'stato'
    ];

    public function shop()
    {
        return $this->belongsTo('App\Model\Shop');
    }

    public function urls()
    {
        return $this->morphMany('App\Model\Url','urlable');
    }

    public function url()
    {
        $locale = \App::getLocale();
        $urls = $this->morphMany('App\Model\Url','urlable');
        $url = $urls->where('locale',$locale)->first();
        $website_config = \Config::get('website_config');
        return $website_config['protocol']."://www.".$url->domain->nome."/".$locale."/".$url->slug;
    }

    public function category()
    {
        return $this->belongsTo('App\Model\Category');
    }

    public function ingredients()
    {
        return $this->belongsToMany('App\Model\Ingredient','ingredient_product');
    }

    //metodo che serve per reperire tutti gli ingredienti della categoria prodotto esclusi quelli già del prodotto
    //quindi che eventualmente si possono aggiungere
    public function ingredienti_da_aggiungere()
    {
        $default_ingredients = $this->belongsToMany('App\Model\Ingredient','ingredient_product')->get();

        $id_arr = [];
        foreach ($default_ingredients as $ing)
        {
            $id_arr[] = $ing->id;
        }

        $cat_ingredients = Ingredient::whereNotIn('id',$id_arr)->where('visibile',1)->where('category_id',$this->category_id)->where('shop_id',$this->shop_id)->get();

        return $cat_ingredients;
    }

    public function variants()
    {
        return $this->belongsToMany('App\Model\Variant','variant_product');
    }

    public function images()
    {
        return $this->morphMany('App\Model\File','fileable');
    }

    public function is_scontato()
    {
        if($this->prezzo_scontato != '0.00' && $this->prezzo_scontato != '')
        {
            return true;
        }
        return false;
    }

    public function cover($shop_id)
    {
        $images = $this->morphMany('App\Model\File','fileable');
        if($images)
        {
            $images = $images->orderBy('order');
            $prima_img = $images->first();
            if(is_object($prima_img))
            {
                return $images->first()->path;
            }
        }


        $shop = Shop::find($shop_id);
        $logo = File::where('fileable_id',$shop->id)->where('fileable_type','App\Model\Shop')->first();
        if(is_object($logo))
        {
            return $logo->path;
        }

        return 'default.jpg';
    }

    public function prezzo_vendita()
    {
        if($this->prezzo_scontato != '0.00')
        {
            return $this->prezzo_scontato;
        }
        return $this->prezzo;
    }

}
