<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

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
        $user = $request->route('user');
        $loggedInUser = JWTAuth::parseToken()->authenticate();
        
        if ($user->id !== $loggedInUser->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        return $next($request);
    }
}
