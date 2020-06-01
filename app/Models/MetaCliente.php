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
        'inicio_mes',
        'final_mes',
        'status',
        'user_id'
    ];

    public function user(){
        return $this->belongsTo('App\Models\User','user_id', 'id');
    }
}
