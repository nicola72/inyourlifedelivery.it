<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class Module extends Model implements Sortable
{
    use SortableTrait;

    public $sortable = [
        'order_column_name' => 'order',
        'sort_when_creating' => true,
    ];

    protected $fillable = [
        'role_id',
        'parent_id',
        'nome',
        'icon',
        'label',
        'label_pizzeria',
        'label_ristorante',
        'label_gelateria',
        'order',
        'stato'
    ];

    public function configs()
    {
        return $this->hasMany('App\Model\ModuleConfig','module_id')->orderBy('nome');
    }
}
