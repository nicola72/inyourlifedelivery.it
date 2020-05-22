<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //decommentare per fare sincronizzazione
    //public $timestamps = false;

    protected $fillable = [
        'id',
        'shop_id',
        'tipo',
        'orario',
        'nome',
        'cognome',
        'email',
        'telefono',
        'note',
        'spese_spedizione',
        'modalita_pagamento',
        'stato_pagamento',
        'idtranspag',
        'importo',
        'locale'
    ];

    public function orderDetails()
    {
        return $this->hasMany('App\Model\OrderDetail');
    }

    public function orderShipping()
    {
        return $this->hasOne('App\Model\OrderShipping');
    }

    public function shop()
    {
        return $this->belongsTo('App\Model\Shop');
    }

    public function user()
    {
        return $this->belongsTo('App\Model\Website\User');
    }

}