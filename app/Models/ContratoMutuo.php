<?php

namespace App\Models;

use App\User;
use App\Utils\Helper;
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
        'user_id',

    ];

    public function user(){
        return $this->belongsTo('App\User','user_id', 'id');
    }

    public function relatorio(){
        return $this->hasMany('App\Models\RelatorioMensal','contrato_id', 'id');
    }

    public function search ($filter,$quantidadeItens = 15)
    {
        $relatorio = $this->with('user')->where(function ($query) use ($filter) {
            if (isset($filter['cpf'])){
                $userResult = User::where('cpf',$filter['cpf'])->first();
                $query->where('user_id', $userResult->id);
            }
            if (isset($filter['numero_contrato'])){
                $query->where('numero_contrato', $filter['numero_contrato']);
            }
            if (isset($filter['data'])){
                $query->whereBetween('inicio_mes', Helper::retornaIntervaloDatas($filter['data']));
            }
            if (isset($filter['consultor'])){
                $query->whereIn('user_id', Helper::getUsuarioParent($filter['consultor']));
            }
            if (isset($filter['tipo_contrato'])){
                $query->where('tipo_contrato', $filter['tipo_contrato']);
            }
        })->paginate(10);

        return $relatorio;
    }
}
