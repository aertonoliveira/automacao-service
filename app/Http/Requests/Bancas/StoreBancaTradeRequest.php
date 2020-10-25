<?php

namespace App\Http\Requests\Bancas;

use Illuminate\Foundation\Http\FormRequest;

class StoreBancaTradeRequest extends FormRequest
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
            'valor_pago' => 'required',
            'comprovante' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'valor_pago.required' => 'O valor pago é obrigatorio',
            'comprovante.required' => 'O comprovante é obrigatorio',
        ];
    }
}
