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
        'tipo_contrato',
        'tipo_contato',
        'inicio_mes',
        'final_mes',
        'numero_contrato',
        'ativo',
        'user_id'
    ];

    public function user(){
        return $this->belongsTo('App\User','user_id', 'id');
    }

    public function relatorio(){
        return $this->hasMany('App\Models\RelatorioMensal','contrato_id', 'id');
    }
}
