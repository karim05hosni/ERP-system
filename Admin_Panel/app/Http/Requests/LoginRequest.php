<?php

namespace App\Http\Requests;

use App\Http\traits\Api_Response_Trait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
class LoginRequest extends FormRequest
{
    use Api_Response_Trait;
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
            'email'=>['required', 'email', 'exists:admins'],
            'password'=>['required', 'min:8'],
            'device_name'=>['required']
        ];
    }
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($this->Api_Response(403, 'validation error', $validator->errors())));
    }
}
