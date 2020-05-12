<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class DeliveryStep extends Model
{
    protected $fillable = [
        'shop_id',
        'step',
    ];

    public function shop()
    {
        return $this->belongsTo('App\Model\Shop');
    }
}