<?php

namespace App\Http\Requests;

use App\Translator;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class TranslatorProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'first_name' => ['required', 'string','max:40'],
            'last_name' => ['required', 'string', 'max:40'],
            'email' => ['required', 'email', Rule::unique((new Translator)->getTable())->ignore(auth()->id()), 'regex:/^(([^<>()\[\]\.,;:\s@\"]+(\.[^<>()\[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i'],
        ];
    }
}
