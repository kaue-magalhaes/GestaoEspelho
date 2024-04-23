<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PromotoriaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nome'                => 'required',
            'is_especializada'    => 'required',
            'espelho_id'          => 'required',
            'promotor_titular_id' => 'required',
            'grupo_promotoria_id' => 'required',
        ];
    }
}
