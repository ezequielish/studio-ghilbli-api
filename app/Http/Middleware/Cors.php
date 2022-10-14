<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Modules\Api\Entities\Cached;

class Cors
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): mixed
    {

        $response = $next($request);

        $response->headers->set('Access-Control-Allow-Origin', '*');
        $response->headers->set('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
        $response->headers->set('Access-Control-Allow-Headers','Origin, X-Requested-With, Content-Type, Accept, Authorization, app, refreshtoken');
        $response->headers->set('Access-Control-Allow-Credentials',true);
        $response->headers->set('Access-Control-Expose-Headers','Token, RefreshToken');

        return $response;
    }
}