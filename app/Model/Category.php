<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class Category extends Model implements Sortable
{
    use SortableTrait;

    public $sortable = [
        'order_column_name' => 'order',
        'sort_when_creating' => true,
    ];

    protected $fillable = [
        'id',
        'shop_id',
        'macrocategory_id',
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

    public function macrocategory()
    {
        return $this->belongsTo('App\Model\Macrocategory');
    }

    public function product()
    {
        return $this->hasOne('App\Model\Product');
    }

    public function products()
    {
        return $this->hasMany('App\Model\Product');
    }

    public function variants()
    {
        return $this->hasMany('App\Model\Variant');
    }

    public function ingredients()
    {
        return $this->hasMany('App\Model\Ingredient');
    }

    public function shop()
    {
        return $this->belongsTo('App\Model\Shop');
    }

    public function cover()
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

        $user = \Auth::user('cms');
        if($user->role_id != 1)
        {
            $shop = Shop::find($user->shop_id);
            $logo = File::where('fileable_id',$shop->id)->where('fileable_type','App\Model\Shop')->first();
            if(is_object($logo))
            {
                return $logo->path;
            }
        }
        return 'default.jpg';
    }

}
