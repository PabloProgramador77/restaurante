<?php

namespace App\Http\Requests\Ordenes;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrden extends FormRequest
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
            'cantidad' => 'required',

        ];
    }
}
