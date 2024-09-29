<?php

namespace App\Http\Controllers\Apis\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\VerifyCodeRequest;
use App\Http\traits\Api_Response_Trait;
use App\Mail\Verified;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class EmailVerificationController extends Controller
{
    use Api_Response_Trait;
    public function sendcode(Request $request){
        // token
        $token = $request->header('Authorization');
        // get user
        $authenticated_user = Auth::guard('sanctum')->user();
        // dd($authenticated_user);
        // generate code
        $code = rand(100000, 999999);

        // generate code expiration date
        $expiration_date = date('Y-m-d H:i:s', strtotime('+2 minutes'));
        // $expiration_date = now()->addMinutes(2);
        // dd($expiration_date);

        // set code in DB
        $user = User::find($authenticated_user->id);
        $user->code = $code;
        $user->code_expiration_date = $expiration_date;
        $user->save();
        $user->token = $token;
        // send code to email
        $email = $authenticated_user->email;
        Mail::to($request->user())->send(new Verified($user->code));
        // return user data
        return $this->Api_Response(message:'code sent successfuly', data:compact('user'));
    }
    public function verifyCode(VerifyCodeRequest $request){
        // get token
        $token = $request->header('Authorization');
        // get user
        $authenticated_user = Auth::guard('sanctum')->user();
        // dd($authenticated_user);
        $user_DB = User::find($authenticated_user->id);
        // get code
        $code_in_request = $authenticated_user->code;
        $code_in_db = $user_DB->code;


        // check code in DB
        if ($code_in_db == $code_in_request){
            // check code exp date
            if ($user_DB->code_expiration_date > date('Y-m-d H:i:s')){
                // update email verified at
                $user_DB->email_verified_at = date('Y-m-d H:i:s');
                $user_DB->save();
                $user_DB->token = $token;
                return $this->Api_Response(message: 'Verified!', data: compact('user_DB'));
            } else {
                $user_DB->token = $token;
                return $this->Api_Response(message:'code expired', status:401, data:compact('user_DB'));
            }
        } else {
            $user_DB->token = $token;
            return $this->Api_Response(message:'invalid code', status:401, data: compact('user_DB'));
        }
        
    }
}
