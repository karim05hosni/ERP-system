<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\LoginRequest;
use App\Http\traits\Api_Response_Trait;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    use Api_Response_Trait;
    public function login(LoginRequest $request){
        $user = User::where('email', $request->email)->first();
        $token = 'Bearer '.$user->createToken($request->device_name)->plainTextToken;
        $user->token = $token;
        // chk password
        if (!$user || ! Hash::check($request->password, $user->password)) {
            return response()->json($this->Api_Response(400, 'Wrong password'));
        }
        // chk if verified
        if (is_null($user->email_verified_at)){
            return response()->json($this->Api_Response(401, 'Not Verified',compact('user')));
        }
        // login
        return response()->json($this->Api_Response(message: 'Loggedin Successfuly!', data: compact('user')));
    }
}
