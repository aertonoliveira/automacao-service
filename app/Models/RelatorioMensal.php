<?php

namespace App\Models;

use App\Models\User;
use App\Utils\Helper;
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
        'pagar_total',
        'relatorio_mensals'

    ];

    public function user(){
        return $this->belongsTo('App\Models\User','user_id', 'id');
    }

    public function contrato(){
        return $this->belongsTo('App\Models\ContratoMutuo','contrato_id', 'id');
    }

    public function search ($filter)
    {
        $relatorio = $this->with('contrato','user.contaBancaria.banco')->where(function ($query) use ($filter) {
            if (isset($filter['cpf'])){
                $userResult = User::where('cpf',$filter['cpf'])->first();
                $query->where('user_id', $userResult->id);
            }
            if (isset($filter['numero_contrato'])){
                $contratoResult = ContratoMutuo::where('numero_contrato',$filter['numero_contrato'])->first();
                $query->where('contrato_id', $contratoResult->id);
            }
            if (isset($filter['data'])){
//                dd( Helper::retornaIntervaloDatas($filter['data']));
                $query->whereBetween('data_referencia', Helper::retornaIntervaloDatas($filter['data']))->get();
            }
            if (isset($filter['tipo_contrato'])){
                $result = ContratoMutuo::where('tipo_contrato',$filter['tipo_contrato'])->pluck('id');
                $query->whereIn('contrato_id', $result);
            }
        })->paginate(10);

        return $relatorio;
    }
}
