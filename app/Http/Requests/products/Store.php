<?php

namespace App\Http\Requests\products;

use Illuminate\Foundation\Http\FormRequest;

class Store extends FormRequest
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
            'product_name' => 'required|max:225',
            'description'  => 'required',
            'section_id' => 'required',


        ];
    }
    public function messages()
    {
        return [
            'product_name.required' => 'يرجى ادخال اسم المنتج',
            'section_id.required' => 'يرجى ادخال اسم القسم',
            'description.required'  => 'يرجى ادخال الوصف'
        ];
    }
}
