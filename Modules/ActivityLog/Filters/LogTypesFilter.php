<?php

namespace Modules\ActivityLog\Filters;

use Closure;
use Illuminate\Database\Eloquent\Builder;

class LogTypesFilter
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
            is_array($request->log_types) && count($request->log_types) > 0,
            fn ($query) => $query->whereIn('log_name', $request->log_types)
        );
    }
}
