<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Banca extends Model
{
    protected $fillable = [
        'id',
        'user_id',
        'valor',
        'data_pagamento',
        'comprovante',
        'status'
    ];
}
