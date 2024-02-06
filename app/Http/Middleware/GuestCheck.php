<?php

namespace App\Http\Middleware;

use App\Exceptions\NotGuestException;
use Closure;
use Illuminate\Http\Request;

class GuestCheck
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->guard('api-customer')->check() || auth()->guard('api-admin')->check()) {
            throw new NotGuestException();
        }

        return $next($request);
    }
}
