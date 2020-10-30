<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FinanceiroConta extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'id',
        'user_id',
        'registro_id',
        'tipo_registro',
        'tipo_conta',
        'titulo',
        'valor',
        'data_vencimento',
        'situacao',
        'data_pagamento',
        'comprovante',
        'observacoes',
    ];

    protected $table = "fnc_contas";

    protected $dates = ['deleted_at'];
}
