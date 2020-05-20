<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    protected $fillable = [
        'order_id',
        'shop_id',
        'product_id',
        'nome_prodotto',
        'variante',
        'ingredienti_eliminati',
        'ingredienti_aggiunti',
        'qta',
        'prezzo',
        'totale',
    ];

    public function order()
    {
        return $this->belongsTo('App\Model\Order');
    }

    public function product()
    {
        return $this->belongsTo('App\Model\Product');
    }
}