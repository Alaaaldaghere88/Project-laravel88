<?php

namespace App\Http\Middleware;

use App\Traits\BaseResponse;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifyEmail
{
    use BaseResponse;
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
      public function handle(Request $request, Closure $next): Response
    {
     $user=auth()->user();
        if($user->otp)
            return $this->errorResponse("You should verify your account");
        return $next($request);
    }
}
