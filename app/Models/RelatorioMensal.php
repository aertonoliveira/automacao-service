<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RelatorioMensal extends Model
{
    protected $fillable = [
        'id',
        'user_id',
        'contrato_id',
        'data_referencia',
        'dias_calculados',
        'porcentagem_calculada',
        'porcentagem',
        'valor_contrato',
        'comissao',
        'meta_individual',
        'meta_equipe',
        'pagar_total'

    ];

    public function user(){
        return $this->belongsTo('App\User','user_id', 'id');
    }

    public function contrato(){
        return $this->belongsTo('App\Models\ContratoMutuo','contrato_id', 'id');
    }

    public function search ($filter,$quantidadeItens = 15)
    {
        $relatorio = $this->with('contrato','user.contaBancaria.banco')->where(function ($query) use ($filter) {
            if (isset($filter['id']))
                $query->where('id', $filter['id']);
         
        })->paginate($quantidadeItens);

        return $relatorio;
    }
}
