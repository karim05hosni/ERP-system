<?php

namespace App\Http\Controllers\API\deliveryApp\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\VerifiyCodeRequest;
use App\Http\traits\Api_Response_Trait;
use App\Mail\Verified as MailVerified;
use App\Models\Delivery;
use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class dEmailVerificationController extends Controller
{
    use Api_Response_Trait;
    public function sendcode(Request $request){
        // token
        $token = $request->header('Authorization');
        // get user
        $authenticated_delivery = Auth::guard('deliveryman')->user();
        // generate code
        $code = rand(100000, 999999);
        // generate code expiration date
        $expiration_date = date('Y-m-d H:i:s', strtotime('+2 minutes'));
        // set code in DB
        $delivery = Delivery::find($authenticated_delivery->id);
        $delivery->code = $code;
        $delivery->code_expiration_date = $expiration_date;
        $delivery->save();
        $delivery->token = $token;
        // send code to email
        $email = $authenticated_delivery->email;
        Mail::to($email)->send(new MailVerified($delivery->code));
        // return user data
        return $this->Api_Response(message:'code sent successfuly', data:compact('delivery'));
    }
    public function verifyCode(Request $request){
        // get token
        $token = $request->header('Authorization');
        // get user
        $authenticated_delivery = Auth::guard('deliveryman')->user();
        // dd($authenticated_delivery);
        $delivery_DB = Delivery::find($authenticated_delivery->id);
        // get code
        $code_in_request = $authenticated_delivery->code;
        $code_in_db = $delivery_DB->code;
        // check code in DB
        if ($code_in_db == $code_in_request){
            // check code exp date
            if ($delivery_DB->code_expiration_date > date('Y-m-d H:i:s')){
                // update email verified at
                $delivery_DB->email_verified_at = date('Y-m-d H:i:s');
                $delivery_DB->save();
                $delivery_DB->token = $token;
                return $this->Api_Response(message: 'Verified!', data: compact('delivery_DB'));
            } else {
                $delivery_DB->token = $token;
                return $this->Api_Response(message:'code expired', status:401, data:compact('delivery_DB'));
            }
        } else {
            $delivery_DB->token = $token;
            return $this->Api_Response(message:'invalid code', status:401, data: compact('delivery_DB'));
        }
        
    }
}
