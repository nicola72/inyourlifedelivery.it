<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;


class DeliveryStripe extends Model
{
    protected $fillable = [
        'shop_id',
        'public_key',
        'secret_key'
    ];

    public function shop()
    {
        return $this->belongsTo('App\Model\Shop');
    }
}