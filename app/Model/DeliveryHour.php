<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;


class DeliveryHour extends Model
{
    protected $fillable = [
        'shop_id',
        'start_morning',
        'end_morning',
        'start_afternoon',
        'end_afternoon'
    ];

    public function shop()
    {
        return $this->belongsTo('App\Model\Shop');
    }
}