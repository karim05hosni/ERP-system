<?php

namespace App\Http\Requests\sub_category;

use Illuminate\Foundation\Http\FormRequest;

class AddSubCategoriesRequest extends FormRequest
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
            'name_en'=>['required', 'string' ,'max:255', 'min:4'],
            'name_ar'=>['required', 'string' ,'max:255', 'min:4'],
            'category_id'=>['required', 'integer', 'exists:category,id' ],
            'status'=>['required', 'integer','between:0,1' ],
        ];
    }
}
