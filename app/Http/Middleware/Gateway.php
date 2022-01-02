<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Gateway
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $type)
    {
        if (is_string($type)){
            // [0] -> module name
            // [1] -> role id
            $split = explode('|', $type);
            return response()->json($split);
        }
        return $next($request);
    }
}
