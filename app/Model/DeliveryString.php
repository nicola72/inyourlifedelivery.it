<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class DeliveryString extends Model
{
    protected $fillable = [
        'shop_id',
        'for',
        'text'
    ];

    public function shop()
    {
        return $this->belongsTo('App\Model\Shop');
    }
}