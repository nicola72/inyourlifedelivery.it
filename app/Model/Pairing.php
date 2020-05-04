<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class Pairing extends Model implements Sortable
{
    use SortableTrait;

    public $sortable = [
        'order_column_name' => 'order',
        'sort_when_creating' => true,
    ];

    protected $fillable = [
        'id',
        'category_id',
        'style_id',
        'product1_id',
        'product2_id',
        'prezzo',
        'acquistabile',
        'acquistabile_italfama',
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
        'desc_breve_it',
        'desc_breve_en',
        'desc_breve_de',
        'desc_breve_fr',
        'desc_breve_es',
        'desc_breve_ru',
        'visibile',
        'italfama',
        'offerta',
        'novita',
        'order',
        'stato'
    ];

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


    public function cover()
    {
        $images = $this->morphMany('App\Model\File','fileable');
        if($images)
        {
            $images = $images->orderBy('order');
            return $images->first()->path;
        }
        return 'default.jpg';
    }

    public function style()
    {
        return $this->belongsTo('App\Model\Style');
    }

    public function category()
    {
        return $this->belongsTo('App\Model\Category');
    }

    public function product1()
    {
        return $this->belongsTo('App\Model\Product','product1_id');
    }

    public function product2()
    {
        return $this->belongsTo('App\Model\Product','product2_id');
    }

    public function images()
    {
        return $this->morphMany('App\Model\File','fileable');
    }
    
}
