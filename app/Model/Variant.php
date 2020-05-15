<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;


class Variant  extends Model
{
    protected $fillable = [
        'shop_id',
        'category_id',
        'nome_it',
        'prezzo',
        'visibile'
    ];

    public function shop()
    {
        return $this->belongsTo('App\Model\Shop');
    }

    public function products()
    {
        return $this->belongsToMany('App\Model\Product','variant_product');
    }

    public function category()
    {
        return $this->belongsTo('App\Model\Category');
    }
}