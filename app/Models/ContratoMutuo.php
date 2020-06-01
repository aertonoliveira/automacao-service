<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContratoMutuo extends Model
{
    protected $fillable = [
        'id',
        'porcentagem',
        'valor',
        'tempo_contrato',
        'inicio_mes',
        'final_mes',
        'ativo',
        'user_id'
    ];

    public function user(){
        return $this->belongsTo('App\Models\User','user_id', 'id');
    }
}
