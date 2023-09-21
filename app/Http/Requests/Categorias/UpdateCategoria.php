<?php

namespace App\Http\Requests\Categorias;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoria extends FormRequest
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
            
            'categoria' => 'required|min:2',
            'id' => 'required|integer'
            
        ];
    }
}
