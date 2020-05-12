<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class DeliveryOpenDay extends Model
{
    protected $fillable = [
        'shop_id',
        'lunedi_giorno',
        'lunedi_sera',
        'martedi_giorno',
        'martedi_sera',
        'mercoledi_giorno',
        'mercoledi_sera',
        'giovedi_giorno',
        'giovedi_sera',
        'venerdi_giorno',
        'venerdi_sera',
        'sabato_giorno',
        'sabato_sera',
        'domenica_giorno',
        'domenica_sera',
    ];

    public function shop()
    {
        return $this->belongsTo('App\Model\Shop');
    }
}