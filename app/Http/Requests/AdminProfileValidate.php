<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminProfileValidate extends FormRequest
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
          'name' =>'required',
          'email'=>'required|email|unique:admins,email,'.$this->id,
          'password'=>'nullable|confirmed|min:8'
        ];
    }
      public function messages()
    {
        return [
            'name.required'=>' الاسم مطلوب ',
            'email.required'=>'البريد الالكترونى مطلوب',
            'email.email'=>'يجب ادخال البريد الالكترونى بصيغة صحيحة',
            'email.unique'=>'البريد الالكترونى موجود بالفعل',
         
            'password.confirmed'=>'يجب تأكيد كلمة المرور'


        ];
    }
}
