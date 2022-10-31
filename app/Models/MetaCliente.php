<?php

namespace App\Models;

use App\Models\User;
use App\Utils\Helper;
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
        'user_id',
        'meta_mes',
        'valor_carteira',
        'porcentagem_valor_carteira',
        'meta_atiginda_equipe',
        'valor_parceiro',
        'valor_mes',
        'valor_meta_equipe'
    ];

    public function search ($filter,$quantidadeItens = 15)
    {
        $relatorio = $this->with('user.contaBancaria.banco')->where(function ($query) use ($filter) {
            if (isset($filter['cpf'])){
                $userResult = User::where('cpf',$filter['cpf'])->first();
                $query->where('user_id', $userResult->id);
            }
            if (isset($filter['data'])){
                $query->whereBetween('inicio_mes', Helper::retornaIntervaloDatas($filter['data']));
            }
        })->paginate(10);

        return $relatorio;
    }

    public function user(){
        return $this->belongsTo('App\Models\User','user_id', 'id');
    }
}
