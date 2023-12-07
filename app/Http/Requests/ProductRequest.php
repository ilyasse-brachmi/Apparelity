<?php

namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductRequest extends FormRequest
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
            'price'=>['required','string', 'numeric'],
            'description'=>['max:255','string'],
            'production_date' =>'required',
            'company_id' => 'required',
            'category_id' => 'required',


        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'The field must not be empty',
            'price.required' => 'The field must not be empty',
            'production_date.required' => 'The field must not be empty',
            'company_id'=>'The field must not be empty',
            'category_id'=>'The field must not be empty',

        ];
    }
}
