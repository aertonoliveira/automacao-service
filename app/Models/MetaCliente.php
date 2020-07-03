<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MetaCliente extends Model
{
    protected $fillable = [
        'id',
        'meta_programada',
        'mata_atingida',
        'mata_faltando',
        'meta_individual',
        'meta_equipe',
        'inicio_mes',
        'final_mes',
        'status',
        'ativo',
        'user_id'
    ];

    public function user(){
        return $this->belongsTo('App\User','user_id', 'id');
    }
}
