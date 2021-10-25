<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class userAffiliatey
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
        if (Auth::guard('AffUser')->check()) {
            return $next($request);
        }
        return redirect()->route('AffiliateyLogin');
    }
}
