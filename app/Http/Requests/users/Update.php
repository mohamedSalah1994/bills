<?php

namespace App\Http\Requests\users;

use Illuminate\Foundation\Http\FormRequest;

class Update extends FormRequest
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
            'name' => 'required|max:225',
            'email' => 'required',
            'password'  => 'required',


        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'يرجى ادخال اسم المستخدم',
            'email.required' => 'يرجى ادخال البريد الالكترونى',
            'password.required'  => 'يرجى ادخال كلمة المرور'
        ];
    }

}
