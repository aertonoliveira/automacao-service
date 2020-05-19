<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $fillable = [
        'id',
        'role_id',
        'name',

    ];

    public function roles(){
        return $this->belongsToMany('App\Models\Role');
    }
}
