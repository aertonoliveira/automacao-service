<?php

namespace App\Models;

use App\Utils\Helper;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject, MustVerifyEmail
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'email_verified_at','user_parent_id',
        'rg', 'data_emissao', 'orgao_emissor', 'cpf', 'data_nascimento',
        'estado_civil', 'nome_mae',  'genero', 'profissao', 'rua', 'numero',
        'bairro', 'cidade', 'estado', 'complemento', 'cep', 'telefone',
        'celular','role_id','avatar'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function search ($filter,$quantidadeItens = 15)
    {
        $relatorio = $this->with('roles','parent','saldoConta')->where(function ($query) use ($filter) {
            if (isset($filter['cpf'])){
                $query->where('cpf',$filter['cpf']);
            }

        })->paginate(10);

        return $relatorio;
    }


    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     * Override the mail body for reset password notification mail.
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new \App\Notifications\MailResetPasswordNotification($token));
    }

    public function roles()
    {
        return $this->belongsToMany(\App\Models\Role::class);
    }



    public function saldoConta()
    {
        return $this->hasMany('App\Models\SaldoConta', 'user_id', 'id');
    }

    public function metaCliente()
    {
        return $this->hasMany('App\Models\MetaCliente', 'user_id', 'id');
    }

    public function comissao()
    {
        return $this->hasMany('App\Models\Comissao', 'user_id', 'id');
    }

    public function documentosClientes()
    {
        return $this->hasMany('App\Models\DocumentosClientes', 'user_id', 'id');
    }


    public function contaBancaria()
    {
        return $this->hasMany('App\Models\ContaBancaria', 'user_id', 'id');
    }

    public function comissaoParent()
    {
        return $this->hasMany('App\Models\Comissao', 'parent_id', 'id');
    }

    public function relatorioMensal()
    {
        return $this->hasMany('App\Models\RelatorioMensal', 'user_id', 'id');
    }

    public function contratoMutuo()
    {
        return $this->hasMany('App\Models\ContratoMutuo', 'user_id', 'id');
    }

    public function parent()
    {
        return $this->belongsTo('App\Models\User', 'user_parent_id');
    }

    public function children()
    {
        return $this->hasMany('App\Models\User', 'user_parent_id');
    }
}
