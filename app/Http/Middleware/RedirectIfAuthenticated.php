<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                if(Auth::user()->role == "1"){
                    return redirect(route('admin.dashboard'));
                }else if(Auth::user()->role == "2"){
                    if(strtolower((string) Auth::user()->role_type) === 'manager'){
                        return redirect(route('admin.task.manage'));
                    }
                    return redirect(route('staff.dashboard'));
                }else if(Auth::user()->role == "3"){
                   // return redirect(route('customer.dashboard'));
                }
            }
        }

        return $next($request);
    }
}
