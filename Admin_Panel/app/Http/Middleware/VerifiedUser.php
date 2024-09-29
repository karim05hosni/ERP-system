<?php

namespace App\Http\Middleware;

// use Auth;
use App\Http\traits\Api_Response_Trait;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class VerifiedUser
{
    use Api_Response_Trait;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $authenticatedUser = Auth::guard('sanctum')->user();
        if (is_null($authenticatedUser)){
            return $this->Api_Response(401, 'Not Authenticated', null , compact('authenticatedUser'));
        } elseif (is_null($authenticatedUser->email_verified_at)){
            return $this->Api_Response(401, 'Not Verified', null , compact('authenticatedUser'));
        }
        return $next($request);
    }
}
