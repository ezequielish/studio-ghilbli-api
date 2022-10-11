<?php

namespace App\Http\Middleware;

class AuthenticateOnceWithBasicAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null, $field = null)
    {
        // $this->auth->guard($guard)->basic($field ?: 'email');
        return $next($request);
        // return Auth::onceBasic() ?: $next($request);
    }

}
