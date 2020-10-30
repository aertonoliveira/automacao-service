<?php

namespace App\Http\Requests\Financeiro;

use Illuminate\Foundation\Http\FormRequest;

class StoreContasRequest extends FormRequest
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
        return [
            'tipo_registro' => 'required',
            'tipo_conta' => 'required',
            'titulo' => 'required',
            'valor' => 'required',
            'data_vencimento' => 'required',
            'situacao' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'tipo_registro.required' => 'O Tipo de Registro é obrigatorio',
            'tipo_conta.required' => 'O Tipo de Conta é obrigatorio',
            'titulo.required' => 'O Título é obrigatorio',
            'valor.required' => 'O Valor é obrigatorio',
            'data_vencimento.required' => 'A Data de Vencimento é obrigatoria',
            'situacao.required' => 'A Situação é obrigatoria',
        ];
    }
}
