<?php

namespace App\Http\Middleware;

use Closure;

class CheckMobile
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
        if (false) {
            $request->offsetSet('ling','测试');
            return $next($request);
        }
        $request->offsetSet('ling','开始');
        return $next($request);
    }
}
