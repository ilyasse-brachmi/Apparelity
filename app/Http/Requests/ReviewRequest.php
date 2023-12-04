<?php

namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ReviewRequest extends FormRequest
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
            'f_name' => ['required', 'max:40','string'],
            'l_name'=>['required', 'max:40','string'],
            'description'=>['string','max:255'],
            'email' =>['required','string', 'email', 'max:100'],

        ];
    }

    public function messages()
    {
        return [
            'l_name.required' => 'The field must not be empty',
            'f_name.required' => 'The field must not be empty',
        ];
    }
}
