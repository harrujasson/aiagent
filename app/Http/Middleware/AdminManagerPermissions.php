<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Redirect;

class AdminManagerPermissions
{
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();

            $isManager = ($user->role == 2 && strtolower((string) $user->role_type) === 'manager');
            if ($user->isAdmin()) {
                return $next($request);
            }

            if ($isManager) {
                $routeName = optional($request->route())->getName();
                $managerAllowedRoutes = [
                    'admin.profile',
                    'admin.home',
                    'admin.profile-edit',
                    'admin.my_profile_save'
                ];

                if (
                    (is_string($routeName) && str_starts_with($routeName, 'admin.task.')) ||
                    in_array($routeName, $managerAllowedRoutes, true)
                ) {
                    return $next($request);
                }

                $request->session()->flash('error', 'Access restricted to Tasks and Profile only.');
                return Redirect::route('admin.task.manage');
            }
        }

        $request->session()->flash('error', 'Invalid Login');
        return Redirect::route('login');
    }
}
