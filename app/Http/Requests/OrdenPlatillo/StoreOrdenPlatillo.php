<?php

namespace App\Http\Requests\OrdenPlatillo;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrdenPlatillo extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            
            'idPlatillo' => 'required|integer',
            'cantidad' => 'required|integer',
            'nota' => 'string|nullable',
            'sabores' => 'array|nullable',
            'sabores.*' => 'string|nullable',
            'aderezos' => 'array|nullable',
            'aderezos.*' => 'string|nullable',

        ];
    }
}
