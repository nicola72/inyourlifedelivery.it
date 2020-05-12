<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;


class DeliveryDescription extends Model
{
    protected $fillable = [
        'shop_id',
        'desc',
    ];

    public function shop()
    {
        return $this->belongsTo('App\Model\Shop');
    }
}