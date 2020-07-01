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

    public function search ($filter)
    {
        $relatorio = $this->with('contrato','user.contaBancaria.banco')->where(function ($query) use ($filter) {
            if (isset($filter['id']))
                $query->where('id', $filter['id']);

            if (isset($filter['titulo']))
                $query->where('titulo', 'LIKE', "%{$filter['titulo']}%");

            if (isset($filter['ativo']))
                $query->where('ativo', $filter['ativo']);

            if (isset($filter['id_marca']))
                $query->where('id_marca', $filter['id_marca']);

            if (isset($filter['id_subgrupo']))
                $query->where('id_subgrupo', $filter['id_subgrupo']);

            if (isset($filter['id_user']))
                $query->where('id_user', $filter['id_user']);

            if (isset($filter['id_arquivo']))
                $query->where('id_arquivo', $filter['id_arquivo']);

            if (isset($filter['quantidade_estoque']))
                $query->where('quantidade_estoque', $filter['quantidade_estoque']);

            if (isset($filter['especificacao']))
                $query->where('especificacao', $filter['especificacao']);
        })
            ->paginate();

        return $relatorio;
    }
}
