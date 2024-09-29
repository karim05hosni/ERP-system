<?php

namespace App\Http\Controllers\Apis\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\traits\Api_Response_Trait;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;


class LoginController extends Controller
{
    //
    use Api_Response_Trait;
    public function login(LoginRequest $request){
        // get user
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
    public function logout(Request $request){
        $authenticated_user = Auth::guard('sanctum')->user();
        $token = $request->header('Authorization');
        $tokenId = substr($token, 7, strpos($token, '|')-7);
        // delete
        $authenticated_user->tokens()->where('id', (int)$tokenId)->delete();
        // $authenticated_user->tokens()->where('id', )->delete();
        return response()->json($this->Api_Response(message: 'Logged out Successfuly From Current Device!'));
    }
    public function logout_all(){
        $authenticated_user = Auth::guard('sanctum')->user();
        $authenticated_user->tokens()->delete();
        return response()->json($this->Api_Response(message: 'Logged out Successfuly From All Devices!'));
    }
}
