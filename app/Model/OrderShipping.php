<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class OrderShipping extends Model
{
    protected $fillable = [
        'order_id',
        'shop_id',
        'nome',
        'cognome',
        'email',
        'telefono',
        'indirizzo',
        'nr_civico',
        'comune',
    ];

    public function order()
    {
        return $this->belongsTo('App\Model\Order');
    }
}