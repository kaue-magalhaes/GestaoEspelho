<?php

namespace App\Http\Requests\Promotoria;

use App\Rules\Promotoria;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
            'nome'                => ['required', new Promotoria\AnotherSameName()],
            'is_especializada'    => 'required',
            'espelho_id'          => 'required|exists:espelhos,id',
            'promotor_titular_id' => 'required|exists:promotores,id',
            'grupo_promotoria_id' => 'required|exists:grupo_promotorias,id',
        ];
    }
}
