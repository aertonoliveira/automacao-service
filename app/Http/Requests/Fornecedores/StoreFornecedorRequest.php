<?php

namespace App\Http\Requests\Fornecedores;

use Illuminate\Foundation\Http\FormRequest;

class StoreFornecedorRequest extends FormRequest
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
            'nome' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'nome.required' => 'O nome é obrigatorio',
        ];
    }
}
