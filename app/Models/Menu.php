<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $fillable = [
        'id',
        'title',
        'type',
        'icon',
        'children',
        'badge',
        'url'
    ];

//    public function user(){
//        return $this->belongsTo('App\Models\User');
//    }
//
//    public function permission(){
//        return $this->belongsToMany('App\Models\Permission');
//    }

    public function subMenu()
    {
        return $this->hasMany(Menu::class, 'children','id');
    }

    public function children()
    {
        return $this->subMenu()->with('children');
    }
}
