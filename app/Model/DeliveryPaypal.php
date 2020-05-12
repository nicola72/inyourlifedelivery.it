<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class DeliveryPaypal extends Model
{
    protected $fillable = [
        'shop_id',
        'email',
    ];

    public function shop()
    {
        return $this->belongsTo('App\Model\Shop');
    }
}