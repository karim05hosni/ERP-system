<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;

use App\Http\Requests\API\RegisterRequest;
use App\Http\traits\Api_Response_Trait;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request as FacadesRequest;

class RegisterController extends Controller
{
    use Api_Response_Trait;
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RegisterRequest $request )
    {
        $data = $request->except('password', 'device_name');
        $data['password'] = bcrypt($request->password);
        $user = User::create($data);
        $user->token = "Bearer ".$user->createToken($request->device_name)->plainTextToken;
        if ($user){
            return response()->json($this->Api_Response(message:'user created successfuly!', data:compact('user')));
        } else {
            return response()->json($this->Api_Response(message:'user created Failed!'));
        }
    }
}
