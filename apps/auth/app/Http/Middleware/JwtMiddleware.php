<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Client\Response;
use Symfony\Component\HttpFoundation\Response as ResponseStatus;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;
use Tymon\JWTAuth\Facades\JWTAuth;
use Exception;

class JwtMiddleware extends BaseMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        try {
            if (! $user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }
        } catch (Exception $e) {
            if ($e instanceof  TokenInvalidException) {
                return response()->json(['error' => true, 'message' => 'Token is Invalid'], ResponseStatus::HTTP_UNAUTHORIZED);
            } elseif ($e instanceof TokenExpiredException) {
                return response()->json(['error' => true, 'message' => 'Token is expired'], ResponseStatus::HTTP_UNAUTHORIZED);
            } else {
                return response()->json(['error' => true, 'message' => 'Token not found'], ResponseStatus::HTTP_UNAUTHORIZED);
            }
        }
//        echo "<pre>";
//        print_r($user);
        return $next($request);
    }
}
