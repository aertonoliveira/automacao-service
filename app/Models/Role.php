<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = [
        'id',
        'name',
        'label'
    ];

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function permission(){
        return $this->belongsToMany('App\Models\Permission');
    }
}
