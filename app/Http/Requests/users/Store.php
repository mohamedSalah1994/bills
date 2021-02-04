<?php

namespace App\Http\Requests\users;

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
            'name' => 'required|max:225',
            'email' => 'required|unique:users|max:225',
            'password'  => 'required',


        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'يرجى ادخال اسم المستخدم',
            'email.required' => 'يرجى ادخال البريد الالكترونى',
            'email.unique' => 'البريد الالكترونى مسجل مسبقا',
            'password.required'  => 'يرجى ادخال كلمة المرور'
        ];
    }

}
