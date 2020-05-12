<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;


class DeliveryMunic extends Model
{
    protected $fillable = [
        'shop_id',
        'comune'
    ];

    public function shop()
    {
        return $this->belongsTo('App\Model\Shop');
    }
}