<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContaBancaria extends Model
{
    protected $fillable = [
        'id',
        'numero_conta',
        'tipo_conta',
        'agencia',
        'banco_id',
        'user_id'
    ];

    public function user(){
        return $this->belongsTo('App\Models\User','user_id', 'id');
    }

    public function banco(){
        return $this->belongsTo('App\Models\Bancos','banco_id', 'id');
    }
}
