<?php

namespace Modules\ActivityLog\Filters;

use Closure;
use Illuminate\Database\Eloquent\Builder;

class HttpMethodsFilter
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
            is_array($request->http_methods) && count($request->http_methods) > 0,
            fn ($query) => $query->whereIn('properties->info->http_method', array_map("mb_strtoupper", $request->http_methods))
        );
    }
}
