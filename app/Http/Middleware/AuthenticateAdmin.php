<?php

namespace App\Http\Middleware;

use Closure,Auth;

class AuthenticateAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @param  string|null $guard
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(Auth::guard('admin')->guest()){
            exit("你没有登录<a target='_parent' href='/admin/logout?returnUrl=" . urlencode('http://'.$_SERVER['HTTP_HOST']) . "'>请登录</a>");
        }
        $path = $request->path();
        if ($path == 'admin') {
            $path = str_replace('admin' ,'/', $path);
        }else{
            $path = str_replace('admin/' ,'', $path);
        }
        $role = session(LOGIN_MARK_SESSION_KEY);
        $user =Auth::guard('admin')->user();
        if(!$user['is_root']) {
            if(!isset($role['role']) || !$role['role']) {
                exit("你没有操作权限<a target='_parent' href='/admin/logout?returnUrl=" . urlencode('http://'.$_SERVER['HTTP_HOST']) . "'>重新登录</a>");
            }
            if(!array_key_exists($path,$role['role'])) {
                exit("你没有操作权限<a target='_parent' href='/admin/logout?returnUrl=" . urlencode('http://'.$_SERVER['HTTP_HOST']) . "'>重新登录</a>");
            }
        }

        return $next($request);
    }
}
