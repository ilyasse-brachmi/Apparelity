<?php

namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AuthRequest extends FormRequest
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
            'name' => ['required','string'],
            'email' => ['required','email',Rule::unique('users')->ignore($this->route('id'))],
            'password' =>  ['required','string','min:8','max:30'],
            'phone' => ['required','string'],
            ];
    }

    public function messages()
    {
        return [
            'name.required' => 'The field must not be empty',
            'email.required' => 'The field must not be empty',
            'password.required' => 'The field must not be empty',
            'phone.required' => 'The field must not be empty',
        ];
    }
}
