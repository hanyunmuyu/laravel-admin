<?php

namespace App\Http\Middleware;

use Closure;
use Hanyun\Admin\Response;
use Illuminate\Http\Request;

class Admin
{
    use Response;
    
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if ( ! auth('admin')->check()) {
            return $this->error('认证失败', [], 4003);
        }
        
        return $next($request);
    }
}
