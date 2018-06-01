<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FileFormRequest extends FormRequest
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
            'file' => 'required|mimes:xslx'
        ];
    }

    public function messages()
    {
        return [
            'file.mimes' => 'Formato de arquivo inválido. Permitido .xslx apenas.',
            'file.required'=>   'Selecione um arquivo .xslx (Excel).'
        ];
    }
}
