<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;


class DeliveryShippingCost extends Model
{
    protected $fillable = [
        'shop_id',
        'cost',
        'to'
    ];

    public function shop()
    {
        return $this->belongsTo('App\Model\Shop');
    }
}