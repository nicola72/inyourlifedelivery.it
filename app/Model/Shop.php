<?php

namespace App\Model;
use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    protected $fillable = [
        'dominio',
        'insegna',
        'ragione_sociale',
        'p_iva',
        'indirizzo',
        'nr_civico',
        'citta',
        'provincia',
        'cap',
        'email',
        'sede_legale',
        'domicilio',
        'asporto',
        'stato',

    ];

    public function user()
    {
        return $this->belongsTo('App\Model\Cms\UserCms');
    }

    public function logo()
    {
        $logo = $this->morphMany('App\Model\File','fileable')->first();

        if(is_object($logo))
        {
            return $logo->path;
        }

        return 'default.jpg';
    }

    public function deliveryHour()
    {
        return $this->hasOne('App\Model\DeliveryHour');
    }

    public function deliveryStep()
    {
        return $this->hasOne('App\Model\DeliveryStep');
    }

    public function deliveryOpenDay()
    {
        return $this->hasOne('App\Model\DeliveryOpenDay');
    }

    public function deliveryAvailableTime()
    {
        return $this->hasOne('App\Model\DeliveryAvailableTime');
    }

    public function deliveryMunics()
    {
        return $this->hasMany('App\Model\DeliveryMunic');
    }

    public function deliveryMaxQuantity()
    {
        return $this->hasOne('App\Model\DeliveryMaxQuantity');
    }

    public function deliveryMin()
    {
        return $this->hasOne('App\Model\DeliveryMin');
    }

    public function deliveryPaypal()
    {
        return $this->hasOne('App\Model\DeliveryPaypal');
    }

    public function deliveryStripe()
    {
        return $this->hasOne('App\Model\DeliveryStripe');
    }
}