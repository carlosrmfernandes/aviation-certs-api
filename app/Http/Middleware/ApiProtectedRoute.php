<?php

namespace App\Http\Middleware;

use Closure;
use Tymon\JWTAuth\Facades\JWTAuth;

class ApiProtectedRoute
{
    public function handle($request, Closure $next)
    {
        try {
            $token = JWTAuth::getToken() ?? $request->query('token');

            if (!$token) {
                return response()->json(['status' => 'Authorization Token not found'], 401);
            }

            JWTAuth::setToken($token)->authenticate();

        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return response()->json(['status' => 'Token is Invalid'], 401);
        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return response()->json(['status' => 'Token has Expired'], 401);
        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
            return response()->json(['status' => 'Authorization Token not found'], 401);
        }

        return $next($request);
    }
}
