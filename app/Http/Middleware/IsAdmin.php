<?php

namespace App\Http\Middleware;

use Closure;

class IsAdmin
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
        $user = auth()->user();
        
        if (!is_null($user))
        {
            if ($user->type == "admin")
            {
                $request->session()->reflash();
                return $next($request);
            }
        }
        
        return redirect()->route('home');
    }
}
