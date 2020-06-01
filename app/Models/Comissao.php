<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comissao extends Model
{
    protected $fillable = [
        'id',
        'porcentagem',
        'valor_comissao',
        'parent_id',
        'user_id'
    ];

    public function user(){
        return $this->belongsTo('App\User','user_id', 'id');
    }
    public function parent(){
        return $this->belongsTo('App\User','parent_id', 'id');
    }
}
