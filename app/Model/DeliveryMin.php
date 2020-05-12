<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class DeliveryMin extends Model
{
    protected $fillable = [
        'shop_id',
        'min',
    ];

    public function shop()
    {
        return $this->belongsTo('App\Model\Shop');
    }
}