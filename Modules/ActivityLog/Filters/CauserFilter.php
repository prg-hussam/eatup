<?php

namespace Modules\ActivityLog\Filters;

use Closure;
use Illuminate\Database\Eloquent\Builder;

class CauserFilter
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
            !empty($request->causer_name),
            fn ($query) => $query->whereHas('causer', function ($query) use ($request) {
                $query->where('name', "LIKE", "%{$request->causer_name}%");
            })
        );
    }
}
