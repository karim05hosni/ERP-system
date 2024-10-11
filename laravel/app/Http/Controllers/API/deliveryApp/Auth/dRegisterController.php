<?php

namespace App\Http\Controllers\API\deliveryApp\Auth;

use App\Http\Controllers\Controller;

use App\Http\Requests\API\RegisterRequest;
use App\Http\traits\Api_Response_Trait;
use App\Models\Delivery;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request as FacadesRequest;

class dRegisterController extends Controller
{
    use Api_Response_Trait;
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request )
    {
        $data = $request->except('password', 'device_name');
        $data['password'] = bcrypt($request->password);
        $delivery = Delivery::create($data);
        $delivery->token = "Bearer ".$delivery->createToken($request->device_name)->plainTextToken;
        if ($delivery){
            return response()->json($this->Api_Response(message:'delivery created successfuly!', data:compact('delivery')));
        } else {
            return response()->json($this->Api_Response(message:'delivery created Failed!'));
        }
    }
}
