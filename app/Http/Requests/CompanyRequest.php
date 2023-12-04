<?php

namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CompanyRequest extends FormRequest
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
            'name' => ['required', 'max:40'],
            'address'=>['required', 'max:255'],
            'description'=>['max:255','string'],
            'user_id' => 'required',


        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'The field must not be empty',
            'address.required' => 'The field must not be empty',
            'user_id.required' => 'The field must not be empty',
        ];
    }
}
