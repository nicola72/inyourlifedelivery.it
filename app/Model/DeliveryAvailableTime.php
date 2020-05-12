<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;


class DeliveryAvailableTime extends Model
{
    protected $fillable = [
        'shop_id',
        'time',
    ];

    public function shop()
    {
        return $this->belongsTo('App\Model\Shop');
    }
}