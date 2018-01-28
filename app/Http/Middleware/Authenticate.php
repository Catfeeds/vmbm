<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Authenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @param  string|null $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if(Auth::guard($guard)->guest()) {
            if($request->ajax()|| $request->wantsJson()||$guard=="api") {
                \Log::info('Unauthorized Unauthorized ');
                return response('Unauthorized .', 401);
            } else {
                if($guard == 'admin') {
                    return redirect()->guest('admin/login');
                }
                return redirect()->guest('web/login');
            }
        }

        return $next($request);
    }
}
