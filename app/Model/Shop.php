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
}