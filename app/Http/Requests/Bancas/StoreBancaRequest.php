<?php

namespace App\Http\Requests\Bancas;

use Illuminate\Foundation\Http\FormRequest;

class StoreBancaRequest extends FormRequest
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
            'user_id' => 'required',
            'valor' => 'required',
            'comprovante' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'user_id.required' => 'O trader é obrigatorio',
            'valor.required' => 'O valor é obrigatorio',
            'comprovante.required' => 'O comprovante é obrigatorio',
        ];
    }
}
