<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BancaTrader extends Model
{
    protected $fillable = [
        'id',
        'banca_id',
        'valor_pago',
        'data_pagamento',
        'comprovante',
        'status'
    ];//

    protected $table = 'bancas_traders';
}
