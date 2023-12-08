<?php

namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MaterialRequest extends FormRequest
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
            'name' => ['required','string', 'max:40'],
            'origin'=>['required','string','max:255'],
            'supplier'=>['required','string','max:255'],
            'address' => ['required','string','max:255'],
            'product_id' => 'required',


        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'The field must not be empty',
            'origin.required' => 'The field must not be empty',
            'supplier.required' => 'The field must not be empty',
            'address.required'=>'The field must not be empty',
        ];
    }
}
