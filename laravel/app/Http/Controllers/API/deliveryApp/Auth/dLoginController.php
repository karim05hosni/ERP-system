<?php

namespace App\Http\Controllers\API\deliveryApp\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\LoginRequest;
use App\Http\traits\Api_Response_Trait;
use App\Models\Delivery;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class dLoginController extends Controller
{
    use Api_Response_Trait;
    public function login(LoginRequest $request){
        $delivery = Delivery::where('email', $request->email)->first();
        $token = 'Bearer '.$delivery->createToken($request->device_name)->plainTextToken;
        $delivery->token = $token;
        // chk password
        if (!$delivery || ! Hash::check($request->password, $delivery->password)) {
            return response()->json($this->Api_Response(400, 'Wrong password'));
        }
        // chk if verified
        if (is_null($delivery->email_verified_at)){
            return response()->json($this->Api_Response(401, 'Not Verified',compact('user')));
        }
        // login
        return response()->json($this->Api_Response(message: 'Loggedin Successfuly!', data: compact('delivery')));
    }
}
