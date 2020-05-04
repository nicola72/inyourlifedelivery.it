<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = [
        'product_id',
        'user_id',
        'session_id',
        'qta'
    ];

    public function user()
    {
        return $this->belongsTo('App\Model\Website\User');
    }

    public function product()
    {
        return $this->belongsTo('App\Model\Product');
    }

    public function products()
    {
        return $this->belongsToMany('App\Model\Product');
    }
}
