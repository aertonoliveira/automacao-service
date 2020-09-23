<?php

namespace App\Http\Requests\Clientes;

use Illuminate\Foundation\Http\FormRequest;

class StoreCLienteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
//        dd( "echo");
        $validacao = request('tipo_pessoa') == 'F' ? "/^\d{3}\.\d{3}\.\d{3}\-\d{2}$/" : "/^\d{2}\.\d{3}\.\d{3}\/\d{4}\-\d{2}$/";
        return [
            'tipo_pessoa' => 'required',
            'cpf' => 'required|unique:users|regex:'.$validacao,
            'email' => 'required|email|unique:users',
            'name' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'cpf.required' => 'O Documento é obrigatorio',
            'cpf.regex' => 'O formato do documento é invalido',
            'tipo_pessoa.required' => 'O tipo da pessoa é obrigatorio',
            'name.required' => 'O nome completo é obrigatorio',
            'email.required' => 'O e-mail do propriétario é requerido',
            'email.email' => 'O e-mail é inválido',
            'email.unique' => 'Esse E-mail já ta sendo utilizado',
        ];
    }
}
