<?php

namespace App\Http\Middleware;

use App\Platform;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Core\Providers\RouteServiceProvider;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param  string|null  ...$guards
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                if (Platform::routeEnableDomain()) {
                    $home = RouteServiceProvider::ADMIN_DASHBOARD;
                } else {
                    switch ($guard) {
                        case "web":
                            $home = config('platform.modules.core.config.routes.web.admin.prefix');
                            break;
                    }
                }

                return redirect()->to($home);
            }
        }

        return $next($request);
    }
}
