<?php

namespace App\Http\Middleware;

use App\Traits\ApiResponse;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserCheck
{
    use ApiResponse;
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $parameter = null): Response
    {
        try {
            JWTAuth::parseToken()->authenticate();
        } catch (TokenExpiredException $e) {
            return $this->errorResponse('Token Expired', 'INVALID_TOKEN', 401);
        } catch (TokenInvalidException $e) {
            return $this->errorResponse('Token Invalid', 'INVALID_TOKEN', 401);
        } catch (\Exception $e) {
            return $this->errorResponse('Token Not Found', 'INVALID_TOKEN', 401);
        }

        if ($parameter && !auth()->guard($parameter)->check()) {
            return $this->errorResponse('You don\'t have access to this resource', 'UNAUTHORIZED', 401);
        }

        return $next($request);
    }
}
