<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubCategoryValidate extends FormRequest
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
            'parent_id' => 'required|exists:categories,id',
           'name' =>'required',
          'slug'=>'required|unique:categories,slug,'.$this->id,       ];
    }


      public function messages()
    {
        return [
            'parent_id.required'=>' القسم مطلوب ',
            'name.required'=>' الاسم مطلوب ',
            'slug.required'=>' الاسم بالرابط مطلوب',
           
            'slug.unique'=>'الاسم بالرابط  موجود بالفعل',
         
          

        ];
    }
}
