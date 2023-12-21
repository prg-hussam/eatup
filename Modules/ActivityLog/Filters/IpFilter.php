<?php

namespace Modules\ActivityLog\Filters;

use Closure;
use Illuminate\Database\Eloquent\Builder;

class IpFilter
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
            !empty($request->ip),
            fn ($query) => $query->where('properties->info->ip', 'LIKE', "%{$request->ip}%")
        );
    }
}
