<?php

namespace Modules\User\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class LockScreenMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->user()->setting('screen_locked', false)) {
            return redirect()->route('admin.users.lock_screen.index');
        }

        return $next($request);
    }
}
