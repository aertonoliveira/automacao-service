<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocumentosClientes extends Model
{
    protected $fillable = [
        'id',
        'frente_rg',
        'verso_rg',
        'comprovante_residencia',
        'comprovante_pagamento',
        'user_id'
    ];

    public function user(){
        return $this->belongsTo('App\User','user_id', 'id');
    }
}
