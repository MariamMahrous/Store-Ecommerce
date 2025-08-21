<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BrandRequest extends FormRequest
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
          'photo'=>'required_without:id|mimes:jpg,png,jpeg',
          ];
    }


      public function messages()
    {
        return [
            'name.required'=>' الاسم مطلوب ',
            'photo.required'=>' الصورة مطلوبة',
           
            'photo.mimes'=>'يجب اختيار الصورة بصيغة صحيحة',
         
          

        ];
    }
}
