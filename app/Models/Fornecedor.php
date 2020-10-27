<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Fornecedor extends Model
{
    
    use SoftDeletes;

    protected $fillable = [
        'id',
        'nome',
        'contato',
        'endereco',
        'descricao',
    ];//

    protected $table = 'fornecedores';

    protected $dates = ['deleted_at'];
}

