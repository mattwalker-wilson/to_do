<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class loggedInUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $requestedUserId = $request->route('user');
        $loggedInUser = JWTAuth::parseToken()->authenticate();

        if (!$requestedUserId) {
            return response()->json(['error' => 'Unauthorized. You need specify route.'], 403);
        }

        if (!$loggedInUser) {
            return response()->json(['error' => 'Unauthorized. You need to log in.'], 403);
        }

        if ($requestedUserId->id === $loggedInUser->id) {
            return $next($request);
        }
        return response()->json(['error' => 'Unauthorized'], 403);
    }
}
