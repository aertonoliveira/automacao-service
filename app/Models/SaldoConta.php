<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaldoConta extends Model
{
    protected $fillable = [
        'id',
        'valor',
        'user_id'
    ];

    public function user(){
        return $this->belongsTo('App\User','user_id', 'id');
    }
}
