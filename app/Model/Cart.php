<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = [
        'shop_id',
        'product_id',
        'nome_prodotto',
        'ingredienti_eliminati',
        'ingredienti_aggiunti',
        'variante',
        'session_id',
        'qta',
        'prezzo',
        'totale'
    ];

    public function user()
    {
        return $this->belongsTo('App\Model\Website\User');
    }

    public function product()
    {
        return $this->belongsTo('App\Model\Product');
    }

    public function products()
    {
        return $this->belongsToMany('App\Model\Product');
    }
}
