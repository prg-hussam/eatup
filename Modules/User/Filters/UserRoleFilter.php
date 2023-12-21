<?php

namespace Modules\User\Filters;

use Closure;
use Illuminate\Database\Eloquent\Builder;

class UserRoleFilter
{
    /**
     * Handle Query
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param \Closure $next;
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function handle(Builder $query, Closure $next): Builder
    {
        $request = request();

        return $next($query)->when(
            is_array($request->roles) && count($request->roles) > 0,
            function ($query) use ($request) {
                $query->whereHas('roles', function ($query) use ($request) {
                    $query->whereIn('id', $request->roles);
                });
            }
        );
    }
}
