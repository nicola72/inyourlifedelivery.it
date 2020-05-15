<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
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

    public function category()
    {
        return $this->belongsTo('App\Model\Category');
    }

    public function products()
    {
        return $this->belongsToMany('App\Model\Product');
    }
}