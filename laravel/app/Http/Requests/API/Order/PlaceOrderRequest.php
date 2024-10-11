<?php

namespace App\Http\Requests\API\Order;

use App\Http\traits\Api_Response_Trait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class PlaceOrderRequest extends FormRequest
{
    use Api_Response_Trait;
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // decode
        $data = json_decode($this->getContent(), true);
        return 
            [
                'products' => 'required',
                'user_id'=> 'required|integer',
                'address' => 'required|string',
                'latitude' => 'required|numeric|between:-90,90',
                'longitude' => 'required|numeric|between:-180,180',
            ];
    }
    
    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator){
        throw new HttpResponseException(response()->json($this->Api_Response(403, 'validation error', $validator->errors())));
    }
}
