<?php

namespace App\Http\Requests\Mesas;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMesa extends FormRequest
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
            
            'id' => 'required|integer',
            'mesa' => 'required|min:2'
            
        ];
    }
}
