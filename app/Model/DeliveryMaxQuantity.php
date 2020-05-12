<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;


class DeliveryMaxQuantity extends Model
{
    protected $fillable = [
        'shop_id',
        'qty',
    ];

    public function shop()
    {
        return $this->belongsTo('App\Model\Shop');
    }
}